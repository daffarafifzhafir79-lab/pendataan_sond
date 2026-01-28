<?php
session_start();
// Aktifkan laporan error agar terlihat jika ada masalah kode
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek koneksi path
if (!file_exists('../fungsi/koneksi.php')) {
    die("FATAL ERROR: File '../fungsi/koneksi.php' tidak ditemukan! Cek struktur folder Anda.");
}
include '../fungsi/koneksi.php'; 

$pesan_debug = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Cek koneksi database
        if (!isset($db)) {
            throw new Exception("Variabel \$db tidak ditemukan. Cek file koneksi.php");
        }

        $usersCollection = $db->selectCollection("user");
        $user = $usersCollection->findOne(['username' => $username]);

        // --- AREA DEBUGGING (Akan muncul di layar) ---
        if (!$user) {
            $pesan_debug = "❌ User '$username' TIDAK DITEMUKAN di database.";
        } else {
            // User ketemu, cek password
            if ($user['password'] === $password) {
                // SUKSES
                $_SESSION['login']    = true;
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']     = $user['role'];
                $_SESSION['nama']     = $user['nama'];
                
                echo "<script>alert('Login Sukses! Selamat datang " . $user['nama'] . "'); window.location='index.php';</script>";
                exit;
            } else {
                $pesan_debug = "❌ Password SALAH. <br>Input: '$password' <br>Database: '" . $user['password'] . "'";
            }
        }

    } catch (Exception $e) {
        $pesan_debug = "❌ ERROR SYSTEM: " . $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Login Debug</title>
  <link rel="stylesheet" href="../assets/css/css_style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
    /* CSS Tambahan untuk Background Blur */
    .bg-blur-image {
        position: fixed;    /* Supaya gambar tetap di posisi saat di-scroll */
        top: 0;
        left: 0;
        width: 100%;        /* Lebar memenuhi layar */
        height: 100%;       /* Tinggi memenuhi layar */
        object-fit: cover;  /* Gambar tidak gepeng (proporsional) */
        z-index: -1;        /* Menaruh gambar di belakang form login */
        filter: blur(8px);  /* Efek BLUR (semakin besar angka, semakin blur) */
        -webkit-filter: blur(8px); /* Support untuk browser lama */
        transform: scale(1.1); /* Sedikit diperbesar agar pinggiran blur tidak terlihat putih */
    }

    /* Opsi Tambahan: Overlay gelap supaya teks lebih terbaca */
    .bg-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4); /* Warna hitam transparan 40% */
        z-index: -1;
    }
  </style>
</head>

<body class="text-white d-flex align-items-center justify-content-center" style="height: 100vh; overflow: hidden;">
  
  <img src="../assets/img/unida.jpg" alt="Background Unida" class="bg-blur-image">
  
  <div class="bg-overlay"></div>

  <div class="card p-4 text-dark shadow-lg" style="width: 400px; z-index: 1;">
    <h3 class="text-center mb-3">Login System</h3>
    
    <?php if(isset($pesan_debug) && $pesan_debug): ?>
        <div class="alert alert-danger" style="font-size: 0.9rem;">
            <strong>Diagnosa Masalah:</strong><br>
            <?= $pesan_debug ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
      <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required value="admin">
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required value="admin123">
      </div>
      <button type="submit" name="login" class="btn btn-primary w-100">Coba Masuk</button>
    </form>
    
    <div class="mt-3 text-center small text-muted">
       </div>
  </div>

</body>
</html>