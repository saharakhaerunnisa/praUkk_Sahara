<?php

include '../../koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($connect, "SELECT * FROM suplier WHERE IDSuplier='$id'");
$d = mysqli_fetch_assoc($data);

if(isset($_POST['submit'])) {
    $IDSuplier = $_POST['IDSuplier'];
    $namaSuplier = $_POST['namaSuplier'];
    $alamat = $_POST['alamat'];
    $kota   = $_POST['kota'];
    $telepon = $_POST['telepon'];

    $sql = "UPDATE suplier SET namaSuplier='$namaSuplier', alamat='$alamat', kota='$kota', telepon='$telepon' WHERE IDSuplier='$IDSuplier'";
    if(mysqli_query($connect, $sql)) {
        header("Location: index.php");
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
    <title>Edit Suplier</title>
    <link rel="stylesheet" href="../../css/input.css">
</head>
<body>
    
  <div class="container">
      <h1>Edit Data Suplier</h1><br>

    <form action="" method="POST">
        <label for="IDSuplier">ID Suplier :</label><br>
        <input type="text" name="IDSuplier" id="IDSuplier" value="<?= $d['IDSuplier'] ?>" readonly><br>

        <label for="namaSuplier">Nama Suplier :</label><br>
        <input type="text" name="namaSuplier" id="namaSuplier" value="<?= $d['namaSuplier'] ?>" required><br>

        <label for="alamat">Alamat :</label><br>
        <input type="text" name="alamat" id="alamat" value="<?= $d['alamat'] ?>" required><br>

        <label for="kota">Kota :</label><br>
        <input type="text" name="kota" id="kota" value="<?= $d['kota'] ?>" required><br>

        <label for="telepon">Telepon :</label><br>
        <input type="text" name="telepon" id="telepon" value="<?= $d['telepon'] ?>" required><br><br>

        <button type="submit" name="submit">Update</button>
    </form>
  </div>

</body>
</html>