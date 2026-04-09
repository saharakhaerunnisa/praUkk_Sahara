<?php
include '../../config.php';

$id = $_GET['id'];
$data = mysqli_query($connect, "SELECT * FROM jenis_mobil WHERE id_jenis='$id'");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $nama = $_POST['nama_jenis'];
    $harga = $_POST['harga_sewa'];

    $query = "UPDATE jenis_mobil SET nama_jenis='$nama', harga_sewa='$harga' WHERE id_jenis='$id'";
    mysqli_query($connect, $query);
    header("Location: ../dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Jenis Mobil</title>
    <link rel="stylesheet" href="../../css/input.css">
</head>
<body>
    <div class="container">
            <h2>Edit Data Jenis Mobil</h2>
        <form method="POST">
            <label>ID Jenis:</label><br>
            <input type="text" value="<?= $row['id_jenis']; ?>" disabled><br><br>
            
            <label>Nama Mobil:</label><br>
            <input type="text" name="nama_jenis" value="<?= $row['nama_jenis']; ?>" required><br><br>
            
            <label>Harga Sewa:</label><br>
            <input type="text" name="harga_sewa" value="<?= $row['harga_sewa']; ?>" required><br><br>
            
            <button type="submit" name="update">Update Data</button>
            <a href="../dashboard.php">Batal</a>
        </form>
    </div>
</body>
</html>