    <?php 
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
 ?>

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sound Event Organizer</title>

    <!-- Menambahkan font dari Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <link rel="icon" class="title-logo" type="image/webp" href="../assets/images/gambar-parkir.webp">
<link rel="stylesheet" href="../assets/css/css_style.css">

</head>

<header>
    <nav>
        <div class="logo">
            <h1>SEO</h1>
            <img src="..\assets\img\SEO.png" alt="" class ="logo-image">
        </div>
        <ul>
            <li><a href="dashboard.php">Beranda</a></li>
            <li><a href="tambah-kendaraan.php">Tambah Perizinan</a></li>
            <li><a href="parkiran.php">Isi Biodata</a></li>
            <li><a href="riwayat-transaksi.php">Riwayat Surat</a></li>
        </ul>
        
        <div class="bottom-nav">
            <ul>
                <li><a href="about.php">Tentang Kami</a></li>
                <li><a href="../includes/logout_process.php" onclick="return confirmLogout()">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>
