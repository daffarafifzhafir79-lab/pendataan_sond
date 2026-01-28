
<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('AKSES DITOLAK! Anda bukan Admin.'); window.location='../page/index.php';</script>";
    exit;
}

include 'koneksi.php';

// Ambil data dari form edit
$kode_surat   = $_POST['kode_surat'] ?? '';
$nama_acara   = $_POST['nama_acara'] ?? '';
$tipe_barang  = $_POST['tipe_barang'] ?? '';
$waktu_acara  = $_POST['waktu_acara'] ?? '';
$tempat_acara = $_POST['tempat_acara'] ?? '';
$keterangan   = $_POST['keterangan'] ?? ''; // <-- Data Keterangan Baru

// Validasi sederhana
if ($kode_surat === '') {
    header("Location: ../page/index.php");
    exit;
}

// Update data di MongoDB berdasarkan kode_surat
$collection->updateOne(
    ['kode_surat' => $kode_surat],
    ['$set' => [
        'nama_acara'   => $nama_acara,
        'tipe_barang'  => $tipe_barang,
        'waktu_acara'  => $waktu_acara,
        'tempat_acara' => $tempat_acara,
        'keterangan'   => $keterangan // <-- Simpan update keterangan
    ]]
);

header("Location: ../page/index.php");
exit;
