<?php
include '../../koneksi.php';

if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($connect, "DELETE FROM suplier WHERE IDSuplier = '$id'");
    header("Location: index.php");
    exit;
}

$sql = "SELECT * FROM suplier ORDER BY IDSuplier ASC";
$result = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Suplier</title>
    <link rel="stylesheet" href="../../css/table.css">

</head>
<body>
    
    <h1>Data Suplier</h1>
    <a href="add.php">Tambah Suplier</a><br>
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>ID Suplier</th>
            <th>Nama Suplier</th>
            <th>Alamat</th>
            <th>Kota</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>
        <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) :
        ?>
        <tr>
            <td><?= htmlspecialchars($row['IDSuplier'])?></td>
            <td><?= htmlspecialchars($row['namaSuplier'])?></td>
            <td><?= htmlspecialchars($row['alamat'])?></td>
            <td><?= htmlspecialchars($row['kota'])?></td>
            <td><?= htmlspecialchars($row['telepon'])?></td>
            <td>
                <a href="edit.php?id=<?= $row['IDSuplier'];?>">Edit</a>
                <a href="index.php?delete=<?= $row['IDSuplier']?>">Delete</a>
            </td>
        </tr>
        <?php
                    endwhile;
                }   
        ?>
</body>
</html>