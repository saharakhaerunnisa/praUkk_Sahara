<?php

include '../../koneksi.php';
session_start();
if($_SESSION['role'] !== 'gerai') exit();

if(isset($_POST['pesan'])) {
    $id_gerai = $_SESSION['user_id'];
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    
    $res = mysqli_query($conn, "SELECT harga_satuan FROM barang_master WHERE id_barang = '$id_barang'");
    $data = mysqli_fetch_assoc($res);
    $total = $data['harga_satuan'] * $jumlah;

    $sql = "INSERT INTO transaksi (id_gerai, id_barang, jumlah_pesan, total_harga, status) 
            VALUES ('$id_gerai', '$id_barang', '$jumlah', '$total', 'Pending')";
    mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan</title>
</head>
<body>
    <div class="container">
        <h1>Pesan Barang</h1>
        <br>
        <form action="" method="POST">
            
        </form>
    </div>
</body>
</html>