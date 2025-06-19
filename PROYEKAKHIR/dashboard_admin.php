<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Sistem Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fdf8e1;
            display: flex;
            flex-direction: column;
            color: #582f0e;
        }

        header {
            background-color: #a2d2ff;
            color: #ffffff;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        nav a {
            color: #ffffff;
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
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.07);
        }

        .card h3 {
            margin-top: 0;
            font-size: 20px;
            color: #582f0e;
            font-weight: 600;
        }

        .card p {
            color: #582f0e;
        }

        .card .button-group {
            margin-top: 15px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .card a {
            display: inline-block;
            padding: 12px 18px;
            background-color: #bde0fe;
            color: #582f0e;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .card a:hover {
            background-color: #ffafcc;
        }

        footer {
            text-align: center;
            padding: 20px;
            color: #bca37f;
            font-size: 14px;
            background-color: transparent;
            border-top: 1px solid #e9edc9;
        }
    </style>
</head>
<body>

<header>
    <h2>📚 Dashboard Admin</h2>
    <nav>
        <a href="admin/users/index.php">👤 Kelola Pengguna</a>
        <a href="admin/buku/index.php">📖 Kelola Buku</a>
        <a href="logout.php">🚪 Logout</a>
    </nav>
</header>

<div class="container">
    <div class="card">
        <h3>👋 Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?>!</h3>
        <p>Anda dapat mengelola pengguna dan buku di sistem perpustakaan ini.</p>
    </div>

    <div class="card">
        <h3>🛠️ Fitur Admin</h3>
        <p>Silakan pilih salah satu fitur di bawah ini:</p>
        <div class="button-group">
            <a href="admin/users/index.php">👤 Kelola Pengguna</a>
            <a href="admin/buku/index.php">📖 Kelola Buku</a>
        </div>
    </div>
</div>

<footer>
    &copy; <?= date("Y") ?> Sistem Perpustakaan.
</footer>

</body>
</html>