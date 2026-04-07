<?php
include '../config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Siswa') {
    header("Location: ../../index.php");
    exit();
}

// Ambil ID Buku dari URL (hasil klik dari dashboard)
$id_buku_dari_url = isset($_GET['id_buku']) ? $_GET['id_buku'] : "";

if(isset($_POST['pinjam'])) {
    // Gunakan user_id (Angka) bukan username (Teks) agar cocok dengan database
    $id_anggota     = $_SESSION['user_id']; 
    $id_buku        = $_POST['id_buku'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali= $_POST['tanggal_kembali'];
    $status_awal    = 'Dipinjam';

    mysqli_begin_transaction($connect);

    try {
        // 1. Cek ketersediaan
        $cek = mysqli_query($connect, "SELECT status FROM buku WHERE id = '$id_buku' FOR UPDATE");
        $buku = mysqli_fetch_assoc($cek);

        if (!$buku || $buku['status'] !== 'Tersedia') {
            throw new Exception("Buku sedang tidak tersedia.");
        }

        // 2. Validasi Tanggal
        $tgl1 = new DateTime($tanggal_pinjam);
        $tgl2 = new DateTime($tanggal_kembali);
        if ($tgl2 < $tgl1) throw new Exception("Tanggal kembali tidak valid.");
        if ($tgl1->diff($tgl2)->days > 5) throw new Exception("Maksimal pinjam 5 hari.");

        // 3. Insert Peminjaman
        $queryPinjam = "INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, tanggal_kembali, status) 
                        VALUES ('$id_anggota', '$id_buku', '$tanggal_pinjam', '$tanggal_kembali', '$status_awal')";
        mysqli_query($connect, $queryPinjam);

        // 4. Update Status Buku
        mysqli_query($connect, "UPDATE buku SET status = 'Dipinjam' WHERE id = '$id_buku'");

        mysqli_commit($connect);
        echo "<script>alert('Peminjaman berhasil!'); window.location='dashboard.php';</script>";

    } catch (Exception $e) {
        mysqli_rollback($connect);
        echo "<script>alert('Gagal: " . $e->getMessage() . "');</script>";
    }
} 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Peminjaman Buku</title>
    <link rel="stylesheet" href="../css/input.css"> 
</head>
<body>

    <main>
        <div class="content">
            <article class="card">
                <h2>Form Pinjam Buku</h2>
                <p>Silakan isi data peminjaman di bawah ini. Durasi maksimal adalah 5 hari.</p>
                <hr>

                <form action="" method="POST">
                    
                    <div style="margin-bottom: 15px;">
                        <label>ID Anggota (Anda):</label><br>
                        <input type="text" name="id_anggota" value="<?= $_SESSION['username']; ?>" readonly 
                               style="width: 100%; padding: 10px; background: #f0f0f0; border: 1px solid #ccc;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label>Pilih Buku:</label><br>
                        <select name="id_buku" required style="width: 100%; padding: 10px; border: 1px solid #ccc;">
                            <option value="">-- Pilih Buku yang Tersedia --</option>
                            <?php
                            $queryBuku = mysqli_query($connect, "SELECT * FROM buku WHERE status = 'Tersedia'");
                            while($b = mysqli_fetch_assoc($queryBuku)) {
                                // Logika AUTO SELECTED
                                $selected = ($b['id'] == $id_buku_dari_url) ? "selected" : "";
                                echo "<option value='".$b['id']."' $selected>".$b['judul']."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label>Tanggal Pinjam:</label><br>
                        <input type="date" name="tanggal_pinjam" value="<?= date('Y-m-d'); ?>" readonly 
                               style="width: 100%; padding: 10px; background: #f0f0f0; border: 1px solid #ccc;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label>Tanggal Kembali:</label><br>
                        <input type="date" name="tanggal_kembali" required 
                               style="width: 100%; padding: 10px; border: 1px solid #ccc;">
                        <small style="color: red;">*Maksimal 5 hari dari tanggal pinjam</small>
                    </div>

                    <div style="margin-top: 20px;">
                        <button type="submit" name="pinjam" 
                                style="background: #0F172A; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                            Konfirmasi Peminjaman
                        </button>
                        <a href="dashboard.php" style="margin-left: 10px; text-decoration: none; color: #555;">Batal</a>
                    </div>

                </form>
            </article>
        </div>
    </main>

</body>
</html>