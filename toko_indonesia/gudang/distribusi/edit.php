<?php
include '../../koneksi.php';

// 1. PROSES UPDATE (Dijalankan saat tombol ditekan)
if (isset($_POST['update'])) {
    // Ambil data dari POST agar lebih aman dan tidak hilang saat submit
    $id = mysqli_real_escape_string($connect, $_POST['id']);
    $id_transaksi = mysqli_real_escape_string($connect, $_POST['id_transaksi']);
    $jumlah_input = mysqli_real_escape_string($connect, $_POST['jumlah']);

    // Ambil detail data distribusi terlebih dahulu
    $query_cari = mysqli_query($connect, "SELECT * FROM distribusi WHERE id = '$id'");
    $d = mysqli_fetch_assoc($query_cari);

    if ($d) {
        $id_b = $d['id_barang'];
        $id_g = $d['id_gerai'];
        $hrg  = $d['harga'];
        // Gunakan jumlah dari input form jika user ingin mengubahnya, 
        // atau tetap pakai $d['jumlah'] jika hanya konfirmasi.
        $jml  = $jumlah_input; 

        // Update status distribusi & transaksi
        mysqli_query($connect, "UPDATE distribusi SET status = 'Dikirim', jumlah = '$jml' WHERE id = '$id'");
        mysqli_query($connect, "UPDATE transaksi SET status = 'Shipped' WHERE id_transaksi = '$id_transaksi'");

        // Cek stok di gerai
        $cek_stok = mysqli_query($connect, "SELECT id FROM barang_gerai WHERE id_barang='$id_b' AND id_gerai='$id_g'");
        
        if (mysqli_num_rows($cek_stok) > 0) {
            $sql_stok = "UPDATE barang_gerai SET stok = stok + $jml WHERE id_barang='$id_b' AND id_gerai='$id_g'";
        } else {
            $sql_stok = "INSERT INTO barang_gerai (id_barang, id_gerai, stok, harga) 
                         VALUES ('$id_b', '$id_g', '$jml', '$hrg')";
        }

        if (mysqli_query($connect, $sql_stok)) {
            echo "<script>alert('Barang Terkirim & Stok Gerai Bertambah!'); window.location='index.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Data Gagal Diproses!'); window.location='index.php';</script>";
        exit();
    }
}

// 2. PROSES TAMPIL DATA (Dijalankan saat halaman pertama kali dibuka via link 'Konfirmasi')
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connect, $_GET['id']);
    $sql = "SELECT * FROM distribusi WHERE id='$id'";
    $result = mysqli_query($connect, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $distribusi = mysqli_fetch_assoc($result);
    } else {
        echo "Data distribusi tidak ditemukan!";
        exit();
    }
} else {
    // Jika tidak ada ID di URL dan bukan sedang POST, tendang balik ke index
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pengiriman</title>
        <link rel="stylesheet" href="../../css/input.css">

    <style>
        body { font-family: sans-serif; margin: 20px; line-height: 1.6; }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; display: block; }
        input[readonly] { background-color: #eee; border: 1px solid #ccc; cursor: not-allowed; }
        button { padding: 10px 15px; background: #28a745; color: white; border: none; cursor: pointer; border-radius: 4px; }
        button:hover { background: #218838; }
    </style>
</head>
<body>
    
    <hr>
    
    <form action="" method="POST">
        <h1>Konfirmasi Pengiriman Barang</h1>
        <input type="hidden" name="id" value="<?= $distribusi['id'] ?>">
        <input type="hidden" name="id_transaksi" value="<?= $distribusi['id_transaksi'] ?>">

        <div class="form-group">
            <label>ID Barang:</label>
            <input type="text" value="<?= $distribusi['id_barang'] ?>" readonly>
        </div>

        <div class="form-group">
            <label>ID Gerai Tujuan:</label>
            <input type="text" value="<?= $distribusi['id_gerai'] ?>" readonly>
        </div>

        <div class="form-group">
            <label>Harga Satuan:</label>
            <input type="number" name="harga" value="<?= $distribusi['harga'] ?>" readonly>
        </div>

        <div class="form-group">
            <label>Jumlah yang Dikirim:</label>
            <input type="number" name="jumlah" value="<?= $distribusi['jumlah'] ?>" required>
            <small>*Silakan ubah jika jumlah yang dikirim berbeda</small>
        </div>

        <button type="submit" name="update">Konfirmasi & Kirim Sekarang</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
