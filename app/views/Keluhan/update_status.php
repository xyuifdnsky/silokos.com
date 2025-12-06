<?php
session_start();
require_once __DIR__ . '/../../../config/database.php';

$conn = DatabaseConfig::getConnection();
if (!$conn) die("Koneksi gagal!");

// CEK LOGIN PEMILIK
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'pemilik') {
    header("Location: ../auth/login.php");
    exit;
}

$id_pemilik = $_SESSION['user']['id_user'];

// VALIDASI PARAMETER
if (!isset($_GET['id'], $_GET['s'])) {
    die("Parameter tidak lengkap!");
}

$id_keluhan = intval($_GET['id']);
$aksi = $_GET['s'];

// KONVERSI STATUS UNTUK DATABASE
$status_db = match ($aksi) {
    'Proses'  => 'Diproses',
    'Selesai' => 'Selesai',
    default   => 'Menunggu'
};

// CEK apakah keluhan benar milik pemilik yg login
$cek = $conn->prepare("SELECT id_keluhan FROM keluhan WHERE id_keluhan=? AND id_pemilik=?");
$cek->bind_param("ii", $id_keluhan, $id_pemilik);
$cek->execute();
$res = $cek->get_result();

if ($res->num_rows == 0) {
    echo "<script>alert('Tidak diizinkan! Keluhan bukan milik Anda.'); window.location='tindakan.php';</script>";
    exit;
}

// UPDATE STATUS
$up = $conn->prepare("UPDATE keluhan SET status=?, updated_at=NOW() WHERE id_keluhan=?");
$up->bind_param("si", $status_db, $id_keluhan);
$up->execute();

echo "<script>
        alert('Status keluhan berhasil diperbarui!');
        window.location='lihat.php';
      </script>";
exit;
?>
