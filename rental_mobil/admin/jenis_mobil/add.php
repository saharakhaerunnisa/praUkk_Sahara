<?php
include '../../config.php';

if (isset($_POST['tambah'])) {
    $id = $_POST['id_jenis'];
    $nama = $_POST['nama_jenis'];
    $harga = $_POST['harga_sewa'];

    $query = "INSERT INTO jenis_mobil (id_jenis, nama_jenis, harga_sewa) VALUES ('$id', '$nama', '$harga')";
    mysqli_query($connect, $query);
    header("Location: ../dashboard.php");
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Jenis Mobil</title>
    <link rel="stylesheet" href="../../css/input.css">
</head>
<body>
    <div class="container">
        <h2>Tambah Data Jenis Mobil</h2><br>
        <div class="form-box">
            <form method="POST">
                <label>ID Jenis</label><br>
                <input type="text" name="id_jenis" placeholder="Masukkan ID Jenis" required><br><br>

                <label>Nama Mobil</label><br>
                <input type="text" name="nama_jenis" placeholder="Masukkan Nama Mobil" required><br><br>

                <label>Harga Sewa</label><br>
                <input type="text" name="harga_sewa" placeholder="Masukkan Harga Sewa" required><br>

                <button type="submit" name="tambah">Tambah Data</button>
                <a href="../dashboard.php">Kembali</a>
            </form>
        </div>
    </div>
</body>
</html>