<?php
    session_start();
    include '../../config.php';

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
        header("Location: ../../index.php");
        exit();
    }

    if(isset($_GET['delete'])) {
        $id = $_GET['delete'];
        mysqli_query($connect, "DELETE FROM buku WHERE id='$id'");
        header("Location: dashboard.php");
        exit();

    }

    $keyword = "";
    if(isset($_GET['search'])) {
        $keyword = mysqli_real_escape_string($connect, $_GET['search']);
    }

    $sql = "SELECT * FROM anggota WHERE 
            nama LIKE '%$keyword%' OR
            nis LIKE '%$keyword%'
            ORDER BY id DESC";
    $result = mysqli_query($connect, $sql);

?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Perpustakaan Dashboard</title>
  <link rel="stylesheet" href="../../css/dashboard.css" />
</head>
<body>

  <!-- ─── NAVBAR ─────────────────────────────────────── -->
  <nav class="navbar">
    <a href="#" class="navbar-brand">
      <div class="logo-icon">📚</div>
      <span class="brand-name">PUSTAKA<span>X</span></span>
    </a>

    <ul class="navbar-nav">
      <li class="nav-item">
        <a href="../buku/index.php">
          <span class="nav-icon">📖</span>
          BUKU
        </a>
      </li>
      <li class="nav-item">
        <a href="../../transaksi/index.php">
          <span class="nav-icon">🔄</span>
          TRANSAKSI
        </a>
      </li>
      <li class="nav-item">
        <a href="anggota/index.php" class="active">
          <span class="nav-icon">👤</span>
          ANGGOTA
        </a>
      </li>
    </ul>

    <div class="navbar-end">
      <button class="btn-notif">
        🔔
        <span class="notif-dot"></span>
      </button>
      <div class="avatar">AD</div>
    </div>
  </nav>

  <!-- ─── MAIN LAYOUT ─────────────────────────────────── -->
  <div class="main-wrapper">

    <!-- ─── SIDEBAR ─────────────────────────────────── -->
  <?php include '../layouts/sidebar.php'; ?>

    <!-- ─── CONTENT ─────────────────────────────────── -->
    <main class="content">
      <div class="page-header">
        <h1 class="page-title">Dashboard Perpustakaan</h1>
        <p class="page-subtitle">Selamat datang kembali, Admin — Selasa, 7 April 2026</p>
      </div>

      <!-- ─── TABLE ─────────────────────────────────── -->
      <div class="table-section">
        <div class="table-header">
          <span class="table-title">Daftar Anggota</span>
          <div class="table-actions">
            <input class="search-input" type="text" name="search" 
                placeholder="🔍 Cari anggota" 
                value="<?= htmlspecialchars($keyword) ?>" />
            <button type="submit">Cari</button> </form>
            <a href="add.php" class="btn btn-primary" style="text-decoration: none;">＋ Tambah Anggota</a>
          </div>
        </div>

        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Anggota</th>
              <th>NIS</th>
              <th>Kelas</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
                if(mysqli_num_rows($result) > 0){
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result)) :
            ?>
            <tr>
              <td class="td-id"><?= htmlspecialchars($row['id'])?></td>
              <td class="td-title"><?= htmlspecialchars($row['nama'])?></td>
              <td class="td-author"><?= htmlspecialchars($row['nis'])?></td>
              <td><?= htmlspecialchars($row['kelas'])?></td>
              <td>
                <div class="action-btns">
                  <button class="btn-icon" title="Edit"><a href="edit.php?id=<?= $row['id']?>">✏️</a></button>
                  <button class="btn-icon del" title="Hapus"><a href="dashboard.php?delete=<?= $row['id']?>">🗑</a></button>
                </div>
              </td>
            </tr>
            <?php 
                    endwhile;
                } else {
                    echo "<tr><td colspan='7' style='text-align:center;'>Tidak ada buku ditemukan.</td></tr>";
                }
                ?>
          </tbody>
        </table>

        <div class="table-footer">
          <span class="table-info">Menampilkan 1–7 dari 248 buku</span>
          <div class="pagination">
            <button class="page-btn">‹</button>
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">…</button>
            <button class="page-btn">36</button>
            <button class="page-btn">›</button>
          </div>
        </div>
      </div>

    </main>
  </div>

</body>
</html>