<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); }

include '../../koneksi.php';


$id = $_GET['id'];
$sql = "SELECT * FROM gerai WHERE id='$id'";
$result = mysqli_query($connect, $sql);
if (mysqli_num_rows($result) > 0) {
    $gerai = mysqli_fetch_assoc($result);
} else {
    echo "Gerai tidak ditemukan!";
    exit();
}

if (isset($_POST['save'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kota = $_POST['kota'];
    $telepon = $_POST['telepon'];
    $user_id = $_SESSION['user_id']; 

    $sql = "UPDATE gerai SET 
            nama='$nama', 
            alamat='$alamat', 
            kota='$kota', 
            telepon='$telepon', 
            created_by='$user_id' 
            WHERE id='$id'";
    
    if (mysqli_query($connect, $sql)) {
        echo "Gerai berhasil ditambahkan!";
        header("Location: ../dashboard.php");
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
    <title>Tambah Gerai</title>
    <link rel="stylesheet" href="../../css/input.css">

</head>
<body>

<div class="container">
    <h1>Edit data</h1><br>
        <form method="POST">
        <input type="text" name="nama" placeholder="Nama Gerai" value="<?= $gerai['nama']?>" required>
    <textarea name="alamat" placeholder="Alamat"><?= $gerai['alamat']?></textarea>
    <input type="text" name="kota" placeholder="Kota" value="<?= $gerai['kota']?>">
    <input type="text" name="telepon" placeholder="Telepon" value="<?= $gerai['telepon']?>">
    <button type="submit" name="save">Simpan Gerai</button>
</form>
</div>
    
</body>
</html>