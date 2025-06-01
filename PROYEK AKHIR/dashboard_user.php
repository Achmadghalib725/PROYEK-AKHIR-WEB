<?php
session_start();
require_once "config/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

// Ambil daftar buku yang statusnya tersedia
$sql = "SELECT * FROM buku WHERE status = 'tersedia'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard User - Sistem Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0; padding: 0;
        }
        header {
            background-color: #007BFF;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h2 {
            margin: 0;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            padding: 20px 30px;
        }
        h3 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
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
        button.pinjam-btn {
            padding: 7px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button.pinjam-btn:hover {
            background-color: #218838;
        }
        footer {
            text-align: center;
            margin-top: 40px;
            color: #666;
        }
    </style>
</head>
<body>

<header>
    <h2>Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <nav>
        <a href="user/profile.php">Profil Saya</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<main>
    <h3>Daftar Buku Tersedia</h3>
    <?php if (isset($_GET['message'])): ?>
        <?php if ($_GET['message'] == 'success'): ?>
            <p style="color: green;">Buku berhasil dipinjam!</p>
        <?php elseif ($_GET['message'] == 'error'): ?>
            <p style="color: red;">Terjadi kesalahan saat meminjam buku. Silakan coba lagi.</p>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($book = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($book['judul']) ?></td>
                    <td><?= htmlspecialchars($book['id_kategori']) ?></td>
                    <td><?= htmlspecialchars($book['penulis']) ?></td>
                    <td>
                        <form method="post" action="pinjam.php" style="margin:0;">
                            <input type="hidden" name="book_id" value="<?= $book['id'] ?>" />
                            <button class="pinjam-btn" type="submit" onclick="return confirm('Yakin ingin meminjam buku ini?')">Pinjam</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada buku tersedia saat ini.</p>
    <?php endif; ?>
</main>

<footer>
    &copy; <?= date("Y") ?> Sistem Perpustakaan
</footer>

</body>
</html>
