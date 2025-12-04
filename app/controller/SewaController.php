<?php
require_once '../../config/database.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id_user = $_SESSION['user']['id_user'];
$id_kamar = $_POST['id_kamar'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];

$stmt = $conn->prepare("
    INSERT INTO sewa (id_user, id_kamar, tanggal_mulai, tanggal_selesai, status)
    VALUES (?, ?, ?, ?, 'pending')
");
$stmt->bind_param("iiss", $id_user, $id_kamar, $tanggal_mulai, $tanggal_selesai);
$stmt->execute();

header("Location: ../pesanan/berhasil.php");
exit;
