<?php

include '../../config.php';
session_start();
if($_SESSION['role'] !== 'Admin') {
    header("Location: ../../index.php");
    exit();
}

if(isset($_POST['submit'])) {
    $kategori = $_POST['kategori'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $status = $_POST['status'];

    $sql = "INSERT INTO buku (kategori, judul, penulis, status) VALUES ('$kategori', '$judul', '$penulis', '$status')";
    
    if(mysqli_query($connect, $sql)) {
        echo "<script>alert('Buku berhasil ditambahkan!'); window.location='../dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan buku.'); window.location='add.php';</script>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="../../css/input.css">
</head>
<body>
    <main>
        <div class="content">
            <article class="card">
                    <h1>Tambah Buku</h1>
                        <form action="" method="POST">
                            <label for="kategori">Kategori:</label>
                            <select id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Keilmuan">Keilmuan</option>
                                <option value="Novel">Novel</option>
                                <option value="Bisnis">Bisnis</option>
                            </select><br><br>

                            <label for="judul">Judul:</label>
                            <input type="text" id="judul" name="judul" required><br><br>

                            <label for="penulis">Penulis:</label>
                            <input type="text" id="penulis" name="penulis" required><br><br>

                            <label for="status">Status:</label>
                            <select id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Dipinjam">Dipinjam</option>
                            </select><br><br>

                            <input type="submit" name="submit">
                        </form>
            </article>
        </div>
    </main>
</body>
</html>