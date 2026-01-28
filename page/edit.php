<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Hanya admin yang boleh mengedit!'); window.location='index.php';</script>";
    exit;
}
include '../fungsi/koneksi.php';

if (!isset($_GET['kode_surat'])) {
    header("Location: index.php");
    exit;
}

$kode_surat = $_GET['kode_surat'];
$data = $collection->findOne(['kode_surat' => $kode_surat]);

$page_title = "Edit Perizinan";
$extra_head = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">';
include("../includes/layout_top.php");
?>

<section class="page-header">
  <div>
    <h1>Edit Perizinan</h1>
    <p>Ubah data lalu simpan.</p>
  </div>
</section>

<div class="card-soft p-3">
  <form action="../fungsi/update.php" method="POST">
    <div class="mb-3">
      <label class="form-label">Kode Surat</label>
      <input type="text" name="kode_surat" class="form-control"
             value="<?= htmlspecialchars($data['kode_surat'] ?? '') ?>" readonly>
    </div>

    <div class="mb-3">
      <label class="form-label">Nama Acara</label>
      <input type="text" name="nama_acara" class="form-control"
             value="<?= htmlspecialchars($data['nama_acara'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Tipe Barang</label>
      <?php $tipe = $data['tipe_barang'] ?? ''; ?>
      <select name="tipe_barang" class="form-select" required>
        <option value="">-- Pilih Tipe --</option>
        <option value="kecil"     <?= $tipe==='kecil'?'selected':'' ?>>Kecil</option>
        <option value="sedang"    <?= $tipe==='sedang'?'selected':'' ?>>Sedang</option>
        <option value="full_rack" <?= $tipe==='full_rack'?'selected':'' ?>>Full Rack</option>
        <option value="indoor"    <?= $tipe==='indoor'?'selected':'' ?>>Indoor</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Waktu Acara</label>
      <input type="datetime-local" name="waktu_acara" class="form-control"
             value="<?= htmlspecialchars($data['waktu_acara'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Tempat Acara</label>
      <input type="text" name="tempat_acara" class="form-control"
             value="<?= htmlspecialchars($data['tempat_acara'] ?? '') ?>" required>
    </div>
    
    <div class="mb-3">
      <label class="form-label">Keterangan</label>
      <textarea name="keterangan" class="form-control" rows="3"><?= htmlspecialchars($data['keterangan'] ?? '') ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update Data</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
  </form>
</div>

<?php include("../includes/layout_bottom.php"); ?>
