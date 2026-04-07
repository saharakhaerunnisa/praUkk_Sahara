<?php
include '../../koneksi.php';
if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $kategori = $_POST['kategori'];
    $namaBarang = $_POST['namaBarang'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock'];
    $IDSuplier = $_POST['IDSuplier'];

    $sql = "INSERT INTO barang (id, kategori, namaBarang, harga, stock, IDSuplier) VALUES ('$id', '$kategori', '$namaBarang', '$harga', '$stock', '$IDSuplier')";
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
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="../../css/input.css">

</head>
<body>
    <div class="container">
        <h1>Tambah data</h1><br>

    <form action="" method="POST">
        <label for="id">ID:</label><br>
        <input type="text" name="id" id="id"><br>

        <label for="kategori">Kategori:</label><br>
        <select name="kategori" id="kategori" required>
            <option value="">Pilih Kategori</option>
            <?php
                $result = mysqli_query($connect, "SELECT DISTINCT kategori FROM barang");
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . htmlspecialchars($row['kategori']) . "'>" . htmlspecialchars($row['kategori']) . "</option>";
                }
            ?>
        </select><br>

        <label for="namaBarang">Nama Barang:</label><br>
        <input type="text" name="namaBarang" id="namaBarang" required><br>

        <label for="harga">Harga:</label><br>
        <input type="number" name="harga" id="harga" required><br>

        <label for="stock">Stock:</label><br>
        <input type="number" name="stock" id="stock" required><br>

        <label for="IDSuplier">ID Suplier:</label><br>
        <select name="IDSuplier" id="IDSuplier">
            <option value="">Pilih Suplier</option>
            <?php
                $hasil = mysqli_query($connect, "SELECT * FROM suplier ORDER BY namaSuplier ASC");
                while ($s = mysqli_fetch_assoc($hasil)) {
                    echo "<option value='" . $s['IDSuplier'] . "' $selected>" . $s['namaSuplier'] . "</option>";
                }
            ?>
        </select>

        <button type="submit" name="submit">Tambah</button>
    </form>
    </div>
</body>
</html>