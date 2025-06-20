<?php
session_start();
require_once "config/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

// Ambil daftar kategori untuk dropdown
$kategori_query = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$kategori_result = mysqli_query($conn, $kategori_query);

// Ambil filter yang dipilih
$selected_kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Bangun query dasar untuk mengambil data buku
$sql = "SELECT b.id, b.judul, b.penulis, b.tahun_terbit, b.status, k.nama_kategori 
        FROM buku b 
        JOIN kategori k ON b.id_kategori = k.id";

// Tambahkan filter WHERE berdasarkan input
$where_clauses = [];
if ($selected_kategori) {
    $where_clauses[] = "b.id_kategori = " . intval($selected_kategori);
}
if ($search_query) {
    $where_clauses[] = "(b.judul LIKE '%" . mysqli_real_escape_string($conn, $search_query) . "%' OR b.penulis LIKE '%" . mysqli_real_escape_string($conn, $search_query) . "%')";
}

if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(' AND ', $where_clauses);
}

$sql .= " ORDER BY b.judul ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard User - Sistem Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fdf8e1;
            margin: 0; 
            padding: 0;
            color: #582f0e;
        }
        header {
            background-color: #a2d2ff;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h2 {
            margin: 0;
            font-weight: 600;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 600;
            transition: color 0.3s;
        }
        nav a:hover {
            color: #ffafcc;
        }
        .container {
            padding: 30px 40px;
            flex: 1;
        }
        .card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.07);
        }
        .card h3 {
            margin-top: 0;
            font-size: 20px;
            color: #582f0e;
            font-weight: 600;
        }
        .filter-container {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
        }
        .filter-group label {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 14px;
        }
        .filter-group select, .filter-group input {
            padding: 10px;
            border: 1px solid #e9edc9;
            border-radius: 8px;
            min-width: 200px;
        }
        .filter-group input[type="submit"] {
             background-color: #bde0fe;
             color: #582f0e;
             font-weight: 600;
             cursor: pointer;
             transition: background-color 0.3s;
        }
        .filter-group input[type="submit"]:hover {
             background-color: #ffafcc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px 20px;
            border-bottom: 1px solid #e9edc9;
            text-align: left;
        }
        th {
            background-color: #fefcf5;
            font-weight: 600;
        }
        tbody tr:hover {
            background-color: #fefcf5;
        }
        .action-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
            background-color: #bde0fe;
            color: #582f0e;
        }
        .action-btn:hover {
            background-color: #ffafcc;
        }
        .action-btn:disabled {
            background-color: #e0e0e0;
            color: #a0a0a0;
            cursor: not-allowed;
        }
        footer {
            text-align: center;
            padding: 20px;
            color: #bca37f;
            border-top: 1px solid #e9edc9;
        }
        /* Modal Styles */
        .modal {
            display: none; position: fixed; z-index: 100; left: 0; top: 0;
            width: 100%; height: 100%; overflow: auto; 
            background-color: rgba(88, 47, 14, 0.4);
        }
        .modal-content {
            background-color: #fefefe; margin: 15% auto; padding: 30px;
            border: 1px solid #e9edc9; width: 80%; max-width: 500px;
            border-radius: 16px; text-align: center;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        .close {
            color: #aaa; float: right; font-size: 28px; font-weight: bold;
        }
        .close:hover, .close:focus {
            color: #582f0e; text-decoration: none; cursor: pointer;
        }
    </style>
</head>
<body>

<header>
    <h2> Perpustakaan Digital</h2>
    <nav>
        <a href="user/profile.php">Profil Saya</a>
        <a href="user/buku_saya.php">Buku Saya</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
    <div class="card">
        <h3>👋 Halo, <?= htmlspecialchars($_SESSION['username']) ?>!</h3>
        <p>Silakan telusuri dan pinjam buku yang tersedia di bawah ini.</p>
    </div>
    
    <div class="card">
        <h3>🔍 Cari & Filter Buku</h3>
        <form method="GET" action="">
            <div class="filter-container">
                <div class="filter-group">
                    <label for="search">Cari Judul / Penulis</label>
                    <input type="text" name="search" id="search" placeholder="Masukkan kata kunci..." value="<?= htmlspecialchars($search_query) ?>">
                </div>
                <div class="filter-group">
                    <label for="kategori">Filter Kategori</label>
                    <select name="kategori" id="kategori">
                        <option value="">-- Semua Kategori --</option>
                        <?php mysqli_data_seek($kategori_result, 0); ?>
                        <?php while ($kategori = mysqli_fetch_assoc($kategori_result)): ?>
                            <option value="<?= $kategori['id'] ?>" <?= ($selected_kategori == $kategori['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars(trim($kategori['nama_kategori'])) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="filter-group" style="align-self: flex-end;">
                    <input type="submit" value="Terapkan">
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <h3>📚 Daftar Buku</h3>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Tahun Terbit</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($book = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($book['judul']) ?></td>
                            <td><?= htmlspecialchars(trim($book['nama_kategori'])) ?></td>
                            <td><?= htmlspecialchars($book['penulis']) ?></td>
                            <td><?= htmlspecialchars($book['tahun_terbit']) ?></td>
                            <td>
                                <span style="color: <?= $book['status'] == 'tersedia' ? '#2e7d32' : '#d32f2f'; ?>; font-weight: 600;">
                                    <?= ucfirst($book['status']) ?>
                                </span>
                            </td>
                            <td>
                                <form method="post" action="user/pinjam.php" style="margin:0;">
                                    <input type="hidden" name="book_id" value="<?= $book['id'] ?>" />
                                    <button class="action-btn" type="submit" <?= $book['status'] == 'tersedia' ? '' : 'disabled' ?> onclick="return confirm('Yakin ingin meminjam buku ini?')">
                                        <?= $book['status'] == 'tersedia' ? 'Pinjam' : 'Dipinjam' ?>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>Tidak ada buku yang cocok dengan kriteria pencarian Anda.</p>
        <?php endif; ?>
    </div>
</main>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
        <p id="modal-message"></p>
    </div>
</div>

<script>
    // Script untuk menampilkan modal notifikasi dari URL
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const message = urlParams.get('message');
        if (message) {
            const modal = document.getElementById("myModal");
            const messageEl = document.getElementById("modal-message");
            let msgText = '';
            if(message === 'success') {
                msgText = 'Buku berhasil dipinjam!';
            } else if(message === 'buku_sudah_dipinjam') {
                msgText = 'Maaf, buku ini sudah dipinjam oleh orang lain.';
            } else {
                msgText = 'Terjadi kesalahan. Silakan coba lagi.';
            }
            messageEl.innerText = msgText;
            modal.style.display = "block";
        }
    };

    // Script untuk menutup modal
    var modal = document.getElementById("myModal");
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<footer>
    &copy; <?= date("Y") ?> Sistem Perpustakaan
</footer>

</body>
</html>