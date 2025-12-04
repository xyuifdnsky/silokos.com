<?php
require_once __DIR__ . '../../../../../config/database.php';
$conn = DatabaseConfig::getConnection();

// Pastikan session aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pastikan user login
if (!isset($_SESSION['user'])) {
    die("Anda harus login terlebih dahulu.");
}

$id_user = $_SESSION['user']['id_user'];


/*
|--------------------------------------------------
| 1. PROSES PESAN KAMAR (POST)
|--------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_kamar   = $_POST['id_kamar'];
    $tgl_mulai  = $_POST['tanggal_mulai'];
    $tgl_selesai = $_POST['tanggal_selesai'];

    // INSERT pesanan baru
    $query = "
        INSERT INTO sewa (id_user, id_kamar, tanggal_mulai, tanggal_selesai, status) 
        VALUES ('$id_user', '$id_kamar', '$tgl_mulai', '$tgl_selesai', 'pending')
    ";

    $conn->query($query);

    // Redirect penyewa ke kamar_saya
    header("Location: ../../auth/dashboard/penyewa/kamar_saya.php");
    exit;
}


/*
|--------------------------------------------------
| 2. PROSES SETUJU / TOLAK (GET)
|--------------------------------------------------
*/
if (isset($_GET['id']) && isset($_GET['aksi'])) {

    $id_sewa   = $_GET['id'];
    $aksi      = $_GET['aksi'];
    $id_pemilik = $_GET['id_pemilik'];

    // Ambil ID kamar dari tabel sewa
    $q = $conn->query("SELECT id_kamar, id_user FROM sewa WHERE id_sewa='$id_sewa'");
    $data = $q->fetch_assoc();

    $id_kamar = $data['id_kamar'];
    $id_user  = $data['id_user'];

    if ($aksi == 'setuju') {

        // Update status sewa
        $conn->query("UPDATE sewa SET status='disetujui' WHERE id_sewa='$id_sewa'");

        // Update status kamar
        $conn->query("UPDATE kamar SET status='disewa' WHERE id_kamar='$id_kamar'");

        // Notifikasi
        $conn->query("
            INSERT INTO notifikasi_user (id_user, pesan, status)
            VALUES ('$id_user', 'Pesanan kamar Anda telah disetujui!', 'baru')
        ");

    } elseif ($aksi == 'tolak') {

        $conn->query("UPDATE sewa SET status='ditolak' WHERE id_sewa='$id_sewa'");
        $conn->query("UPDATE kamar SET status='tersedia' WHERE id_kamar='$id_kamar'");

        $conn->query("
            INSERT INTO notifikasi_user (id_user, pesan, status)
            VALUES ('$id_user', 'Pesanan kamar Anda ditolak.', 'baru')
        ");
    }

    // Redirect kembali ke halaman pemilik
    header("Location: ../../penyewa/data_sewa.php?id_pemilik=$id_pemilik");
    exit;
}

?>
