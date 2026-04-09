<?php
include '../../config.php';

if (isset($_POST['tambah'])) {
    $id = $_POST['id_pelanggan'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    $query = "INSERT INTO pelanggan (id_pelanggan, nama, alamat, no_hp) VALUES ('$id', '$nama', '$alamat', '$no_hp')";

    $result = mysqli_query($connect, $query);

    if (!$result) {
        die("Query Error: " . mysqli_error($connect));
    } else {
        header("Location: ../dashboard.php");
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Pengguna</title>
    <link rel="stylesheet" href="../../css/input.css">
</head>
<body>
    <div class="container">
        <h2>Tambah Data Pelanggan</h2><br>
        <div class="form-box">
            <form method="POST">
                <label>ID Pelanggan</label><br>
                <input type="text" name="id_pelanggan" placeholder="Masukkan ID Pelanggan" required><br><br>

                <label>Nama Pelanggan</label><br>
                <input type="text" name="nama" placeholder="Masukkan Nama Pelanggan" required><br><br>

                <label>Alamat</label><br>
                <input type="text" name="alamat" placeholder="Masukkan Alamat" required><br><br>

                <label>No Hp</label><br>
                <input type="text" name="no_hp" placeholder="Masukkan No Hp" required>

                <button type="submit" name="tambah">Tambah Data</button><br>
                <a href="../dashboard.php">Kembali</a>
            </form>
        </div>
    </div>
</body>
</html>