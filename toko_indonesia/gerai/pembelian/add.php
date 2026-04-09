<?php
session_start();
include '../../koneksi.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "Belum Login";

if (isset($_POST['pesan'])) {
    $id_gerai = $user_id; 
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];

    $query_barang = mysqli_query($connect, "SELECT harga FROM barang WHERE id = '$id_barang'");
    $data_barang = mysqli_fetch_assoc($query_barang);
    $harga_satuan = $data_barang['harga'];
    $total_harga = $harga_satuan * $jumlah;

    $query_stok = mysqli_query($connect, "SELECT stock FROM barang WHERE id = '$id_barang'");
    if($jumlah > $query_stok) {
        echo "<script>alert('Perhatian, jumlah stok kurang!'); window.location='index.php';</script>";
    }

    $sql = "INSERT INTO transaksi (id_gerai, id_barang, jumlah, harga_barang, total_harga, status) 
            VALUES ('$id_gerai', '$id_barang', '$jumlah', '$harga_satuan', '$total_harga', 'Pending')";
    
    if (mysqli_query($connect, $sql)) {
        echo "<script>alert('Berhasil!'); window.location='index.php';</script>";
    } else {
        echo "Error SQL: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pesan Barang</title>
    <link rel="stylesheet" href="../../css/input.css">
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .input-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select { width: 300px; padding: 8px; }
    </style>
</head>
<body>
    <h1>Pesan Barang</h1><br>

    <form action="" method="POST">
        <div class="input-group">
            <label>ID Gerai (Anda):</label>
            <input type="text" value="<?= $user_id ?>" readonly>
        </div>

        <div class="input-group">
            <label>Pilih Barang :</label>
            <select name="id_barang" id="id_barang" onchange="updateHarga()" required>
                <option value="" data-harga="0">-- Pilih Barang --</option>
                <?php
                $res = mysqli_query($connect, "SELECT * FROM barang");
                if (!$res) {
                    echo "<option>Error: " . mysqli_error($connect) . "</option>";
                }
                while($row = mysqli_fetch_assoc($res)): ?>
                    <option value="<?= $row['id'] ?>" data-harga="<?= $row['harga'] ?>">
                        <?= $row['namaBarang'] ?> (Rp <?= number_format($row['harga'], 0, ',', '.') ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="input-group">
            <label>Harga Satuan :</label>
            <input type="number" id="harga_satuan" readonly placeholder="Otomatis">
        </div>

        <div class="input-group">
            <label>Jumlah :</label>
            <input type="number" name="jumlah" id="jumlah" oninput="hitungTotal()" required min="1">
        </div>

        <div class="input-group">
            <label>Total Harga :</label>
            <input type="number" name="total_harga" id="total_harga" readonly placeholder="Otomatis">
        </div>

        <button type="submit" name="pesan" style="padding: 10px 20px; cursor:pointer;">Kirim Pesanan</button>
    </form>

    <script>
    function updateHarga() {
        var s = document.getElementById('id_barang');
        var harga = s.options[s.selectedIndex].getAttribute('data-harga');
        document.getElementById('harga_satuan').value = harga;
        hitungTotal();
    }

    function hitungTotal() {
        var h = document.getElementById('harga_satuan').value || 0;
        var j = document.getElementById('jumlah').value || 0;
        document.getElementById('total_harga').value = h * j;
    }
    </script>
</body>
</html>
