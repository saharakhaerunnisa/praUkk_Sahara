<?php
include '../../config.php';

$id = $_GET['id'];
$data = mysqli_query($connect, "SELECT * FROM pelanggan WHERE id_pelanggan='$id'");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $id_post = $_POST['id_pelanggan'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    $query = "UPDATE pelanggan SET nama='$nama', alamat='$alamat', no_hp='$no_hp' WHERE id_pelanggan='$id_post'";
        $result = mysqli_query($connect, $query);

    if (!$result) {
        die("Query Error: " . mysqli_error($connect));
    } else {
        header("Location: ../dashboard.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Pengguna</title>
    <link rel="stylesheet" href="../../css/input.css">
</head>
<body>
    <div class="container">
        <h2>Edit Data Pelanggan</h2><br>
        <form method="POST">
            <label>ID Pelanggan:</label><br>
            <input type="text" value="<?= $row['id_pelanggan']; ?>" disabled><br><br>
            <input type="hidden" name="id_pelanggan" value="<?= $row['id_pelanggan']; ?>">

            <label>Nama Pelanggan:</label><br>
            <input type="text" name="nama" value="<?= $row['nama']; ?>" required><br><br>

            <label>Alamat:</label><br>
            <input type="text" name="alamat" value="<?= $row['alamat']; ?>" required><br><br>

            <label>No Hp:</label><br>
            <input type="text" name="no_hp" value="<?= $row['no_hp']; ?>" required><br><br>

            <button type="submit" name="update">Update Data</button>
            <a href="../dashboard.php">Batal</a>
        </form>
    </div>
</body>
</html>