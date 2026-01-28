<?php
$page_title = "Tentang Kami";
include("../includes/layout_top.php");
?>

<section class="page-header">
  <div>
    <h1>Tentang Aplikasi</h1>
    <p>Informasi singkat tentang aplikasi dan tim pengembang.</p>
  </div>
</section>

<article class="section-card">
  <header class="section-card__header">
    <h2>Profil Aplikasi</h2>
  </header>
  <div class="section-card__body">
    <p class="app-about
    ">
      Aplikasi ini digunakan untuk pendataan perizinan/agenda acara, meliputi nama acara,
      tempat, waktu, tipe barang, dan keterangan. Tujuan sistem adalah mempermudah proses input,
      pemantauan jadwal, serta pengelolaan data.
    </p>

    <div class="about-bullets">
      <div><strong>Fitur Utama</strong><br>Tambah, Edit, Hapus data perizinan</div>
      <div><strong>Database</strong><br>MongoDB</div>
      <div><strong>Teknologi</strong><br>PHP + Bootstrap + CSS</div>
      <div><strong>Output</strong><br>Riwayat data dan jadwal hari ini/besok</div>
    </div>
  </div>
</article>

<article class="section-card">
  <header class="section-card__header">
    <h2>Contact service</h2>
  </header>
<div class="dev-grid">

  <div class="dev-card dev-card--clean">
    <img class="dev-photo dev-photo--round" src="../assets/img/developer/dev1.jpg" alt="Developer 1">
    <div class="dev-info">
      <div class="dev-top">
        <h3>DIMAS DIRGANTARA </h3>
        <span class="dev-badge">087805470745</span>
      </div>
      
    </div>
  </div>

 

</article>

<?php include("../includes/layout_bottom.php"); ?>
