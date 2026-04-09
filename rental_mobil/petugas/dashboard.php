<?php
include '../config.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Petugas') {
    header("Location: ../index.php");
    exit();
}

$user = $_SESSION['username'];

$keyword = "";
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
}

$peminjaman_sql = mysqli_query($connect, "SELECT p.*, pl.nama AS nama_pelanggan, j.nama_jenis FROM peminjaman p 
                                            JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan 
                                            JOIN jenis_mobil j ON p.id_jenis = j.id_jenis 
                                            WHERE pl.nama LIKE '%$keyword%' OR j.nama_jenis LIKE '%$keyword%'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/table.css">
    <style>
            .btn-logout {
            color: white !important;
            text-decoration: none;
            background-color: #e74c3c; /* Merah untuk logout agar kontras */
            padding: 8px 18px;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-logout:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <h1>Selamat datang! <?php echo $user; ?> </h1>
    <a href="../index.php" class="btn-logout">Logout</a>

    <h2>Data transaksi</h2><br>
    <a href="transaksi.php" class="btn">Tambah Data</a>
    <br><br>
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>ID Peminjaman</th>
            <th>Nama Pelanggan</th>
            <th>Nama Mobil</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
            <th>Total Bayar</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($peminjaman_sql)) { ?>
        <tr>
            <td><?= $row['id_peminjaman']; ?></td>
            <td><?= $row['nama_pelanggan']; ?></td>
            <td><?= $row['nama_jenis']; ?></td>
            <td><?= $row['tanggal_pinjam']; ?></td>
            <td><?= $row['tanggal_kembali'] ?? "Belum Kembali"; ?></td>
            <td><?= $row['status'] ?? null;?></td>
            <td>Rp <?= number_format($row['total_bayar'], 0, ',', '.'); ?></td>
            <td>
                <a href="update.php?id=<?= $row['id_peminjaman'] ?>">Update</a>
            </td>
        </tr>
        <?php } ?>

    </table>
</body>
</html>