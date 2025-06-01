<?php
session_start();
if ($_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}
require_once "../config/db.php"; 

$id = $_SESSION['id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya - Sistem Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
            margin: 0;
        }
        .profile-box {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }
        .profile-box:hover {
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            color: #007BFF;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            color: #333;
        }
        p {
            margin: 5px 0;
            color: #555;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }
        .profile-image {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }
        .profile-image img {
            border-radius: 50%;
            border: 3px solid #007BFF;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .bottom-text {
            text-align: center;
            margin-top: 20px;
        }
        .bottom-text a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
            margin: 0 10px;
            transition: color 0.3s;
        }
        .bottom-text a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        footer {
            text-align: center;
            margin-top: 40px;
            color: #666;
        }
    </style>
</head>
<body>

<div class="profile-box">
    <h2>Profil Saya</h2>
    <div class="form-group profile-image">
        <?php if ($user['foto']): ?>
            <img src="../assets/<?= htmlspecialchars($user['foto']) ?>" width="100" alt="Foto Profil">
        <?php else: ?>
            <img src="../assets/default-profile.png" width="100" alt="Foto Profil Default"> <!-- Gambar default jika tidak ada foto -->
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label>Nama Lengkap:</label>
        <p><?= htmlspecialchars($user['nama_lengkap']) ?></p>
    </div>
    <div class="form-group">
        <label>Username:</label>
        <p><?= htmlspecialchars($user['username']) ?></p>
    </div>
    
    <div class="bottom-text">
        <a href="edit_profil.php">Edit Profil</a> | 
        <a href="../dashboard_user.php">Kembali ke Dashboard</a>
    </div>
</div>

<footer>
    &copy; <?= date("Y") ?> Sistem Perpustakaan
</footer>

</body>
</html>
