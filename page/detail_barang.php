<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// koneksi MongoDB (menyediakan: $collection_inventaris)
include "../fungsi/koneksi.php";

// Title Case untuk UI: huruf awal setiap kata besar
function title_case(string $text): string {
    $text = trim($text);
    if ($text === '') return '';
    // rapikan spasi
    $text = preg_replace('/\s+/', ' ', $text);
    // lower dulu biar konsisten
    $text = strtolower($text);
    return ucwords($text);
}

// Normalisasi nama untuk pencocokan kebutuhan per kategori
function norm_name(string $text): string {
    $t = strtolower(trim($text));
    // samakan beberapa istilah umum
    $t = str_replace('cable', 'kabel', $t);
    $t = str_replace(['out door', 'outdoor'], 'outdoor', $t);
    $t = str_replace('active', '', $t);
    $t = str_replace('cannon', 'canon', $t);
    $t = str_replace(['rool', 'rool'], 'roll', $t);
    $t = str_replace(['aoutor', 'aoutdoor'], 'outdoor', $t);
    $t = str_replace(['subwoffer','subwoofer'], 'subwoofer', $t);
    $t = str_replace(['speak on','speakon'], 'speakon', $t);
    $t = str_replace(['stande', 'stander'], 'stander', $t);
    // buang ukuran/angka yang sering bikin nama tidak match (24v, 200m, 50 watt, dll)
    $t = preg_replace('/\b\d+\s*(m|watt|v)?\b/', '', $t);
    $t = preg_replace('/\s+/', ' ', $t);
    // buang karakter non-alfanumerik
    $t = preg_replace('/[^a-z0-9 ]+/', '', $t);
    // hilangkan spasi untuk jadi key
    return str_replace(' ', '', $t);
}

// Ambil "qty kebutuhan" per kategori dari file paket (fungsi/daftar_barang.php)
// Ini solusi cepat tanpa merombak struktur MongoDB.
$paket = @include __DIR__ . '/../fungsi/daftar_barang.php';
$kebutuhanMap = [];
if (is_array($paket)) {
    foreach ($paket as $k => $items) {
        if (!is_string($k) || !is_array($items)) continue;
        // hanya kategori acara (bukan list stok)
        if (in_array($k, ['acara_kecil','acara_sedang','fullrank','indoor'], true)) {
            foreach ($items as $it) {
                $nm = isset($it['nama']) ? (string)$it['nama'] : '';
                $q  = isset($it['qty']) ? (int)$it['qty'] : 0;
                if ($nm === '') continue;
                $kebutuhanMap[$k][norm_name($nm)] = $q;
            }
        }
    }
}

// kategori yang dipilih (slug: acara_kecil, acara_sedang, fullrank, indoor)
$kategoriDipilih = $_GET['kategori'] ?? '';
$kategoriDipilih = is_string($kategoriDipilih) ? trim($kategoriDipilih) : '';

// ambil list kategori dari DB supaya dropdown selalu mengikuti data
try {
    $kategoriList = $collection_inventaris->distinct('kategori_acara');
    if (!is_array($kategoriList)) $kategoriList = [];
    // buang nilai kosong/null
    $kategoriList = array_values(array_filter($kategoriList, function($k){
        return is_string($k) && trim($k) !== '';
    }));
    sort($kategoriList);
} catch (Throwable $e) {
    $kategoriList = ['acara_kecil','acara_sedang','fullrank','indoor'];
}

// query list barang
$filter = [];
if ($kategoriDipilih !== '') {
    $filter = ['kategori_acara' => $kategoriDipilih];
}

$cursor = $collection_inventaris->find($filter, [
    'sort' => ['nama' => 1]
]);

$page_title = "List Barang Acara";
include '../includes/layout_top.php';
?>

<section class="page-header d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1>List Barang Acara</h1>
    <p>
      Default menampilkan <b>semua</b> barang inventaris.
      Pilih kategori untuk memfilter daftar.
    </p>
  </div>
</section>

<article class="section-card">
  <header class="section-card__header">
    <h2>Filter Kategori</h2>
  </header>

  <div class="section-card__body">
    <form method="GET" class="row g-2 align-items-end">
      <div class="col-md-6">
        <label class="form-label fw-bold">Kategori Acara</label>
        <select name="kategori" class="form-select">
          <option value="" <?= $kategoriDipilih==='' ? 'selected' : '' ?>>-- Semua Kategori --</option>
          <?php foreach ($kategoriList as $k): ?>
            <?php
              $label = ucwords(str_replace('_',' ', $k));
            ?>
            <option value="<?= htmlspecialchars($k) ?>" <?= $kategoriDipilih===$k ? 'selected' : '' ?>>
              <?= htmlspecialchars($label) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <button class="btn btn-primary w-100" type="submit">Tampilkan</button>
      </div>

      <div class="col-md-3">
        <a class="btn btn-secondary w-100" href="detail_barang.php">Reset</a>
      </div>
    </form>
  </div>
</article>

<article class="section-card mt-3">
  <header class="section-card__header">
    <h2>
      <?= $kategoriDipilih !== ''
          ? 'Daftar Barang: ' . htmlspecialchars(ucwords(str_replace('_',' ', $kategoriDipilih)))
          : 'Semua Barang Inventaris'; ?>
    </h2>
  </header>

  <div class="section-card__body">
    <div class="table-wrap">
      <table class="table mb-0">
        <thead>
          <tr>
            <th style="width:60px;">No</th>
            <th>Nama Barang</th>
            <th style="width:180px;">
              <?= $kategoriDipilih !== '' ? 'Kebutuhan' : 'Stock' ?>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; $ada = false; ?>
          <?php foreach ($cursor as $row): ?>
            <?php
              $nama = title_case((string)($row['nama'] ?? ''));
              $qtyStok = (int)($row['qty'] ?? 0);
              $kategori = $row['kategori_acara'] ?? [];
              if (!is_array($kategori)) $kategori = [];
              $kategoriLabel = array_map(function($k){
                  return ucwords(str_replace('_',' ', (string)$k));
              }, $kategori);

              // qty yang ditampilkan:
              // - jika sedang filter kategori: tampilkan qty kebutuhan (dari paket) bila tersedia
              // - jika tidak filter: tampilkan qty stok
              $qtyTampil = $qtyStok;
              if ($kategoriDipilih !== '') {
                  $key = norm_name((string)($row['nama'] ?? ''));
                  $qtyTampil = isset($kebutuhanMap[$kategoriDipilih][$key])
                      ? (int)$kebutuhanMap[$kategoriDipilih][$key]
                      : 0;
                  // kalau tidak ada di paket kategori, jangan tampilkan item-nya (biar tidak membingungkan)
                  if ($qtyTampil === 0) {
                      continue;
                  }
              }

              $ada = true;
            ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($nama !== '' ? $nama : '-') ?></td>
              <td>
                <span class="qty-badge"><?= htmlspecialchars((string)$qtyTampil) ?></span>
                <?php if ($kategoriDipilih !== ''): ?>
                  <small class="text-muted d-block">Stok: <?= htmlspecialchars((string)$qtyStok) ?></small>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>

          <?php if (!$ada): ?>
            <tr>
              <td colspan="4">
                <div class="alert alert-warning mb-0">
                  Tidak ada barang untuk filter ini.
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</article>

<?php include '../includes/layout_bottom.php'; ?>
