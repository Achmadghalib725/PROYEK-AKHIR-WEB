<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit();
}
require_once "../../config/db.php";

$query = "SELECT buku.*, kategori.nama_kategori 
          FROM buku 
          JOIN kategori ON buku.id_kategori = kategori.id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Buku - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fdf8e1;
            margin: 0;
            padding: 20px;
            color: #582f0e;
        }
        h2 {
            text-align: center;
            color: #a2d2ff;
            font-weight: 600;
            font-size: 24px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }
        .add-link {
            display: inline-block;
            text-decoration: none;
            color: #582f0e;
            background-color: #bde0fe;
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: 600;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }
        .add-link:hover {
            background-color: #ffafcc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e9edc9;
        }
        th {
            background-color: #bde0fe;
            font-weight: 600;
        }
        tr:hover {
            background-color: #fefcf5;
        }
        .action-links {
            display: flex;
            gap: 10px;
        }
        .action-links a {
            padding: 6px 12px;
            background-color: #a2d2ff;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        .action-links a:hover {
            background-color: #ffafcc;
        }
        .action-links a.delete {
             background-color: #ffb4a2;
        }
        .action-links a.delete:hover {
             background-color: #e5988e;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            color: #bca37f;
            border-top: 1px solid #e9edc9;
        }
        .back-link{
            display: inline-block;
            margin-top: 20px;
            font-weight: 600;
            color: #a2d2ff;
            text-decoration: none;
        }
        .back-link:hover{
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Data Buku</h2>
    <a href="tambah.php" class="add-link">+ Tambah Buku</a>
    <table>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Tahun</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td><?= htmlspecialchars($row['penulis']) ?></td>
            <td><?= htmlspecialchars($row['tahun_terbit']) ?></td>
            <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td class="action-links">
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                <a href="hapus.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Hapus buku ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="../../dashboard_admin.php" class="back-link">Kembali ke Dashboard</a>
</div>

<footer>
    &copy; <?= date("Y") ?> Sistem Perpustakaan
</footer>

</body>
</html>