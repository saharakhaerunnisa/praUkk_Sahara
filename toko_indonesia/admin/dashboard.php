<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM barang ORDER BY id ASC";
$result = mysqli_query($connect, $sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang</title>
    <link rel="stylesheet" href="../css/table.css">
    <style>
    .nav {
    display: flex; /* Aktifkan flexbox */
    justify-content: space-between; /* Kiri dan Kanan */
    align-items: center;
    background-color: #2c3e50;
    padding: 10px 40px;
    margin-bottom: 30px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .brand h2 {
        color: white;
        margin: 0;
        font-size: 1.2rem;
    }

    .brand span {
        color: #3498db; /* Warna aksen untuk username */
    }

    .nav-content {
        display: flex;
        align-items: center;
        gap: 30px; /* Jarak antara Menu dan tombol Logout */
    }

    .menu {
        display: flex;
        list-style: none; /* Hilangkan titik bullet */
        margin: 0;
        padding: 0;
        gap: 20px; /* Jarak antar link menu */
    }

    .menu li a {
        color: white;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }

    .menu li a:hover {
        color: #3498db;
    }

    .btn-logout {
        color: white !important;
        text-decoration: none;
        background-color: #e74c3c; /* Merah untuk logout agar kontras */
        padding: 8px 18px;
        border-radius: 5px;
        font-weight: bold;
        transition: background 0.3s;
    }

    .btn-logout:hover {
        background-color: #c0392b;
    }
    </style>
</head>
<body>
    <nav class="nav">
        <div class="brand">
            <h2>Selamat Datang, <span><?php echo $_SESSION['username']; ?></span></h2>
        </div>

        <div class="nav-content">
            <ul class="menu">
                <li><a href="suplier/index.php">Suplier</a></li>
                <li><a href="tbl_gerai/index.php">Gerai</a></li>
                <li><a href="transaksi/index.php">Transaksi</a></li>
            </ul>
            <a href="../index.php" class="btn-logout">Logout</a>
        </div>
    </nav>
    <h1>Data Barang</h1><br>

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
    </table><br>
    <hr>
</body>
</html>