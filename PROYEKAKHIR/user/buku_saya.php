<?php
session_start();
if ($_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}
require_once "../config/db.php";

// Ambil ID pengguna dari session
$user_id = $_SESSION['id'];

// Ambil data buku yang sedang dipinjam oleh pengguna
$buku = mysqli_query($conn, "SELECT b.id, b.judul, b.penulis, p.tanggal_pinjam 
                              FROM peminjaman p 
                              JOIN buku b ON p.id_buku = b.id 
                              WHERE p.id_user = $user_id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku yang Sedang Dipinjam - Sistem Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fdf8e1;
            padding: 40px;
            margin: 0;
            color: #582f0e;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }
        h2 {
            text-align: center;
            color: #a2d2ff;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            overflow: hidden;
            border-radius: 12px;
        }
        th, td {
            padding: 15px;
            border-bottom: 1px solid #e9edc9;
            text-align: left;
        }
        th {
            background-color: #bde0fe;
            font-weight: 600;
        }
        tr:hover {
            background-color: #fefcf5;
        }
        tr:last-child td {
            border-bottom: none;
        }
        button {
            padding: 8px 12px;
            background-color: #ffb4a2; 
            color: #582f0e;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #e5988e;
        }
        .bottom-text {
            text-align: center;
            margin-top: 20px;
        }
        .bottom-text a {
            color: #a2d2ff;
            text-decoration: none;
            font-weight: 600;
        }
        .bottom-text a:hover {
            text-decoration: underline;
        }
        .no-books {
            text-align: center;
            margin-top: 20px;
            padding: 30px;
            background-color: #fefcf5; 
            border: 1px solid #e9edc9;
            border-radius: 12px;
            color: #bca37f;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Buku yang Sedang Dipinjam</h2>

    <?php if (mysqli_num_rows($buku) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Tanggal Pinjam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($buku)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['judul']) ?></td>
                    <td><?= htmlspecialchars($row['penulis']) ?></td>
                    <td><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>
                    <td>
                        <form method="post" action="kembalikan.php" style="margin:0;">
                            <input type="hidden" name="book_id" value="<?= $row['id'] ?>" />
                            <button type="submit" onclick="return confirm('Yakin ingin mengembalikan buku ini?')">Kembalikan</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-books">
            <h4>Tidak ada buku yang sedang dipinjam saat ini.</h4>
            <p>Silakan pinjam buku dari daftar buku yang tersedia di dashboard Anda.</p>
        </div>
    <?php endif; ?>

    <div class="bottom-text">
        <a href="../dashboard_user.php">Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>
