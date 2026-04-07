<?php

include '../../config.php';
session_start();
if($_SESSION['role'] !== 'Admin') {
    header("Location: ../../index.php");
    exit();
}

if(isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $kelas = $_POST['kelas'];

    $sql = "INSERT INTO anggota (nama, nis, kelas) VALUES ('$nama', '$nis', '$kelas')";
    
    if(mysqli_query($connect, $sql)) {
        $username = $nama; 
        $password = $nis; // Disarankan dienkripsi nanti
        $role     = 'Siswa';

        $sqlUser = "INSERT INTO user (username, password, role) VALUES ('$username', '$password', '$role')";

        if(mysqli_query($connect, $sqlUser)) {
            echo "<script>alert('Anggota dan Akun Login berhasil dibuat!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Anggota terdaftar, tapi gagal membuat akun login.'); window.location='index.php';</script>";
        }

        echo "<script>alert('Anggota berhasil ditambahkan!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan anggota.'); window.location='add.php';</script>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota</title>
    <link rel="stylesheet" href="../../css/input.css">
</head>
<body>
    <h1>Tambah Anggota</h1>
    <form action="" method="POST">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="nis">nis:</label>
        <input type="text" id="nis" name="nis" required><br><br>

        <label for="kelas">kelas:</label>
        <select id="kelas" name="kelas" required>
            <option value="">Pilih Kelas</option>
            <option value="X">X</option>
            <option value="XI">XI</option>
            <option value="XII">XII</option>
        </select><br><br>

        <input type="submit" name="submit">
    </form>
</body>
</html>