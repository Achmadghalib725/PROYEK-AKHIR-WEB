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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #f0f2f5, #d9e4f5);
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #007BFF;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h2 {
            margin: 0;
            font-size: 24px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav a:hover {
            text-decoration: underline;
            color: #ffe082;
        }

        .container {
            padding: 30px 40px;
            flex: 1; /* Menyesuaikan tinggi agar mendorong footer ke bawah */
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin-top: 0;
            font-size: 20px;
            color: #333;
        }

        .card p {
            color: #555;
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
            background-color: #007BFF;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .card a:hover {
            background-color: #0056b3;
        }

        footer {
            text-align: center;
            padding: 20px;
            color: #888;
            font-size: 14px;
            background-color: #f9f9f9;
            border-top: 1px solid #ddd;
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
