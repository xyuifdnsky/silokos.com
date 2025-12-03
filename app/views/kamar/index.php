<?php
$user_name = $user_name ?? "Penyewa";

require_once __DIR__ . '/../../../config/database.php';
$conn = DatabaseConfig::getConnection();
session_start();

$list_kamar = $conn->query("
    SELECT 
        kamar.id_kamar AS id,
        kamar.nomor_kamar,
        kamar.tipe_kamar,
        kamar.harga,
        kamar.fasilitas,
        kamar.gambar AS gambar,
        kamar.status,
        users.nama_user AS pemilik
    FROM kamar
    LEFT JOIN users ON kamar.id_pemilik = users.id_user
    WHERE kamar.status = 'tersedia'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Kamar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* ---- RESET ---- */
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    padding-top: 80px;
    margin: 0;
}

/* HEADER */
.header {
    background-color: #fff;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed;    
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    border-bottom: 1px solid #ddd;
}

/* NAV MENU */
.nav-menu {
    display: flex;
    list-style: none;
    gap: 15px;
    margin: 0;
    padding: 0;
}

.nav-menu a {
    text-decoration: none;
    color: #000;
    font-weight: 600;
}

.nav-menu li { position: relative; }

.dropdown-content {
    display: none;
    position: absolute;
    background: white;
    list-style: none;
    padding: 8px 0;
    min-width: 150px;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.dropdown-content li a {
    display: block;
    padding: 8px 14px;
    color: #000;
}

.dropdown:hover .dropdown-content {
    display: block;
}

/* POPUP OVERLAY */
.role-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.4);
    backdrop-filter: blur(6px);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1500;
}

/* POPUP CARD */
.role-popup {
    background: white;
    padding: 30px;
    border-radius: 16px;
    width: 90%;
    max-width: 400px;
    animation: fadeIn .3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(.9); }
    to { opacity: 1; transform: scale(1); }
}

/* TOMBOL LOGIN */
.role-btn {
    width: 100%;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 12px;
    text-decoration: none;
    display: block;
    text-align: center;
    color: white;
    font-weight: bold;
}
.btn-penyewa { background: #3B82F6; }
.btn-pemilik { background: #10B981; }

/* CARD KAMAR */
.kamar-card {
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.kamar-img img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

</style>
</head>

<body>

<!-- HEADER -->
<header class="header">
    <div class="logo" style="display:flex; align-items:center; gap:10px;">
        <img src="../../../gambar/logo-silokos.png" style="height:40px;">
        <span style="font-size:1.5em; font-weight:bold;">SiLoKos</span>
    </div>

    <nav>
        <ul class="nav-menu">
            <li class="dropdown">
                <a href="#">Cari Apa?</a>
                <ul class="dropdown-content">
                    <li><a href="app/views/kamar/index.php">Booking</a></li>
                </ul>
            </li>
            <li><a href="#">Pusat Bantuan</a></li>
            <li><a href="ketentuan/syarat_ketentuan.php">Syarat & Ketentuan</a></li>
            <li><a href="#" id="openRoleUserBar">Login</a></li>
        </ul>
    </nav>
</header>


<!-- CONTENT -->
<div class="container mt-4">
    <h3 class="fw-bold mb-4">Daftar Kamar Tersedia</h3>

    <div class="row g-4">

        <?php foreach ($list_kamar as $km): ?>
        <div class="col-lg-3 col-md-4 col-sm-6">

            <div class="kamar-card">
                <div class="kamar-img">
                    <img src="gambar/<?= $km['gambar'] ?>">
                </div>

                <div class="p-3">
                    <span class="badge bg-success"><?= ucfirst($km['tipe_kamar']) ?></span>

                    <h6 class="mt-2"><?= $km['nomor_kamar'] ?></h6>
                    <p class="text-muted small"><?= $km['fasilitas'] ?></p>

                    <div class="fw-bold mb-2">
                        Rp<?= number_format($km['harga'],0,',','.') ?>
                    </div>

                    <a href="detail_kamar.php?id=<?= $km['id'] ?>" class="btn btn-primary w-100 mb-2">
                        Lihat Detail
                    </a>

                    <?php if (isset($_SESSION['user'])): ?>
                        <form action="pesan/pesan_kamar.php" method="GET">
                            <input type="hidden" name="id_kamar" value="<?= $km['id'] ?>">
                            <button class="btn btn-success w-100">Pesan Kamar</button>
                        </form>
                    <?php else: ?>
                        <button class="btn btn-success w-100" onclick="openLoginPopup()">
                            Pesan Kamar
                        </button>
                    <?php endif; ?>

                </div>
            </div>

        </div>
        <?php endforeach; ?>

    </div>
</div>


<!-- POPUP LOGIN UTAMA (TOP NAVBAR) -->
<div id="roleUserOverlayBar" class="role-overlay">
    <div class="role-popup">
        <h3 class="mb-3">Login Sebagai</h3>

        <a href="../auth/login.php?role=penyewa" class="role-btn btn-penyewa">Penyewa</a>
        <a href="../auth/login.php?role=pemilik" class="role-btn btn-pemilik">Pemilik Kos</a>

        <button id="closeUserBar" class="btn btn-secondary w-100">Tutup</button>
    </div>
</div>


<!-- POPUP LOGIN (UNTUK PESAN KAMAR) -->
<div id="openLoginPopup" class="role-overlay">
    <div class="role-popup">
        <h3 class="mb-3">Login untuk melanjutkan</h3>

        <a href="../auth/login.php?role=penyewa" class="role-btn btn-penyewa">Penyewa</a>
        <a href="../auth/login.php?role=pemilik" class="role-btn btn-pemilik">Pemilik Kos</a>

        <button id="closeUser" class="btn btn-secondary w-100">Tutup</button>
    </div>
</div>

<script>
// Popup login navbar
document.getElementById('openRoleUserBar').onclick = function(e) {
    e.preventDefault();
    document.getElementById('roleUserOverlayBar').style.display = 'flex';
};
document.getElementById('closeUserBar').onclick = function() {
    document.getElementById('roleUserOverlayBar').style.display = 'none';
};

// Popup pesan kamar
function openLoginPopup() {
    document.getElementById('openLoginPopup').style.display = 'flex';
}
document.getElementById('closeUser').onclick = function() {
    document.getElementById('openLoginPopup').style.display = 'none';
};
</script>

</body>
</html>
