<?php
// File: page/buat_user.php
require '../fungsi/koneksi.php'; // Perhatikan tanda titik dua (../)

$usersCollection = $db->selectCollection("users");

// Hapus user lama (reset)
$usersCollection->deleteMany([]);

// 1. Buat User ADMIN
$usersCollection->insertOne([
    'username' => 'admin',
    'password' => 'admin123',
    'role'     => 'admin',
    'nama'     => 'Super Admin'
]);

// 2. Buat User CUSTOMER
$usersCollection->insertOne([
    'username' => 'customer',
    'password' => 'user123',
    'role'     => 'customer',
    'nama'     => 'Pelanggan'
]);

echo "User berhasil dibuat! Silakan hapus file ini dan buka login.php";

?>
