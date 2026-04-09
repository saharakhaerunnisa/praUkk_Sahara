<?php
include '../config.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../index.php");
    exit();
}

$user = $_SESSION['username'];

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($connect, "DELETE FROM jenis_mobil WHERE id_jenis='$id'");
    header("Location: dashboard.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($connect, "DELETE FROM pelanggan WHERE id_pelanggan='$id'");
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Jenis Mobil</title>
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
    <h1>Selamat datang! <?php echo $user; ?></h1>
    <a href="../index.php" class="btn-logout">Logout</a>


    <h2>Master Data Jenis Mobil</h2>

    <br>
    <a href="jenis_mobil/add.php" class="btn">Tambah Data</a>
    <br><br>
    <table>
        <thead>
            <tr>
                <th>ID Jenis</th>
                <th>Nama Mobil</th>
                <th>Harga Sewa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = mysqli_query($connect, "SELECT * FROM jenis_mobil");
            while ($row = mysqli_fetch_assoc($sql)) {
            ?>
            <tr>
                <td><?= $row['id_jenis']; ?></td>
                <td><?= $row['nama_jenis']; ?></td>
                <td>Rp <?= number_format($row['harga_sewa'], 0, ',', '.'); ?></td>
                <td>
                    <a href="jenis_mobil/edit.php?id=<?= $row['id_jenis']; ?>">Edit</a> | 
                    <a href="dashboard.php?hapus=<?= $row['id_jenis']; ?>" class="btn-hapus" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <br><hr><br>
        <h2>Master Data Pelanggan</h2><br>
    <a href="pelanggan/add.php" class="btn">Tambah Data</a>
    <br><br>
    <table>
        <thead>
            <tr>
                <th>ID Pelanggan</th>
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
                <th>No Hp</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = mysqli_query($connect, "SELECT * FROM pelanggan");
            while ($row = mysqli_fetch_assoc($sql)) {
            ?>
            <tr>
                <td><?= $row['id_pelanggan']; ?></td>
                <td><?= htmlspecialchars($row['nama']); ?></td>
                <td><?= $row['alamat']; ?></td>
                <td><?= $row['no_hp']; ?></td>
                <td>
                    <a href="pelanggan/edit.php?id=<?= $row['id_pelanggan']; ?>">Edit</a> | 
                    <a href="dashboard.php?delete=<?= $row['id_pelanggan']; ?>" class="btn-hapus" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php } 
                
            ?>
        </tbody>
    </table>
</body>
</html>