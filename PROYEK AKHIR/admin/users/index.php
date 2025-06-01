<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}
require_once "../../config/db.php";

$result = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Akun Pengguna - Sistem Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #007BFF;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .foto {
            width: 50px;
            border-radius: 50%;
        }
        .action-links {
            display: flex;
            gap: 10px;
        }
        .action-links a {
            padding: 5px 10px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .action-links a:hover {
            background-color: #0056b3;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Data Akun Pengguna</h2>
    <a href="tambah.php">+ Tambah Pengguna</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama Lengkap</th>
            <th>Keterangan</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
            <td><?= htmlspecialchars($row['keterangan']) ?></td>
            <td>
                <?php if ($row['foto']) : ?>
                    <img src="../../assets/<?= htmlspecialchars($row['foto']) ?>" class="foto" alt="Foto Pengguna">
                <?php else: ?>
                    Tidak ada
                <?php endif; ?>
            </td>
            <td class="action-links">
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus pengguna?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="../../dashboard_admin.php">Kembali ke Dashboard</a>
</div>

<footer>
    &copy; <?= date("Y") ?> Sistem Perpustakaan
</footer>

</body>
</html>
