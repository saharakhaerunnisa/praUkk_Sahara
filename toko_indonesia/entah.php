<?php
include 'koneksi.php';

$keyword = "";
if(isset($_GET['cari'])) {
    $keyword = mysqli_real_escape_string($connect, $_GET['cari']);
}

$sql = "SELECT * FROM barang WHERE
        namaBarang LIKE '%$keyword%' OR
        kategori LIKE '%$keyword%' 
        ORDER BY id ASC";

$result = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/table.css">

</head>
<body>
    <h1>Selamat Datang</h1><br>

    <form action="" method="get">
        <input type="text" name="cari" placeholder="Cari Barang" value="<?= htmlspecialchars($keyword)?>">
        <button type="submit">Cari</button>
    </form><br>

    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Kategori</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stock</th>
            <th>Suplier</th>
        </tr>
        <?php 
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) :
        ?>
        <tr>
            <td><?= htmlspecialchars($row['id'])?></td>
            <td><?= htmlspecialchars($row['kategori'])?></td>
            <td><?= htmlspecialchars($row['namaBarang'])?></td>
            <td><?= htmlspecialchars($row['harga'])?></td>
            <td><?= htmlspecialchars($row['stock'])?></td>
            <td><?= htmlspecialchars($row['IDSuplier'])?></td>
        </tr>
        <?php 
                    endwhile;
                }
        ?>

        

    </table>
</body>
</html>