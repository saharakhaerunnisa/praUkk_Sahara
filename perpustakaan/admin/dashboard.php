<?php
    session_start();
    include '../config.php';

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
        header("Location: ../index.php");
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

    $sql = "SELECT * FROM buku WHERE 
            kategori LIKE '%$keyword%' OR
            judul LIKE '%$keyword%'
            ORDER BY id DESC";
    $result = mysqli_query($connect, $sql);

?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Perpustakaan Dashboard</title>
  <link rel="stylesheet" href="../css/dashboard.css" />
</head>
<body>
  <!-- ─── NAVBAR ─────────────────────────────────────── -->
   <?php include 'layouts/navbar.php'; ?>

  <!-- ─── MAIN LAYOUT ─────────────────────────────────── -->
  <div class="main-wrapper">

  <!-- ─── SIDEBAR ─────────────────────────────────── -->
  <?php include 'layouts/sidebar.php'; ?>

    <!-- ─── CONTENT ─────────────────────────────────── -->
    <main class="content">
      <div class="page-header">
        <h1 class="page-title">Dashboard Perpustakaan</h1>
        <p class="page-subtitle">Selamat datang kembali, Admin — Selasa, 7 April 2026</p>
      </div>

      <!-- ─── STAT CARDS ─────────────────────────────── -->
      <!-- <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-top">
            <span class="stat-label">Total Buku</span>
            <div class="stat-icon">📚</div>
          </div>
          <div class="stat-value">2,481</div>
          <div class="stat-change up">▲ 12 buku baru bulan ini</div>
        </div>
        <div class="stat-card">
          <div class="stat-top">
            <span class="stat-label">Dipinjam</span>
            <div class="stat-icon">🔄</div>
          </div>
          <div class="stat-value">148</div>
          <div class="stat-change up">▲ 8 dari kemarin</div>
        </div>
        <div class="stat-card">
          <div class="stat-top">
            <span class="stat-label">Total Anggota</span>
            <div class="stat-icon">👥</div>
          </div>
          <div class="stat-value">934</div>
          <div class="stat-change up">▲ 24 anggota baru</div>
        </div>
        <div class="stat-card">
          <div class="stat-top">
            <span class="stat-label">Terlambat</span>
            <div class="stat-icon">⚠️</div>
          </div>
          <div class="stat-value">17</div>
          <div class="stat-change down">▼ butuh tindakan</div>
        </div>
      </div> -->

      <!-- ─── TABLE ─────────────────────────────────── -->
      <div class="table-section">
        <div class="table-header">
          <span class="table-title">Daftar Buku</span>
          <div class="table-actions">
            <input class="search-input" type="text" name="search" 
                placeholder="🔍 Cari judul / Kategori" 
                value="<?= htmlspecialchars($keyword) ?>" />
            <button type="submit" class="btn">Cari</button> </form>
            <a href="buku/add.php" class="btn btn-primary" style="text-decoration: none;">＋ Tambah Buku</a>
          </div>
        </div>

        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Judul Buku</th>
              <th>Penulis</th>
              <th>Kategori</th>
              <th>Status</th>
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
              <td class="td-title"><?= htmlspecialchars($row['judul'])?></td>
              <td class="td-author"><?= htmlspecialchars($row['penulis'])?></td>
              <td><?= htmlspecialchars($row['kategori'])?></td>
              <?php
                $status = $row['status'];
                $badgeClass = match($status) {
                    'Tersedia'   => 'badge-tersedia',
                    'Dipinjam'   => 'badge-dipinjam',
                    'Stok Habis' => 'badge-habis',
                    default      => 'badge-habis',
                };
                ?>
              <td><span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($row['status'])?></span></td>
              <td>
                <div class="action-btns">
                  <button class="btn-icon" title="Edit"><a href="buku/edit.php?id=<?= $row['id']?>">✏️</a></button>
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