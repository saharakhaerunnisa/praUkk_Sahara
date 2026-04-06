<?php
include '../../koneksi.php';

if (isset($_GET['id'])) {
    $id_awal = mysqli_real_escape_string($connect, $_GET['id']);
    $sql = "SELECT * FROM barang WHERE id = '$id_awal'";
    $result = mysqli_query($connect, $sql);
    $data = mysqli_fetch_assoc($result);
}

if(isset($_POST['update'])) {
    $id         = mysqli_real_escape_string($connect, $_POST['id']);
    $kategori   = mysqli_real_escape_string($connect, $_POST['kategori']);
    $namaBarang = mysqli_real_escape_string($connect, $_POST['namaBarang']);
    $harga      = mysqli_real_escape_string($connect, $_POST['harga']);
    $stock      = mysqli_real_escape_string($connect, $_POST['stock']);
    $IDSuplier  = mysqli_real_escape_string($connect, $_POST['IDSuplier']);

    $query = "UPDATE barang SET 
                kategori = '$kategori',
                namaBarang = '$namaBarang',
                harga = '$harga',
                stock = '$stock',
                IDSuplier = '$IDSuplier'
              WHERE id = '$id'";

    if(mysqli_query($connect, $query)) {
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
    <title>Edit Barang</title>
    <link rel="stylesheet" href="../../css/input.css">

</head>
<body>
    <div class="container">
        <h1>Edit data</h1><br>

    <form action="" method="POST">
        <label for="id">ID:</label><br>
        <input type="text" name="id" id="id" value="<?= $data['id']?>"><br>

        <label for="kategori">Kategori:</label><br>
        <select name="kategori" id="kategori" required>
            <option value="">Pilih Kategori</option>
            <?php
                $resKategori = mysqli_query($connect, "SELECT DISTINCT kategori FROM barang");
                while($row = mysqli_fetch_assoc($resKategori)) {
                    $selected = ($row['kategori'] == $data['kategori']) ? "selected" : "";
                    
                    echo "<option value='" . htmlspecialchars($row['kategori']) . "' $selected>" . 
                        htmlspecialchars($row['kategori']) . 
                        "</option>";
                }
            ?>
        </select><br>

        <label for="namaBarang">Nama Barang:</label><br>
        <input type="text" name="namaBarang" id="namaBarang" value="<?= $data['namaBarang']?>" required ><br>

        <label for="harga">Harga:</label><br>
        <input type="number" name="harga" id="harga" value="<?= $data['harga']?>" required><br>

        <label for="stock">Stock:</label><br>
        <input type="number" name="stock" id="stock" value="<?= $data['stock']?>" required><br>

        <label for="IDSuplier">ID Suplier:</label><br>
        <select name="IDSuplier" id="IDSuplier">
            <option value="">Pilih Suplier</option>
           <?php
                $hasil = mysqli_query($connect, "SELECT * FROM suplier ORDER BY namaSuplier ASC");
                while ($s = mysqli_fetch_assoc($hasil)) {
                    $selected = ($s['IDSuplier'] == $data['IDSuplier']) ? "selected" : "";
                    echo "<option value='" . $s['IDSuplier'] . "' $selected>" . $s['namaSuplier'] . "</option>";
                }
            ?>
        </select>

        <button type="submit" name="update">Update</button>
    </form>
    </div>
</body>
</html>