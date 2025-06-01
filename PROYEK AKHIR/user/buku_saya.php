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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
            margin: 0;
        }
        h2 {
            text-align: center;
            color: #007BFF;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        button {
            padding: 5px 10px;
            background-color: #dc3545; /* Warna merah untuk tombol kembalikan */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #c82333; /* Warna lebih gelap saat hover */
        }
        .bottom-text {
            text-align: center;
            margin-top: 20px;
        }
        .bottom-text a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }
        .bottom-text a:hover {
            text-decoration: underline;
        }
        .no-books {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background-color: #fff3cd; /* Warna latar belakang untuk pesan tidak ada buku */
            border: 1px solid #ffeeba; /* Border untuk pesan */
            border-radius: 5px;
            color: #856404; /* Warna teks untuk pesan */
        }
    </style>
</head>
<body>

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

</body>
</html>
