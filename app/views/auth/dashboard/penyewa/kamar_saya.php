<?php
require_once __DIR__ . '/../../../../../config/database.php';
$conn = DatabaseConfig::getConnection();

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../login.php");
    exit;
}

$id_user = $_SESSION['user']['id_user'];

// Ambil data kamar yang dipesan pengguna
$query = "
    SELECT 
        sewa.id_sewa,
        kamar.nomor_kamar,
        kamar.tipe_kamar,
        kamar.harga,
        kamar.fasilitas,
        kamar.gambar,
        sewa.status
    FROM sewa
    JOIN kamar ON sewa.id_kamar = kamar.id_kamar
    WHERE sewa.id_user = '$id_user'
";

$result = $conn->query($query);

$notifQuery = "SELECT COUNT(*) as jml FROM sewa WHERE status = 'Pending'";
$notifResult = $conn->query($notifQuery);
$notif = $notifResult->fetch_assoc()['jml'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kamar Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-primary px-3">
    <a class="navbar-brand text-white" href="#">
        <i class="bi bi-house-door-fill"></i> Kamar Saya
    </a>

    <div class="d-flex align-items-center">

        <!-- Icon Notifikasi -->
        <a href="../pesanan/notifikasi.php" class="text-white position-relative me-4">
            <i class="bi bi-bell fs-4"></i>
            <?php if ($notif > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?= $notif ?>
                </span>
            <?php endif; ?>
        </a>

        <a href="../../../logout.php" class="btn btn-light btn-sm">
            Logout
        </a>
    </div>
</nav>


<!-- MENU NAVIGASI TAMBAHAN -->
<div class="bg-white shadow-sm py-3 px-4 mb-4 d-flex gap-4 align-items-center">
    
    <a href="pembayaran.php" class="text-decoration-none text-dark fw-semibold">
        <i class="bi bi-wallet2"></i> Pembayaran
    </a>

    <a href="riwayat.php" class="text-decoration-none text-dark fw-semibold">
        <i class="bi bi-receipt"></i> Riwayat Pembayaran
    </a>

    <a href="../../../keluhan/create.php" class="text-decoration-none text-dark fw-semibold">
        <i class="bi bi-exclamation-circle"></i> Keluhan
    </a>

</div>

<div class="container mt-3">
    <h4 class="mb-3">Status Pemesanan</h4>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered text-center bg-white shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th>Kamar</th>
                    <th>Tipe</th>
                    <th>Harga</th>
                    <th>Status Admin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['nomor_kamar']; ?></td>
                        <td><?= $row['tipe_kamar']; ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td>
                            <span class="badge 
                                <?= $row['status'] == 'Pending' ? 'bg-warning' : 
                                    ($row['status'] == 'Disetujui' ? 'bg-success' : 'bg-danger'); ?>">
                                <?= $row['status']; ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'Pending'): ?>
                                <a href="batal.php?id=<?= $row['id_sewa']; ?>" class="btn btn-danger btn-sm">Batalkan</a>
                            <?php else: ?>
                                <span class="text-muted">Tidak bisa dibatalkan</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    <?php else: ?>
        <div class="alert alert-info text-center">
            Anda belum memesan kamar.
        </div>
    <?php endif; ?>
</div>

</body>
</html>
