<?php
include '../../koneksi.php';
// session_start();
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'gerai') {
//     header("Location: login.php");
//     exit();
// }

if (isset($_POST['submit'])) {
    $id_barang = $_POST['id_barang'];
    $jual = $_POST['jual'];
    $harga = $_POST['harga'];
    $id_gerai = $_POST['id_gerai']; 

    $sql = "INSERT INTO distribusi (id_barang, jual, harga, id_gerai) 
            VALUES ('$id_barang', '$jual', '$harga', '$id_gerai')";
    
    if (mysqli_query($connect, $sql)) {
        echo "Distribusi berhasil ditambahkan!";
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
    <title>Tambah data</title>
        <link rel="stylesheet" href="../../css/input.css">

</head>
<body>
    <h1>Tambah Data</h1>
    <form action="" method="POST">
        <input type="text" name="id_barang" placeholder="ID Barang" required>
        <input type="number" name="jual" placeholder="Jumlah Jual" required>
        <input type="number" name="harga" placeholder="Harga" required>
        <input type="text" name="id_gerai" placeholder="ID Gerai" required>
        <button type="submit" name="submit">Simpan Distribusi</button>
    </form>
</body>
</html>