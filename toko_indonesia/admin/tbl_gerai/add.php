<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); }

include 'koneksi.php';

if (isset($_POST['save'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kota = $_POST['kota'];
    $telepon = $_POST['telepon'];
    $user_id = $_SESSION['user_id']; 

    $sql = "INSERT INTO gerai (nama, alamat, kota, telepon, created_by) 
            VALUES ('$nama', '$alamat', '$kota', '$telepon', '$user_id')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Gerai berhasil ditambahkan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Gerai</title>
</head>
<body>

<div class="container">
    <h1>Tambah data</h1><br>
    <form method="POST">
    <input type="text" name="nama" placeholder="Nama Gerai" required>
    <textarea name="alamat" placeholder="Alamat"></textarea>
    <input type="text" name="kota" placeholder="Kota">
    <input type="text" name="telepon" placeholder="Telepon">
    <button type="submit" name="save">Simpan Gerai</button>
</form>
</div>
    
</body>
</html>