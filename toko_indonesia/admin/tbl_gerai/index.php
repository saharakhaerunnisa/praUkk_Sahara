<?php
include '../../koneksi.php';

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM gerai ORDER BY id ASC";
$result = mysqli_query($connect, $sql);

if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($connect, "DELETE FROM gerai WHERE id = '$id' ");
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/table.css">

</head>
<body>
    <h1>Data Gerai</h1><br>
    <a href="add.php" class="btn">Tambah Gerai Baru</a><br>
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nama Gerai</th>
            <th>Alamat</th>
            <th>Kota</th>
            <th>Telepon</th>
            <th>Created By</th>
            <th>Aksi</th>
        </tr>
        <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) :
        ?>
        <tr>
            <td><?= htmlspecialchars($row['id'])?></td>
            <td><?= htmlspecialchars($row['nama'])?></td>
            <td><?= htmlspecialchars($row['alamat'])?></td>
            <td><?= htmlspecialchars($row['kota'])?></td>
            <td><?= htmlspecialchars($row['telepon'])?></td>
            <td><?= htmlspecialchars($row['created_by'])?></td>
            <td>
                <a href="edit.php?id=<?= $row['id']?>">Edit</a>
                <a href="dashboard.php?delete=<?= $row['id']?>">Delete</a>
            </td>
        </tr>
        <?php
                    endwhile;
                }   
        ?>
    </table>
</body>
</html>