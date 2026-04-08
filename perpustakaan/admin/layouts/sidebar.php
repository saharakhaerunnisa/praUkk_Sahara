<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php $base_url = "http://localhost/perpustakaan/admin/"; ?>

        <!-- ─── SIDEBAR ─────────────────────────────────── -->
    <aside class="sidebar">
      <span class="sidebar-label">Menu Utama</span>

      <a href="<?= $base_url; ?>dashboard.php" class="sidebar-item active">
        <span class="s-icon">🏠</span>
        Dashboard
      </a>
      <a href="<?= $base_url; ?>dashboard.php" class="sidebar-item">
        <span class="s-icon">📖</span>
        Daftar Buku
        <span class="sidebar-badge">248</span>
      </a>
      <a href="<?= $base_url; ?> buku/add.php" class="sidebar-item">
        <span class="s-icon">➕</span>
        Tambah Buku
      </a>
      <a href="#" class="sidebar-item">
        <span class="s-icon">🗂️</span>
        Kategori
      </a>

      <span class="sidebar-label" style="margin-top: 8px;">Transaksi</span>

      <a href="<?= $base_url; ?>transaksi/pinjam.php" class="sidebar-item">
        <span class="s-icon">🔄</span>
        Peminjaman
        <span class="sidebar-badge">12</span>
      </a>
      <a href="<?= $base_url; ?>transaksi/kembali.php" class="sidebar-item">
        <span class="s-icon">↩️</span>
        Pengembalian
      </a>
      <a href="<?= $base_url; ?>transaksi/riwayat.php" class="sidebar-item">
        <span class="s-icon">📋</span>
        Riwayat
      </a>

      <span class="sidebar-label" style="margin-top: 8px;">Anggota</span>

      <a href="<?= $base_url; ?>anggota/index.php" class="sidebar-item">
        <span class="s-icon">👥</span>
        Semua Anggota
      </a>
      <a href="a<?= $base_url; ?>nggota/add.php" class="sidebar-item">
        <span class="s-icon">➕</span>
        Tambah Anggota
      </a>

      <span class="sidebar-label" style="margin-top: 8px;">Sistem</span>
      <a href="#" class="sidebar-item">
        <span class="s-icon">⚙️</span>
        Pengaturan
      </a>
    </aside>
</body>
</html>