<?php

include '../../config.php';
session_start();
if($_SESSION['role'] !== 'Admin') {
    header("Location: ../../index.php");
    exit();
}

$id = $_GET['id'];
$data = mysqli_query($connect, "SELECT * FROM buku WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if(isset($_POST['update'])) {
    $kategori = $_POST['kategori'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $status = $_POST['status'];

    $sql = "UPDATE buku SET 
            kategori='$kategori', 
            judul='$judul', 
            penulis='$penulis', 
            status='$status' 
            WHERE id='$id'";
    
    if(mysqli_query($connect, $sql)) {
        echo "<script>alert('Buku berhasil diedit!'); window.location='../dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal mengedit buku.'); window.location='edit.php?id=" . $id . "';</script>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="../../css/input.css">
</head>
<body>
    <h1>Edit Buku</h1>
    <form action="" method="POST">
        <label for="kategori">Kategori:</label>
        <select id="kategori" name="kategori" required>
            <option value="">Pilih Kategori</option>
            <option value="Keilmuan">Keilmuan</option>
            <option value="Novel">Novel</option>
            <option value="Bisnis">Bisnis</option>
        </select><br><br>

        <label for="judul">Judul:</label>
        <input type="text" id="judul" name="judul" value="<?= $row['judul'] ?>" required><br><br>

        <label for="penulis">Penulis:</label>
        <input type="text" id="penulis" name="penulis" value="<?= $row['penulis'] ?>" required><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="">Pilih Status</option>
            <option value="Tersedia">Tersedia</option>
            <option value="Dipinjam">Dipinjam</option>
        </select><br><br>

        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>