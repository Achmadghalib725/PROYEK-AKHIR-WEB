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
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
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
        .container {
            margin-top: 20px;
        }
        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card h3 {
            margin-top: 0;
        }
        .card a {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .card a:hover {
            background-color: #0056b3;
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
    <h2>Dashboard Admin</h2>
    <nav>
        <a href="admin/users/index.php">Kelola Pengguna</a>
        <a href="admin/buku/index.php">Kelola Buku</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
    <div class="card">
        <h3>Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?>!</h3>
        <p>Anda dapat mengelola pengguna dan buku di sistem perpustakaan ini.</p>
    </div>

    <div class="card">
        <h3>Fitur Admin</h3>
        <p>Silakan pilih salah satu fitur di bawah ini:</p>
        <a href="admin/users/index.php">Kelola Pengguna</a>
        <a href="admin/buku/index.php">Kelola Buku</a>
    </div>
</div>

<footer>
    &copy; <?= date("Y") ?> Sistem Perpustakaan
</footer>

</body>
</html>
