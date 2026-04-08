<?php
include '../../koneksi.php';

if(isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($connect, $_GET['delete']);

    $check_query = mysqli_query($connect, "SELECT status FROM transaksi WHERE id_transaksi='$id'");
    $data = mysqli_fetch_assoc($check_query);

    if($data && $data['status'] == 'Pending') {
        $sql = "DELETE FROM transaksi WHERE id_transaksi='$id'";
        
        if(mysqli_query($connect, $sql)) {
            echo "<script>alert('Transaksi berhasil dibatalkan!'); window.location='index.php';</script>";
            exit();
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    } else {
        echo "<script>alert('Transaksi sudah diproses atau tidak ditemukan, tidak bisa dibatalkan!'); window.location='index.php';</script>";
        exit();
    }
}

$sql = "SELECT t.*, b.namaBarang, g.nama FROM transaksi 
        t LEFT JOIN barang b ON t.id_barang = b.id 
        LEFT JOIN gerai g ON t.id_gerai = g.id";
$result = mysqli_query($connect, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian</title>
    <link rel="stylesheet" href="../../css/table.css">
</head>
<body>
    <h1>Panel Gerai - Pembelian</h1>
    <a href="add.php">Tambah data</a>||
    <a href="../dashboard.php">Kembali</a>
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Id Barang</th>
            <th>Nama Barang</th>
            <th>Jumlah Beli</th>
            <th>Harga</th>
            <th>Id Gerai</th>
            <th>Nama Gerai</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) :
        ?>
        <tr>
            <td><?= htmlspecialchars($row['id_transaksi'])?></td>
            <td><?= htmlspecialchars($row['id_barang'])?></td>
            <td><?= htmlspecialchars($row['namaBarang']) ?? null ?></td>
            <td><?= htmlspecialchars($row['jumlah'])?></td>
            <td><?= htmlspecialchars($row['harga_barang'])?></td>
            <td><?= htmlspecialchars($row['id_gerai'])?></td>
            <td><?= htmlspecialchars($row['nama']) ?? null ?></td>
            <td><?= htmlspecialchars($row['status'])?></td>
            <td>
                <a href="index.php?delete=<?= $row['id_transaksi']?>" onclick="return confirm('Apakah Anda ingin membatalkan pesanan ini?')">Batalkan</a>
            </td>
        </tr>
        <?php
                    endwhile;
                }   
        ?>
</body>
</html>