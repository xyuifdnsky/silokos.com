<?php
session_start();
require_once '../../../../models/database.php';

$conn = databaseconfig::getConnection();

// Cek login
if (!isset($_SESSION['user'])) {
    header("Location: ../../login.php");
    exit;
}

// Ambil data user
$role = $_SESSION['user']['role'];
$id_pemilik = $_SESSION['user']['id_user']; // default: user adalah pemilik

// Tentukan id_pemilik berdasarkan role user
if ($role == 'pemilik') {
    $id_pemilik = $_SESSION['user']['id_user']; // pemilik = dirinya sendiri (perbaikan error)
} elseif ($role == 'admin') {
    $id_pemilik = $_SESSION['user']['id_pemilik']; // admin melihat milik pemilik tertentu
}

/* ======================
   HITUNG TOTAL KAMAR
====================== */
$qKamar = mysqli_query($conn, "SELECT COUNT(*) AS total 
                               FROM kamar 
                               WHERE id_pemilik='$id_pemilik'");

$totalKamar = 0;
if ($qKamar && mysqli_num_rows($qKamar) > 0) {
    $totalKamar = mysqli_fetch_assoc($qKamar)['total'];
}

/* ======================
   HITUNG TOTAL PENGHUNI
====================== */
$qPenghuni = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM sewa 
    JOIN kamar ON sewa.id_kamar = kamar.id_kamar
    WHERE kamar.id_pemilik = '$id_pemilik'
      AND sewa.status = 'Disetujui'
");

$totalPenghuni = 0;
if ($qPenghuni && mysqli_num_rows($qPenghuni) > 0) {
    $totalPenghuni = mysqli_fetch_assoc($qPenghuni)['total'];
}

/* ======================
   HITUNG TOTAL KELUHAN
====================== */
$qKeluhan = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM keluhan 
    WHERE id_pemilik = '$id_pemilik'
");

$totalKeluhan = 0;
if ($qKeluhan && mysqli_num_rows($qKeluhan) > 0) {
    $totalKeluhan = mysqli_fetch_assoc($qKeluhan)['total'];
}

/* ======================
   Ambil detail user
====================== */
$qUser = mysqli_query($conn, "SELECT * FROM users WHERE id_user='$id_pemilik'");
$dataUser = mysqli_fetch_assoc($qUser);

$username = $_SESSION['user']['username'] ?? 'Pengguna';
$foto = $dataUser['foto'] ?? 'default.jpg';
$nama_user = $dataUser['nama_user'] ?? $username;

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pemilik</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #0c3e7f;
            --bg-color: #f5f7fa;
            --sidebar-width: 260px;
        }

        body { background: var(--bg-color); font-family: 'Poppins', sans-serif; }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--secondary-color);
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 80px;
            z-index: 10;
        }
        .sidebar .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            padding: 15px 20px;
            position: absolute;
            top: 0;
            width: 100%;
            text-align: center;
        }
        .sidebar a {
            display: flex; align-items: center; gap: 15px;
            padding: 14px 25px;
            color: #d0d8e0;
            text-decoration: none;
            border-left: 5px solid transparent;
            transition: all 0.3s;
        }
        .sidebar a.active { background: var(--primary-color); color: white; border-left: 5px solid white; font-weight: 600; }

        .top-nav {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: 70px;
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.07);
            padding: 0 30px;
            z-index: 50;
            display: flex;
            align-items: center;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            padding-top: 100px;
            min-height: 100vh;
        }

        .card-stat {
            padding: 30px; border-radius: 12px;
            background: linear-gradient(135deg, white 60%, #eef5ff 100%);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: 0.3s;
            text-align: center;
        }

    </style>
</head>

<body>

<div class="sidebar" id="sidebar">
    <div class="logo">SiLoKos Admin</div>
    <a href="#" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="../../penyewa/data_penyewa.php"><i class="bi bi-person"></i> Data Penghuni</a>
    <a href="../../../kamar/create.php"><i class="bi bi-door-open"></i> Tambah Kamar</a>
    <a href="../../../Keluhan/lihat_keluhan.php"><i class="bi bi-chat-dots"></i> Keluhan</a>
    <a href="../../../Pembayaran/transaksi.php"><i class="bi bi-credit-card"></i> Transaksi</a>
    <a href="admin/tambah_admin.php"><i class="bi bi-people"></i> Admin</a>
    <a href="../logout.php" style="color:red;"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<nav class="top-nav">
    <div class="title">Dashboard Pemilik</div>

    <div class="dropdown ms-auto">
        <img src="../../profil/<?= $foto ?>" 
             class="rounded-circle me-2"
             style="width:40px; height:40px; object-fit:cover;">

        <a class="fw-semibold dropdown-toggle text-dark text-decoration-none" href="#" data-bs-toggle="dropdown">
            <?= $username ?>
        </a>

        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
            <li><a class="dropdown-item" href="../../profil.php"><i class="bi bi-person me-2"></i> Profil Saya</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
        </ul>
    </div>
</nav>

<div class="main-content">

    <h2 class="fw-bold mb-5 text-dark">Ringkasan Operasional</h2>

    <div class="row g-4">

        <div class="col-lg-4 col-md-6">
            <a href="../../../kamar/create.php" class="text-decoration-none">
                <div class="card-stat">
                    <div class="stat-number text-primary"><?= $totalKamar ?></div>
                    <div class="stat-label mt-2">Total Kamar</div>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card-stat">
                <div class="stat-number"><?= $totalPenghuni ?></div>
                <div class="stat-label mt-2">Penghuni</div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card-stat">
                <div class="stat-number"><?= $totalKeluhan ?></div>
                <div class="stat-label mt-2">Keluhan</div>
            </div>
        </div>

    </div>

    <h3 class="fw-bold mt-5 mb-4 text-dark">Analisis dan Laporan</h3>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="p-4 bg-white rounded shadow">
                <h5><i class="bi bi-graph-up me-2"></i> Grafik Keuangan Bulanan</h5>
                <div class="text-center mt-4">
                    <i class="bi bi-bar-chart-fill" style="font-size:5rem; color:#ced4da;"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="p-4 bg-white rounded shadow">
                <h5><i class="bi bi-pie-chart-fill me-2"></i> Distribusi Pemasukan</h5>
                <div class="text-center mt-4">
                    <i class="bi bi-pie-chart-fill" style="font-size:5rem; color:#ced4da;"></i>
                </div>

                <div class="text-center mt-4">
                    <button class="btn btn-outline-dark fw-semibold">
                        <i class="bi bi-download"></i> Unduh Laporan
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
