<?php
include '../../koneksi.php';

if(isset($_POST['submit'])) {
    $IDSuplier = $_POST['IDSuplier'];
    $namaSuplier = $_POST['namaSuplier'];
    $alamat = $_POST['alamat'];
    $kota   = $_POST['kota'];
    $telepon = $_POST['telepon'];

    $sql = "INSERT INTO suplier (IDSuplier, namaSuplier, alamat, kota, telepon) VALUES ('$IDSuplier', '$namaSuplier', '$alamat', '$kota', '$telepon')";
    if(mysqli_query($connect, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Suplier</title>
    <link rel="stylesheet" href="../../css/input.css">

</head>
<body>
    <div class="container">
        <h1>Tambah Data Suplier</h1><br>

    <form action="" method="POST">
        <label for="IDSuplier">ID Suplier:</label><br>
        <input type="text" name="IDSuplier" id="IDSuplier"><br>

        <label for="namaSuplier">Nama Suplier:</label><br>
        <input type="text" name="namaSuplier" id="namaSuplier" required><br>

        <label for="alamat">Alamat:</label><br>
        <input type="text" name="alamat" id="alamat" required><br>

        <label for="kota">Kota:</label><br>
        <input type="text" name="kota" id="kota" required><br>

        <label for="telepon">Telepon:</label><br>
        <input type="text" name="telepon" id="telepon" required><br><br>

        <button type="submit" name="submit">Tambah</button>
    </form>
    </div>
</body>
</html>