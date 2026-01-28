<?php
require __DIR__ . '/../vendor/autoload.php';

try {
    $client = new MongoDB\Client(
        "mongodb://127.0.0.1:27017",
        [
            "serverSelectionTimeoutMS" => 2000,
            "connectTimeoutMS" => 2000
        ]
    );

    // Tes koneksi
    $client->selectDatabase("admin")->command(["ping" => 1]);

    // DATABASE
    $db = $client->selectDatabase("pendataan_seo");

    // COLLECTION UTAMA (riwayat surat)
    $collection = $db->selectCollection("riwayat_perizinan"); // <- INI PENTING (biar index.php tidak error)

    // COLLECTION INVENTARIS (untuk halaman List Barang Acara)
    // Struktur dokumen: { nama, qty, satuan, kategori_acara: ["acara_kecil", ...] }
    $collection_inventaris = $db->selectCollection("inventaris");

    // OPTIONAL: helper untuk ambil collection barang berdasarkan tipe
    function getCollectionBarang($db, $tipe){
        $map = [ 
    'full_rack'    => 'Acara_full_rack',
    'indoor'       => 'Acara_indoor',
    'acara_kecil'  => 'Acara_kecil',
    'acara_sedang' => 'Acara_sedang',
    ];
    if (!isset($map[$tipe])) return null;
    return $db->selectCollection($map[$tipe]);
}


} catch (Throwable $e) {
    die(
        "<h3>Gagal konek MongoDB</h3>" .
        "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>"
    );
}
