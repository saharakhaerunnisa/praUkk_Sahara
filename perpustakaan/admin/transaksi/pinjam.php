<?php
include '../../config.php';
session_start();

// 1. Proteksi Halaman
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../../index.php");
    exit();
}



// 3. Query Data Transaksi yang sedang dipinjam
$sql = "SELECT * FROM peminjaman WHERE status = 'Dipinjam' ORDER BY id DESC";
$result = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PustakaX — Portal Siswa</title>
  <link rel="stylesheet" href="../css/siswa.css"/>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono&display=swap" rel="stylesheet">
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
        <a href="#" >
          <span class="nav-icon">📖</span>
          BUKU
        </a>
      </li>
      <li class="nav-item">
        <a href="transaksi/riwayat.php" class="active">
          <span class="nav-icon">🔄</span>
          TRANSAKSI
        </a>
      </li>
      <li class="nav-item">
        <a href="#">
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

  <!-- ─── MAIN LAYOUT ─────────────────────────────────────── -->
  <div class="main-wrapper">
    <main class="content">

      <!-- ─── GREETING ──────────────────────────────────── -->
      <div class="greeting-banner">
        <div class="greeting-left">
          <h2>Halo, <span><?php echo $user; ?></span> 👋</h2>
        </div>
      </div>

      <!-- ─── TABLE BUKU ─────────────────────────────────── -->
      <div class="table-section" id="bukuTable">
        <div class="table-header" style="flex-wrap: wrap; gap: 12px;">
          <span class="table-title">📖 Koleksi Buku Perpustakaan</span>
          <div class="filter-bar">
            <input
              class="search-input"
              type="text"
              id="searchInput"
              placeholder="🔍  Cari judul, pengarang, ISBN..."
              style="width: 260px;"
              oninput="filterTable()"
            />
            <select class="filter-select" id="filterKategori" onchange="filterTable()">
              <option value="">Semua Kategori</option>
              <option value="Novel">Novel</option>
              <option value="Sejarah">Sejarah</option>
              <option value="Filsafat">Filsafat</option>
              <option value="Romansa">Romansa</option>
              <option value="Thriller">Thriller</option>
              <option value="Sains">Sains</option>
              <option value="Teknologi">Teknologi</option>
            </select>
            <select class="filter-select" id="filterStatus" onchange="filterTable()">
              <option value="">Semua Status</option>
              <option value="Tersedia">Tersedia</option>
              <option value="Dipinjam">Dipinjam</option>
              <option value="Stok Habis">Stok Habis</option>
            </select>
          </div>
        </div>

       <table>
  <thead>
    <tr>
      <th>ID Pinjam</th>
      <th>ID Anggota</th>
      <th>ID Buku</th>
      <th>Tgl Pinjam</th>
      <th>Tgl Kembali</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </thead>
 <tbody id="tableBody">
    <?php
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)) :
            $status = $row['status'];
            $badgeClass = ($status == 'Dipinjam') ? 'badge-dipinjam' : 'badge-tersedia';
    ?>
    <tr>
      <td class="td-id">#<?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['id_anggota']) ?></td>
      <td><?= htmlspecialchars($row['id_buku']) ?></td>
      <td><?= date('d M Y', strtotime($row['tanggal_pinjam'])) ?></td>
      <td><?= date('d M Y', strtotime($row['tanggal_kembali'])) ?></td>
      <td><span class="badge <?= $badgeClass ?>"><?= $status ?></span></td>

    </tr>
    <?php 
        endwhile;
    } else {
        echo "<tr><td colspan='7' style='text-align:center;'>Tidak ada transaksi aktif.</td></tr>";
    }
    ?>
</tbody>
</table>

        <div id="emptyState" class="empty-state" style="display:none;">
          <div class="empty-icon">🔍</div>
          <p>Tidak ada buku yang sesuai dengan pencarian.</p>
        </div>

        <div class="table-footer">
          <span class="table-info" id="tableFooterInfo">Menampilkan 1–10 dari 10 buku</span>
          <div class="pagination">
            <button class="page-btn">‹</button>
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">›</button>
          </div>
        </div>
      </div>

    </main>
  </div>

  <!-- ─── TOAST ─────────────────────────────────────────────── -->
  <div class="toast" id="toast">
    <span class="toast-icon">✅</span>
    <span id="toastMsg">Peminjaman berhasil diajukan!</span>
  </div>

  <!-- ─── SCRIPT ───────────────────────────────────────────── -->
  <script>
    const bukuData = [
      { no:'01', cover:'📗', isbn:'978-602-291-123', judul:'Laskar Pelangi',       pengarang:'Andrea Hirata',           kategori:'Novel',     stok:5, status:'Tersedia' },
      { no:'02', cover:'📘', isbn:'978-602-291-456', judul:'Bumi Manusia',         pengarang:'Pramoedya Ananta Toer',   kategori:'Sejarah',   stok:0, status:'Dipinjam' },
      { no:'03', cover:'📙', isbn:'978-602-291-789', judul:'Negeri 5 Menara',      pengarang:'Ahmad Fuadi',             kategori:'Novel',     stok:0, status:'Stok Habis' },
      { no:'04', cover:'📕', isbn:'978-602-291-012', judul:'Perahu Kertas',        pengarang:'Dee Lestari',             kategori:'Romansa',   stok:7, status:'Tersedia' },
      { no:'05', cover:'📒', isbn:'978-602-291-345', judul:'Filosofi Teras',       pengarang:'Henry Manampiring',       kategori:'Filsafat',  stok:3, status:'Dipinjam' },
      { no:'06', cover:'📓', isbn:'978-602-291-678', judul:'Sang Pemimpi',         pengarang:'Andrea Hirata',           kategori:'Novel',     stok:4, status:'Tersedia' },
      { no:'07', cover:'📔', isbn:'978-602-291-901', judul:'Pulang',               pengarang:'Tere Liye',               kategori:'Thriller',  stok:0, status:'Dipinjam' },
      { no:'08', cover:'📗', isbn:'978-602-291-234', judul:'Sapiens',              pengarang:'Yuval Noah Harari',       kategori:'Sejarah',   stok:2, status:'Tersedia' },
      { no:'09', cover:'📘', isbn:'978-602-291-567', judul:'A Brief History of Time', pengarang:'Stephen Hawking',     kategori:'Sains',     stok:1, status:'Tersedia' },
      { no:'10', cover:'📙', isbn:'978-602-291-890', judul:'Clean Code',           pengarang:'Robert C. Martin',        kategori:'Teknologi', stok:0, status:'Stok Habis' },
    ];

    let selectedBook = null;

    function badgeClass(status) {
      if (status === 'Tersedia')   return 'badge-tersedia';
      if (status === 'Dipinjam')   return 'badge-dipinjam';
      return 'badge-habis';
    }


    // HAPUS bukuData dan renderTable karena kita pakai PHP untuk list data.
    
    function filterTable() {
        // Karena data di-render oleh PHP, filter client-side (JS) 
        // harus membaca baris tabel secara manual:
        const input = document.getElementById("searchInput").value.toUpperCase();
        const rows = document.getElementById("tableBody").getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            let text = rows[i].textContent || rows[i].innerText;
            rows[i].style.display = text.toUpperCase().indexOf(input) > -1 ? "" : "none";
        }
    }

    function handleLogout(e) {
        e.preventDefault();
        if (confirm('Yakin ingin keluar?')) {
            window.location.href = "../../logout.php"; 
        }
    }
    </script>
</body>
</html>