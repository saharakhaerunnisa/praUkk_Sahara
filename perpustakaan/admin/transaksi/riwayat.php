<?php
include '../../config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../../index.php");
    exit();
}

$sql = "SELECT * FROM peminjaman ORDER BY id DESC";
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
  <tbody>
    <?php
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)) :
            $status = $row['status'];
            $badgeClass = match($status) {
                'Dikembalikan' => 'badge-tersedia',
                'Dipinjam'     => 'badge-dipinjam',
                default        => 'badge-habis',
            };
    ?>
    <tr>
      <td class="td-id">#<?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['id_anggota']) ?></td>
      <td><?= htmlspecialchars($row['id_buku']) ?></td>
      <td><?= date('d M Y', strtotime($row['tanggal_pinjam'])) ?></td>
      <td><?= date('d M Y', strtotime($row['tanggal_kembali'])) ?></td>
      <td><span class="badge <?= $badgeClass ?>"><?= $status ?></span></td>
      <td>
        <div class="action-btns">
          <?php if($status == 'Dipinjam'): ?>
            <a href="dashboard.php?kembalikan=<?= $row['id_buku'] ?>" 
               class="btn-icon" title="Kembalikan"
               onclick="return confirm('Kembalikan buku ini?')">🔄</a>
          <?php else: ?>
            <span style="color: var(--text-muted); font-size: 12px;">Selesai</span>
          <?php endif; ?>
        </div>
      </td>
    </tr>
    <?php 
        endwhile;
    } else {
        echo "<tr><td colspan='7' style='text-align:center;'>Belum ada riwayat peminjaman.</td></tr>";
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

    function renderTable(data) {
      const tbody = document.getElementById('tableBody');
      const empty = document.getElementById('emptyState');
      const count = document.getElementById('countNum');
      const footer = document.getElementById('tableFooterInfo');

      if (data.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        count.textContent = '0';
        footer.textContent = 'Tidak ada buku ditemukan';
        return;
      }

      empty.style.display = 'none';
      count.textContent = data.length;
      footer.textContent = `Menampilkan 1–${data.length} dari ${data.length} buku`;

      tbody.innerHTML = data.map(b => `
        <tr>
          <td class="td-id">${b.no}</td>
          <td><div class="cover-placeholder">${b.cover}</div></td>
          <td class="td-id">${b.isbn}</td>
          <td class="td-title">${b.judul}</td>
          <td class="td-author">${b.pengarang}</td>
          <td>${b.kategori}</td>
          <td style="font-family:'JetBrains Mono',monospace; font-size:13px;">${b.stok}</td>
          <td><span class="badge ${badgeClass(b.status)}">${b.status}</span></td>
          <td>
            ${b.status === 'Tersedia'
              ? `<button class="btn-borrow" onclick='openModal(${JSON.stringify(b)})'>📤 Pinjam</button>`
              : `<span class="btn-disabled">— Tidak tersedia</span>`
            }
          </td>
        </tr>
      `).join('');
    }

    function filterTable() {
      const q       = document.getElementById('searchInput').value.toLowerCase();
      const kat     = document.getElementById('filterKategori').value;
      const status  = document.getElementById('filterStatus').value;

      const filtered = bukuData.filter(b => {
        const matchSearch = !q ||
          b.judul.toLowerCase().includes(q) ||
          b.pengarang.toLowerCase().includes(q) ||
          b.isbn.includes(q);
        const matchKat    = !kat    || b.kategori === kat;
        const matchStatus = !status || b.status === status;
        return matchSearch && matchKat && matchStatus;
      });

      renderTable(filtered);
    }

    function openModal(id, judul, penulis) {
        // 1. Tampilkan detail buku di dalam modal
        const detailBox = document.getElementById('modalBookDetail');
        detailBox.innerHTML = `
            <div style="color: white; font-weight: bold;">${judul}</div>
            <div style="color: #94a3b8; font-size: 13px;">${penulis}</div>
        `;

        // 2. Update link "Ajukan Pinjam" agar mengarah ke peminjaman.php dengan ID yang benar
        const btnKonfirmasi = document.getElementById('linkKonfirmasiPinjam');
        btnKonfirmasi.href = "peminjaman.php?id_buku=" + id;

        // 3. Munculkan modal
        document.getElementById('modalPinjam').classList.add('show');
    }

    function closeModal() {
        document.getElementById('modalPinjam').classList.remove('show');
    }

    function showToast(msg) {
      const toast = document.getElementById('toast');
      document.getElementById('toastMsg').textContent = msg || 'Peminjaman berhasil diajukan!';
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 3500);
    }

    function handleLogout(e) {
      e.preventDefault();
      if (confirm('Yakin ingin keluar dari Portal Siswa?')) {
        alert('Anda telah logout. Sampai jumpa! 👋');
      }
    }

    // Klik overlay untuk tutup modal
    document.getElementById('modalPinjam').addEventListener('click', function(e) {
      if (e.target === this) closeModal();
    });

    // Render awal
    renderTable(bukuData);
  </script>

</body>
</html>