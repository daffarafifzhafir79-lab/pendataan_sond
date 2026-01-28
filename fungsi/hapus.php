<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses Ditolak! Anda bukan Admin.'); window.location='../page/index.php';</script>";
    exit;
}

include 'koneksi.php';
// ... lanjut kode hapus seperti sebelumnya ...
