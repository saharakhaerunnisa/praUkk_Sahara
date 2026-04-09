<?php
include '../config.php';

$id = $_GET['id'];

$query_lama = mysqli_query($connect, "SELECT peminjaman.*, jenis_mobil.harga_sewa 
                                      FROM peminjaman 
                                      JOIN jenis_mobil ON peminjaman.id_jenis = jenis_mobil.id_jenis 
                                      WHERE id_peminjaman = '$id'");
$data = mysqli_fetch_assoc($query_lama);

if (isset($_POST['kembalikan'])) {
    $tgl_kembali = $_POST['tanggal_kembali']; 
    $tgl_pinjam = $data['tanggal_pinjam'];
    $durasi_perjanjian = $data['jumlah']; 
    $harga_sewa = $data['harga_sewa'];
    $status = $_POST['status'];

    $t1 = new DateTime($tgl_pinjam);
    $t2 = new DateTime($tgl_kembali);
    $selisih = $t1->diff($t2);
    $durasi_nyata = $selisih->days;
    if ($durasi_nyata <= 0) $durasi_nyata = 1;

    $denda = 0;
    $biaya_denda_per_hari = 100000; 

    if ($durasi_nyata > $durasi_perjanjian) {
        $keterlambatan = $durasi_nyata - $durasi_perjanjian;
        $denda = $keterlambatan * $biaya_denda_per_hari;
    }

    $total_akhir = ($durasi_perjanjian * $harga_sewa) + $denda;

    $update = mysqli_query($connect, "UPDATE peminjaman SET 
                tanggal_kembali = '$tgl_kembali',
                total_bayar = '$total_akhir',
                status = '$status'
                WHERE id_peminjaman = '$id'");

    if ($update) {
        $id_mobil = $data['id_jenis'];
        mysqli_query($connect, "UPDATE jenis_mobil SET status='tersedia' WHERE id_jenis='$id_mobil'");
        
        echo "<script>alert('Mobil Kembali! Denda: Rp $denda. Total Akhir: Rp $total_akhir'); window.location='dashboard.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pengembalian Mobil</title>
    <link rel="stylesheet" href="../css/input.css">
    <style>
        select, input[type="date"] {
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
            <h2>Proses Pengembalian Mobil</h2>
    <p>ID Pinjam: <?= $data['id_peminjaman'] ?></p>
    <p>Perjanjian Sewa: <?= $data['jumlah'] ?> Hari</p>
    
    <form method="POST">
        <label>Tanggal Pengembalian (Hari Ini):</label><br>
        <input type="date" name="tanggal_kembali" value="<?= date('Y-m-d') ?>" required><br><br>

        <label for="status">Status:</label>
        <select name="status" id="">
            <option value="Proses">Proses</option>
            <option value="Selesai">Selesai</option>
        </select>

        <button type="submit" name="kembalikan">Konfirmasi Pengembalian</button>
    </form>
    </div>
</body>
</html>