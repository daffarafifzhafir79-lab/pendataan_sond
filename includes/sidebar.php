<?php
$current = basename($_SERVER['PHP_SELF']);

function active($file, $current) {
  return $file === $current ? 'active' : '';
}
?>

<aside class="sidebar">
  <div class="brand">
    <div class="brand-left">
      <span class="brand-title">SEO</span>
    </div>
    <div class="brand-icon">
        <img src="../assets/img/SEO.png" alt="">
    </div>
  </div>

  <nav class="nav">
    <a class="<?= active('home.php', $current) ?>" href="home.php">Beranda</a>
    <a class="<?= active('tambah.php', $current) ?>" href="tambah.php">Tambah Perizinan</a>
    <a class="<?= active('index.php', $current) ?>" href="index.php">Riwayat Surat</a>
    <a class="<?= active('detail_barang.php', $current) ?>" href="detail_barang.php">list Barang Acara</a>
</nav>

<div class="sidebar-footer">
      <a class="<?= active('about.php', $current) ?>" href="about.php">Tentang kami</a>
    <a href="../includes/logout.php" onclick="return confirmLogout()">Logout</a>
  </div>
</aside>
