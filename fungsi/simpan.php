<?php
include 'koneksi.php';

$kode_surat   = trim($_POST['kode_surat'] ?? '');
$nama_acara   = trim($_POST['nama_acara'] ?? '');
$tipe_barang  = trim($_POST['tipe_barang'] ?? '');
$waktu_acara  = trim($_POST['waktu_acara'] ?? '');
$tempat_acara = trim($_POST['tempat_acara'] ?? '');
$keterangan   = trim($_POST['keterangan'] ?? ''); // <-- TAMBAHAN 1

$allowed_tipe = ['kecil','sedang','full_rack','indoor'];

// Validasi input (Keterangan boleh kosong, jadi tidak masuk validasi wajib)
if ($kode_surat === '' || $nama_acara === '' || $tipe_barang === '' || $waktu_acara === '' || $tempat_acara === '') {
    echo "<script>alert('Semua field wajib diisi!'); window.location='../page/tambah.php';</script>";
    exit;
}
if (!in_array($tipe_barang, $allowed_tipe, true)) {
    echo "<script>alert('Tipe barang tidak valid!'); window.location='../page/tambah.php';</script>";
    exit;
}

$cek = $collection->findOne(['kode_surat' => $kode_surat]);
if ($cek) {
    echo "<script>alert('GAGAL! Kode surat sudah terdaftar.'); window.location='../page/tambah.php';</script>";
    exit;
}

// Simpan ke MongoDB
$collection->insertOne([
    'kode_surat'   => $kode_surat,
    'nama_acara'   => $nama_acara,
    'tipe_barang'  => $tipe_barang,
    'waktu_acara'  => $waktu_acara,
    'tempat_acara' => $tempat_acara,
    'keterangan'   => $keterangan // <-- TAMBAHAN 2
]);

header("Location: ../page/index.php");
exit;
