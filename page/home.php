<?php
$page_title = "Dashboard";
include("../includes/layout_top.php");

// ambil koneksi & collection MongoDB
include("../fungsi/koneksi.php");

// tanggal hari ini & besok (format: YYYY-MM-DD)
date_default_timezone_set("Asia/Jakarta");
$today = date("Y-m-d");
$tomorrow = date("Y-m-d", strtotime("+1 day"));

// karena waktu_acara tersimpan sebagai string "YYYY-MM-DDTHH:MM",
// kita filter pakai Regex prefix tanggal
$todayData = $collection->find(
  ['waktu_acara' => new MongoDB\BSON\Regex("^{$today}")],
  ['sort' => ['waktu_acara' => 1]]
);

$tomorrowData = $collection->find(
  ['waktu_acara' => new MongoDB\BSON\Regex("^{$tomorrow}")],
  ['sort' => ['waktu_acara' => 1]]
);

// helper buat ambil jam saja dari "YYYY-MM-DDTHH:MM"
function onlyTime($datetimeStr){
  if (!$datetimeStr) return "-";
  // contoh: 2026-01-25T20:00 -> 20:00
  $parts = explode("T", $datetimeStr);
  return $parts[1] ?? $datetimeStr;
}
?>

<section class="page-header">
  <div>
    <h1>Beranda</h1>
  </div>
</section>
<br><br>
<div>
  <h2>Selamat datang di Peminjaman Sound System SEO UNIDA Gontor</h2>
  <p>Ringkasan jadwal acara hari ini dan besok.</p>
</div>

<section class="schedule-grid">

  <!-- KARTU HARI INI -->
  <article class="section-card">
    <header class="section-card__header">
      <h2>Jadwal Hari Ini (<?= htmlspecialchars($today) ?>)</h2>
    </header>

    <div class="section-card__body">
      <div class="table-responsive">
        <div class="table-wrap">

            <table class="table table-sm table-bordered align-middle mb-0">
              <thead>
                <tr>
                  <th>Nama Acara</th>
                  <th>Tempat</th>
                  <th>Kategori Acara</th>
                  <th>Jam</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $hasToday = false;
                  foreach ($todayData as $row):
                    $hasToday = true;
                ?>
                  <tr>
                    <td><?= htmlspecialchars($row['nama_acara'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['tempat_acara'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['tipe_barang'] ?? '-') ?></td>
                    <td><?= htmlspecialchars(onlyTime($row['waktu_acara'] ?? '-')) ?></td>
                  </tr>
                <?php endforeach; ?>
    
                <?php if (!$hasToday): ?>
                  <tr>
                    <td colspan="3" class="text-center text-muted">Belum ada acara untuk hari ini.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </article>

  <!-- KARTU BESOK -->
  <article class="section-card">
    <header class="section-card__header">
      <h2>Jadwal Besok (<?= htmlspecialchars($tomorrow) ?>)</h2>
    </header>

    <div class="section-card__body">
      <div class="table-responsive">
        <div class="table-wrap">
        <table class="table table-sm table-bordered align-middle mb-0">
          <thead>
            <tr>
              <th>Nama Acara</th>
              <th>Tempat</th>
              <th>Kategori Acara</th>
              <th>Jam</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $hasTomorrow = false;
              foreach ($tomorrowData as $row):
                $hasTomorrow = true;
            ?>
              <tr>
                <td><?= htmlspecialchars($row['nama_acara'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['tempat_acara'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['tipe_barang'] ?? '-') ?></td>
                <td><?= htmlspecialchars(onlyTime($row['waktu_acara'] ?? '-')) ?></td>
              </tr>
            <?php endforeach; ?>

            <?php if (!$hasTomorrow): ?>
              <tr>
                <td colspan="3" class="text-center text-muted">Belum ada acara untuk besok.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </article>

</section>

<?php include("../includes/layout_bottom.php"); ?>
