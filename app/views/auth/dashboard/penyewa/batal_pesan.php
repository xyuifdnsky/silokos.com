<?php
require_once __DIR__ . '../../../../../config/database.php';
$conn = DatabaseConfig::getConnection();
session_start();

if (!isset($_SESSION['user'])) {
    die("Harus login.");
}

$id_sewa = $_GET['id'];

// Ambil data sewa
$q = $conn->query("SELECT id_kamar, admin_status FROM sewa WHERE id_sewa='$id_sewa'");
$data = $q->fetch_assoc();

$id_kamar = $data['id_kamar'];

// Hanya bisa batal jika masih pending admin
if ($data['admin_status'] !== 'pending') {
    die("❌ Tidak bisa dibatalkan karena sudah diproses admin.");
}

// Update sewa → batal
$conn->query("UPDATE sewa SET status='batal', admin_status='ditolak' WHERE id_sewa='$id_sewa'");

// Update kamar → tersedia lagi
$conn->query("UPDATE kamar SET status='tersedia' WHERE id_kamar='$id_kamar'");

header("Location: daftar_pesanan_user.php?msg=batal");
exit;
?>
