<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'gudang') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM barang ORDER BY id ASC";
$result = mysqli_query($connect, $sql);

if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($connect, "DELETE FROM barang WHERE id = '$id' ");
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang</title>
    <link rel="stylesheet" href="../css/table.css">

</head>
<body>
    <h1>Panel Gudang - Stok Barang</h1>
    <a href="distribusi/index.php">Lihat Distribusi</a>
<a href="../index.php">Logout</a>
    <h1>Data Barang</h1><br>

    <a href="barang/add.php">Tambah Barang</a><br>
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Kategori</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stock</th>
            <th>Suplier</th>
            <th>Aksi</th>
        </tr>
        <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) :
        ?>
        <tr>
            <td><?= htmlspecialchars($row['id'])?></td>
            <td><?= htmlspecialchars($row['kategori'])?></td>
            <td><?= htmlspecialchars($row['namaBarang'])?></td>
            <td><?= htmlspecialchars($row['harga'])?></td>
            <td><?= htmlspecialchars($row['stock'])?></td>
            <td><?= htmlspecialchars($row['IDSuplier'])?></td>
            <td>
                <a href="barang/edit.php?id=<?= $row['id']?>">Edit</a>
                <a href="index.php?delete=<?= $row['id']?>">Delete</a>
            </td>
        </tr>
        <?php
                    endwhile;
                }   
        ?>

    </table>
</body>
</html>