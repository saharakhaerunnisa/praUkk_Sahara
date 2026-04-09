<?php
include '../config.php';

$pelanggan_sql = mysqli_query($connect, "SELECT * FROM pelanggan");
$mobil_sql = mysqli_query($connect, "SELECT * FROM jenis_mobil WHERE status='tersedia'");

if (isset($_POST['proses'])) {
    $id_peminjaman = $_POST['id_peminjaman'];
    $id_pelanggan  = $_POST['id_pelanggan'];
    $id_jenis      = $_POST['id_jenis'];
    $tgl_pinjam    = $_POST['tanggal_pinjam'];
    $jumlah        = $_POST['jumlah']; // Perjanjian berapa hari
    $status        = 'Proses';

    // 1. Ambil harga sewa untuk hitung total awal
    $cari_harga = mysqli_query($connect, "SELECT harga_sewa FROM jenis_mobil WHERE id_jenis='$id_jenis'");
    $data_mobil = mysqli_fetch_assoc($cari_harga);
    $harga_sewa = $data_mobil['harga_sewa'];

    // 2. Hitung Total Bayar berdasarkan perjanjian ($jumlah hari)
    $total_bayar = $jumlah * $harga_sewa;

    // 3. Simpan ke database
    // Kolom tanggal_kembali dikosongkan dulu (NULL atau '') karena diisi pas EDIT
    $query = "INSERT INTO peminjaman (id_peminjaman, id_pelanggan, id_jenis, jumlah, tanggal_pinjam, status, total_bayar) 
              VALUES ('$id_peminjaman', '$id_pelanggan', '$id_jenis', $jumlah, '$tgl_pinjam', 'Proses', '$total_bayar')";
    
    if (mysqli_query($connect, $query)) {
        // Update status mobil jadi dipinjam
        mysqli_query($connect, "UPDATE jenis_mobil SET status='dipinjam' WHERE id_jenis='$id_jenis'");
        
        echo "<script>alert('Berhasil! Perjanjian sewa $jumlah hari. Total Bayar: Rp $total_bayar'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Peminjaman</title>
    <link rel="stylesheet" href="../css/input.css">
    <style>
        select, input{
            width: 100%;
            padding: 12px;
            margin-bottom: 20px; /* Jarak antar kolom input */
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box; /* Sangat penting agar padding tidak merusak lebar */
            font-size: 15px;
            transition: 0.3s;
        }

        option {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Input Transaksi Peminjaman</h2>
        <form method="POST">
            <label>ID Peminjaman</label><br>
            <input type="text" name="id_peminjaman" placeholder="PMJ001" required><br><br>

            <label>Pelanggan</label><br>
            <select name="id_pelanggan" required>
                <option value="">-- Pilih Pelanggan --</option>
                <?php while($p = mysqli_fetch_assoc($pelanggan_sql)) { ?>
                    <option value="<?= $p['id_pelanggan'] ?>"><?= $p['nama'] ?></option>
                <?php } ?>
            </select><br><br>

            <label>Mobil</label><br>
            <select name="id_jenis" required>
                <option value="">-- Pilih Mobil --</option>
                <?php while($m = mysqli_fetch_assoc($mobil_sql)) { ?>
                    <option value="<?= $m['id_jenis'] ?>"><?= $m['nama_jenis'] ?> (Rp <?= $m['harga_sewa'] ?>/hari)</option>
                <?php } ?>
            </select><br><br>

            <label>Tanggal Pinjam</label><br>
            <input type="date" name="tanggal_pinjam" value="<?= date('Y-m-d') ?>" required><br><br>

            <label>Lama Sewa (Jumlah Hari)</label><br>
            <input type="number" name="jumlah" min="1" placeholder="Berapa hari?" required><br><br>

            <button type="submit" name="proses">Simpan Transaksi</button>
            <a href="dashboard.php">Batal</a>
        </form>
    </div>
</body>
</html>