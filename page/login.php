<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek koneksi path
if (!file_exists('../fungsi/koneksi.php')) {
    // Jika error, pastikan folder fungsi ada sejajar dengan folder page
    die('<div class="alert alert-danger">FATAL ERROR: File <b>../fungsi/koneksi.php</b> tidak ditemukan!</div>');
}
include '../fungsi/koneksi.php'; 

$pesan_debug = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        if (!isset($db)) {
            throw new Exception("Variabel database (\$db) tidak ditemukan. Cek koneksi.php");
        }

        $usersCollection = $db->selectCollection("user");
        $user = $usersCollection->findOne(['username' => $username]);

        if (!$user) {
            $pesan_debug = "❌ User <b>'$username'</b> tidak ditemukan.";
        } else {
            if ($user['password'] === $password) {
                $_SESSION['login']    = true;
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']     = $user['role'];
                $_SESSION['nama']     = $user['nama'];
                
                echo "<script>alert('Login Sukses! Selamat datang " . $user['nama'] . "'); window.location='index.php';</script>";
                exit;
            } else {
                $pesan_debug = "❌ Password SALAH.";
            }
        }
    } catch (Exception $e) {
        $pesan_debug = "❌ SYSTEM ERROR: " . $e->getMessage();
    }
}
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login System</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
    /* --- PERBAIKAN BACKGROUND --- */
    .bg-blur {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        
        /* PERHATIKAN PATH INI: Cukup naik satu folder (../) lalu masuk assets */
        background-image: url('../assets/img/unida.jpg');
        
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        
        /* Efek Blur */
        filter: blur(8px);
        -webkit-filter: blur(8px);
        
        /* Scale diperbesar agar pinggiran blur tidak terlihat putih */
        transform: scale(1.1);
        z-index: -1; 
    }

    /* Style Kartu Login */
    .card-login {
        width: 400px;
        background: rgba(255, 255, 255, 0.85); /* Putih Transparan */
        backdrop-filter: blur(5px);
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.5);
    }
    
    body {
        overflow: hidden; /* Hilangkan scrollbar */
    }
  </style>
</head>

<body class="d-flex align-items-center justify-content-center" style="height: 100vh;">
  
  <div class="bg-blur"></div>
  
  <div class="card p-4 card-login">
    <h3 class="text-center mb-4 fw-bold">Login System</h3>
    
    <?php if($pesan_debug): ?>
        <div class="alert alert-danger p-2" style="font-size: 0.9rem;">
            <?= $pesan_debug ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
      <div class="mb-3">
        <label class="form-label fw-bold">Username</label>
        <input type="text" name="username" class="form-control" required placeholder="admin" value="admin">
      </div>
      
      <div class="mb-3">
        <label class="form-label fw-bold">Password</label>
        <input type="password" name="password" class="form-control" required placeholder="admin123" value="admin123">
      </div>
      
      <button type="submit" name="login" class="btn btn-primary w-100 fw-bold mt-2">Masuk</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
