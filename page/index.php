    <?php
    session_start(); // <--- WAJIB ADA DI BARIS PERTAMA
    if (!isset($_SESSION['login'])) {
        header("Location: login.php");
        exit;
    }

    include '../fungsi/koneksi.php';
    $data = $collection->find();

    $page_title = "Riwayat Surat";
    include '../includes/layout_top.php';
    ?>
    <section class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Riwayat Surat</h1>
            <p>Halo, <b><?= $_SESSION['nama'] ?></b> (Akses: <?= ucfirst($_SESSION['role']) ?>)</p>
        </div>
        <div>
            <a href="tambah.php" class="btn btn-primary">Tambah Data</a>
        </div>
    </section>

    <div class="table-wrap">
        
    </div>
    <table class="table table-bordered table-striped mb-0">
        <thead>
            <tr>
                <th>Kode Surat</th>
                <th>Nama Acara</th>
                <th>Tipe Barang</th>
                <th>Waktu</th>
                <th>Tempat</th>
                <th>Keterangan</th>
                <?php if($_SESSION['role'] === 'admin'): ?>
                    <th style="width: 160px;">Aksi</th>
                <?php endif; ?>
            </tr>
        </thead>
    <tbody>
    <?php foreach ($data as $row): ?>
    <?php $kode = $row['kode_surat'] ?? null; if (!$kode) continue; ?>
    <tr>
        <td><?= htmlspecialchars($kode) ?></td>
        <td><?= htmlspecialchars($row['nama_acara'] ?? '-') ?></td>
        <td><?= htmlspecialchars($row['tipe_barang'] ?? '-') ?></td>
        <td><?= htmlspecialchars($row['waktu_acara'] ?? '-') ?></td>
        <td><?= htmlspecialchars($row['tempat_acara'] ?? '-') ?></td>
        <td><?= htmlspecialchars($row['keterangan'] ?? '-') ?></td>
        
        <?php if($_SESSION['role'] === 'admin'): ?>
        <td>
            <a class="btn btn-sm btn-warning" href="edit.php?kode_surat=<?= urlencode($kode) ?>">Edit</a>
            <a class="btn btn-sm btn-danger"
                href="../fungsi/hapus.php?kode_surat=<?= urlencode($kode) ?>"
                onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
        </td>
    <?php endif; ?>
        
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    <?php
    include '../includes/layout_bottom.php';

    ?>