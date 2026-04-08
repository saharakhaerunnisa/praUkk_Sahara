<?php
include '../koneksi.php';

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'gerai') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT 
            d.id, 
            d.id_barang, 
            d.id_gerai,          
            b.namaBarang, 
            g.nama, 
            d.harga, 
            d.stok 
        FROM barang_gerai d 
        JOIN barang b ON d.id_barang = b.id 
        JOIN gerai g ON d.id_gerai = g.id";

$result = mysqli_query($connect, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/table.css">
</head>
<body>
    <h1>Panel Gerai - Data Barang</h1>
    <a href="../index.php">Logout</a><br>

    <a href="pembelian/index.php">Pembelian</a>
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>ID Barang</th>
            <th>Nama Barang</th>
            <th>ID Gerai</th>
            <th>Nama gerai</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>
        <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) :
        ?>
        <tr>
            <td><?= htmlspecialchars($row['id'])?></td>
            <td><?= htmlspecialchars($row['id_barang'])?></td>
            <td><?= htmlspecialchars($row['namaBarang'])?></td>
            <td><?= htmlspecialchars($row['id_gerai'])?></td>
            <td><?= htmlspecialchars($row['nama'])?></td>
            <td><?= htmlspecialchars($row['harga'])?></td>
            <td><?= htmlspecialchars($row['stok'])?></td>
        </tr>
        <?php
                    endwhile;
                }   else {
                    echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                }
        ?>
    </table>

</body>
</html>