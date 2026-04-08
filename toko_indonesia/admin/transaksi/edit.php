<?php
session_start();
include '../../koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = mysqli_real_escape_string($connect, $_GET['id']);

$query_lama = mysqli_query($connect, "SELECT t.*, b.namaBarang FROM transaksi t JOIN barang b ON t.id_barang = b.id WHERE t.id_transaksi = '$id'");
$data_lama = mysqli_fetch_assoc($query_lama);

if (!$data_lama) {
    echo "Data tidak ditemukan!";
    exit();
}

if (isset($_POST['update'])) {
    $status = $_POST['status'];
    $keterangan = mysqli_real_escape_string($connect, $_POST['keterangan']);
    $jumlah = $_POST['jumlah'];
    $total_harga = $data_lama['harga_barang'] * $jumlah;

    $sql = "UPDATE transaksi SET 
            status='$status', 
            keterangan='$keterangan', 
            jumlah='$jumlah', 
            total_harga='$total_harga' 
            WHERE id_transaksi='$id'";
    
    if (mysqli_query($connect, $sql)) {
        if ($status == 'Approved') {
            $cek_dist = mysqli_query($connect, "SELECT * FROM distribusi WHERE id_transaksi = '$id'");
            
            if (mysqli_num_rows($cek_dist) == 0) {
                $id_barang = $data_lama['id_barang'];
                $id_gerai  = $data_lama['id_gerai'];
                
                $sql_dist = "INSERT INTO distribusi (id_transaksi, id_barang, id_gerai, jumlah, harga, status) 
                             VALUES ('$id', '$id_barang', '$id_gerai', '$jumlah', '{$data_lama['harga_barang']}', 'Pending')";
                mysqli_query($connect, $sql_dist);
            }
        }

        echo "<script>alert('Berhasil Update! Pesanan diteruskan ke Gudang.'); window.location='index.php';</script>";
    } else {
        echo "Error SQL: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit / Approve Transaksi</title>
        <link rel="stylesheet" href="../../css/input.css">

    <style>
        body { font-family: sans-serif; padding: 20px; line-height: 1.6; }
        .card { border: 1px solid #ccc; padding: 20px; width: 400px; border-radius: 8px; }
        .input-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn { background: #28a745; color: white; border: none; padding: 10px; cursor: pointer; width: 100%; }
    </style>
</head>
<body>
    <h1>Edit / Konfirmasi Pesanan</h1>

    <div class="card">
        <form action="" method="POST">
            <div class="input-group">
                <label>Nama Barang:</label>
                <input type="text" value="<?= $data_lama['namaBarang'] ?>" readonly>
            </div>

            <div class="input-group">
                <label>Harga Satuan:</label>
                <input type="number" id="harga_satuan" value="<?= $data_lama['harga_barang'] ?>" readonly>
            </div>

            <div class="input-group">
                <label>Jumlah Pesanan:</label>
                <input type="number" name="jumlah" id="jumlah" value="<?= $data_lama['jumlah'] ?>" oninput="hitungTotal()">
            </div>

            <div class="input-group">
                <label>Total Harga:</label>
                <input type="number" id="total_harga" value="<?= $data_lama['total_harga'] ?>" readonly>
            </div>

            <div class="input-group">
                <label>Status Transaksi:</label>
                <select name="status">
                    <option value="Pending" <?= $data_lama['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Approved" <?= $data_lama['status'] == 'Approved' ? 'selected' : '' ?>>Approved (Setujui)</option>
                    <option value="Rejected" <?= $data_lama['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected (Tolak)</option>
                </select>
            </div>

            <div class="input-group">
                <label>Keterangan Admin:</label>
                <textarea name="keterangan" rows="3"><?= $data_lama['keterangan'] ?></textarea>
            </div>

            <button type="submit" name="update" class="btn">Simpan Perubahan</button>
            <br><br>
            <a href="index.php">Kembali</a>
        </form>
    </div>

    <script>
    function hitungTotal() {
        var h = document.getElementById('harga_satuan').value || 0;
        var j = document.getElementById('jumlah').value || 0;
        document.getElementById('total_harga').value = h * j;
    }
    </script>
</body>
</html>