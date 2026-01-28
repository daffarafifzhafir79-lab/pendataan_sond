<?php
// File: buat_user_sementara.php
include '../fungsi/koneksi.php'; // Pastikan path koneksi benar

$usersCollection = $db->selectCollection("users");

// Hapus user lama jika ada (biar tidak duplikat saat refresh)
$usersCollection->deleteMany([]);

// Buat Admin
$usersCollection->insertOne([
    'username' => 'admin',
    'password' => 'admin123', // Nanti kita cek string biasa dulu untuk kemudahan
    'role'     => 'admin',
    'nama'     => 'Administrator'
]);

// Buat Customer
$usersCollection->insertOne([
    'username' => 'mahasiswa',
    'password' => 'user123',
    'role'     => 'peminjam',
    'nama'     => 'mahasiswa'
]);

echo "User berhasil dibuat! Silakan hapus file ini dan coba login.";
?>
