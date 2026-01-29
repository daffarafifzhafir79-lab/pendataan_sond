<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses Ditolak! Anda bukan Admin.'); window.location='../page/index.php';</script>";
    exit;
}

include 'koneksi.php';
if (isset($_GET['kode_surat'])) {
    $kode_surat = $_GET['kode_surat'];

    try {
            
        $result = $collection->deleteOne(['kode_surat' => $kode_surat]);
       

    } catch (Exception $e) {
        echo "Gagal menghapus: " . $e->getMessage();
        exit;
    }
}

header("Location: ../page/index.php");
exit;
?>

