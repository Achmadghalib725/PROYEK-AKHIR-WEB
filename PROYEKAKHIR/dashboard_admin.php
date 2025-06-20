<?php
session_start();
// Autentikasi dan otorisasi admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Sertakan file koneksi database
require_once "config/db.php"; 

// 1. Query untuk menghitung jumlah pengguna
$result_users = mysqli_query($conn, "SELECT COUNT(id) as total_users FROM users");
$total_users = mysqli_fetch_assoc($result_users)['total_users'];

// 2. Query untuk menghitung jumlah buku
$result_buku = mysqli_query($conn, "SELECT COUNT(id) as total_buku FROM buku");
$total_buku = mysqli_fetch_assoc($result_buku)['total_buku'];

// 3. Query untuk mendapatkan daftar peminjaman yang aktif
$query_peminjaman = "
    SELECT 
        p.tanggal_pinjam,
        u.nama_lengkap,
        b.judul,
        b.id AS buku_id 
    FROM 
        peminjaman p
    JOIN 
        users u ON p.id_user = u.id
    JOIN 
        buku b ON p.id_buku = b.id
    ORDER BY 
        p.tanggal_pinjam DESC
";
$result_peminjaman = mysqli_query($conn, $query_peminjaman);


// PENAMBAHAN: Blok untuk memilih ucapan dan kalimat pembuka secara acak
// --------------------------------------------------------------------
$ucapan_selamat = [
    "👋 Selamat datang, ",
    "☕ Semangat Pagi, ",
    "☀️ Halo, ",
    "👍 Selamat bertugas, ",
    "📖 Senang melihat Anda kembali, "
];

$kalimat_pembuka = [
    "Ini adalah ringkasan aktivitas dan data di sistem perpustakaan.",
    "Terima kasih telah menjaga sistem ini berjalan dengan baik hari ini.",
    "Semua fitur siap membantu Anda mengelola data perpustakaan.",
    "Berikut adalah status terkini dari sistem perpustakaan Anda.",
    "Manajemen yang baik adalah kunci perpustakaan yang hebat."
];

// Pilih satu item acak dari setiap daftar
$ucapan_terpilih = $ucapan_selamat[array_rand($ucapan_selamat)];
$kalimat_terpilih = $kalimat_pembuka[array_rand($kalimat_pembuka)];
// --------------------------------------------------------------------

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Sistem Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Semua CSS Anda tetap sama seperti sebelumnya */
        html, body { height: 100%; margin: 0; }
        body { font-family: 'Poppins', sans-serif; background-color: #fdf8e1; display: flex; flex-direction: column; color: #582f0e; }
        header { background-color: #a2d2ff; color: #ffffff; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); }
        header h2 { margin: 0; font-size: 24px; font-weight: 600; }
        nav a { color: #ffffff; text-decoration: none; margin-left: 20px; font-weight: 600; transition: color 0.3s; }
        nav a:hover { color: #ffafcc; }
        .container { padding: 30px 40px; flex: 1; }
        .card { background: white; border-radius: 16px; padding: 25px; margin-bottom: 30px; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05); transition: transform 0.3s ease, box-shadow 0.3s ease; }
        a.stat-link .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.07); }
        .card h3 { margin-top: 0; font-size: 20px; color: #582f0e; font-weight: 600; }
        .card p { color: #582f0e; line-height: 1.6; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 25px; margin-bottom: 30px; }
        .stat-card { text-align: center; padding: 30px 20px; margin-bottom: 0; }
        .stat-card .stat-number { font-size: 48px; font-weight: 700; color: #a2d2ff; margin: 10px 0 0 0; }
        .stat-link { text-decoration: none; color: inherit; }
        .peminjaman-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .peminjaman-table th, .peminjaman-table td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e9edc9; }
        .peminjaman-table th { background-color: #fefcf5; font-weight: 600; }
        .peminjaman-table tbody tr:hover { background-color: #fefcf5; }
        .action-links a { padding: 6px 12px; color: white; border-radius: 6px; text-decoration: none; font-size: 14px; transition: background-color 0.3s; background-color: #a9d6a9; }
        .action-links a:hover { background-color: #97c497; }
        footer { text-align: center; padding: 20px; color: #bca37f; font-size: 14px; background-color: transparent; border-top: 1px solid #e9edc9; }
    </style>
</head>
<body>

<header>
    <h2>Dashboard Admin</h2>
    <nav>
        <a href="admin/users/index.php">Kelola Pengguna</a>
        <a href="admin/buku/index.php">Kelola Buku</a>
        <a href="admin/peminjaman/index.php">Kelola Peminjaman</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
    <div class="card">
        <h3><?= $ucapan_terpilih ?><?= htmlspecialchars($_SESSION['username']) ?>!</h3>
        <p><?= $kalimat_terpilih ?></p>
    </div>

    <div class="stats-grid">
        <a href="admin/users/index.php" class="stat-link">
            <div class="card stat-card">
                <h3>Total Pengguna</h3>
                <p class="stat-number"><?= $total_users ?></p>
            </div>
        </a>
        <a href="admin/buku/index.php" class="stat-link">
            <div class="card stat-card">
                <h3>Total Judul Buku</h3>
                <p class="stat-number"><?= $total_buku ?></p>
            </div>
        </a>
        <a href="admin/peminjaman/index.php" class="stat-link">
            <div class="card stat-card">
                <h3>Peminjaman Aktif</h3>
                <p class="stat-number"><?= mysqli_num_rows($result_peminjaman) ?></p>
            </div>
        </a>
    </div>

    <div class="card">
        <h3>Daftar Peminjaman Aktif</h3>
        <?php if (mysqli_num_rows($result_peminjaman) > 0): ?>
            <div style="overflow-x:auto;">
                <table class="peminjaman-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($peminjaman = mysqli_fetch_assoc($result_peminjaman)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($peminjaman['nama_lengkap']) ?></td>
                                <td><?= htmlspecialchars($peminjaman['judul']) ?></td>
                                <td><?= date('d F Y', strtotime($peminjaman['tanggal_pinjam'])) ?></td>
                                <td class="action-links">
                                    <a href="admin/buku/edit.php?id=<?= $peminjaman['buku_id'] ?>">Tandai Kembali</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>Tidak ada buku yang sedang dipinjam saat ini.</p>
        <?php endif; ?>
    </div>
</div>

<footer>
    &copy; <?= date("Y") ?> Sistem Perpustakaan
</footer>

</body>
</html>
