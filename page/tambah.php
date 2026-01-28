<?php
$page_title = "Tambah Data";
$extra_head = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">';
include("../includes/layout_top.php");
?>

<section class="page-header">
    <div>
        <h1>Tambah Perizinan</h1>
        <p>Isi form di bawah untuk menyimpan data baru.</p>
    </div>
</section>

<div class="card-soft p-3">
    <form action="../fungsi/simpan.php" method="POST">
  <div class="mb-3">
    <label class="form-label">Kode Surat</label>
    <input type="text" name="kode_surat" class="form-control" required placeholder="Contoh: SND-2026-001">
  </div>

  <div class="mb-3">
    <label class="form-label">Nama Acara</label>
    <input type="text" name="nama_acara" class="form-control" required placeholder="Contoh: Konser Kampus">
  </div>

  <div class="mb-3">
    <label class="form-label">Tipe Barang</label>
    <select name="tipe_barang" class="form-select" required>
      <option value="">-- Pilih Tipe --</option>
      <option value="kecil">Kecil</option>
      <option value="sedang">Sedang</option>
      <option value="full_rack">Full Rank</option>
      <option value="indoor">Indoor</option>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Waktu Acara</label>
    <input type="datetime-local" name="waktu_acara" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Tempat Acara</label>
    <input type="text" name="tempat_acara" class="form-control" required placeholder="Contoh: Aula Gedung A">
  </div>

  <div class="mb-3">
    <label class="form-label">Keterangan</label>
    <textarea name="keterangan" class="form-control" rows="3" placeholder="Tambahkan catatan khusus (opsional)..."></textarea>
  </div>

  <button type="submit" class="btn btn-success">Simpan Data</button>
  <a href="index.php" class="btn btn-secondary">Kembali</a>
</form>

</div>

<?php include("../includes/layout_bottom.php"); ?>
