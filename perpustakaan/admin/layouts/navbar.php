<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php $base_url = "http://localhost/perpustakaan/admin/"; ?>
      <!-- ─── NAVBAR ─────────────────────────────────────── -->
  <nav class="navbar">
    <a href="#" class="navbar-brand">
      <div class="logo-icon">📚</div>
      <span class="brand-name">PUSTAKA<span>X</span></span>
    </a>

    <ul class="navbar-nav">
      <li class="nav-item">
        <a href="<?= $base_url; ?>dashboard.php">" class="active">
          <span class="nav-icon">📖</span>
          BUKU
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= $base_url; ?>transaksi/riwayat.php">
          <span class="nav-icon">🔄</span>
          TRANSAKSI
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= $base_url; ?>anggota/index.php">
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
</body>
</html>