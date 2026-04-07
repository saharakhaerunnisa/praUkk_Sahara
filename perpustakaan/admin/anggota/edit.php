<?php

include '../../config.php';
session_start();
if($_SESSION['role'] !== 'Admin') {
    header("Location: ../../index.php");
    exit();
}

$id = $_GET['id'];
$data = mysqli_query($connect, "SELECT * FROM anggota WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if(isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $kelas = $_POST['kelas'];

    $sql = "UPDATE anggota SET 
            nama='$nama', 
            nis='$nis', 
            kelas='$kelas' 
            WHERE id='$id'";
    
    if(mysqli_query($connect, $sql)) {
        echo "<script>alert('Anggota berhasil diedit!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal mengedit anggota.'); window.location='edit.php?id=" . $id . "';</script>";
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
        <input type="text" id="nama" name="nama" value="<?= $row['nama'] ?>" required><br><br>

        <label for="nis">nis:</label>
        <input type="text" id="nis" name="nis" value="<?= $row['nis'] ?>" required><br><br>

        <label for="kelas">kelas:</label>
        <select id="kelas" name="kelas" required>
            <option value="">Pilih Kelas</option>
            <option value="X">X</option>
            <option value="XI">XI</option>
            <option value="XII">XII</option>
        </select><br><br>

        <input type="submit" name="update">
    </form>
</body>
</html>