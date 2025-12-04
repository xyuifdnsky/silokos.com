<?php
session_start();
require_once __DIR__ . '../../../../../config/database.php';
$conn = DatabaseConfig::getConnection();

$id_pemilik = $_GET['id_pemilik'];

$query = $conn->query("
    SELECT sewa.id_sewa, users.nama_user, kamar.nomor_kamar, 
           sewa.tanggal_mulai, sewa.tanggal_selesai, sewa.status
    FROM sewa
    JOIN users ON sewa.id_user = users.id_user
    JOIN kamar ON sewa.id_kamar = kamar.id_kamar
    WHERE kamar.id_pemilik='$id_pemilik' AND sewa.status='pending'
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<h3>📌 Daftar Pemesanan Kamar</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Penyewa</th>
            <th>Kamar</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $query->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['nama_user'] ?></td>
            <td><?= $row['nomor_kamar'] ?></td>
            <td><?= $row['tanggal_mulai'] ?></td>
            <td><?= $row['tanggal_selesai'] ?></td>
            <td>
                <a href="proses_pemesanan.php?id=<?= $row['id_sewa'] ?>&aksi=setuju&id_pemilik=<?= $id_pemilik ?>" class="btn btn-success btn-sm">
                    ✔ Setujui
                </a>
                <a href="proses_pemesanan.php?id=<?= $row['id_sewa'] ?>&aksi=tolak&id_pemilik=<?= $id_pemilik ?>" class="btn btn-danger btn-sm">
                    ❌ Tolak
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>
