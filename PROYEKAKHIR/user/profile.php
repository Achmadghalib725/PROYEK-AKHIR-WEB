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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fdf8e1;
            padding: 40px;
            margin: 0;
            color: #582f0e;
        }
        .profile-box {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
        }
        .profile-box:hover {
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.07);
        }
        h2 {
            text-align: center;
            color: #a2d2ff;
            margin-bottom: 25px;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: 600;
            color: #582f0e;
        }
        p {
            margin: 5px 0 0 0;
            color: #582f0e;
            background: #fefcf5;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e9edc9;
        }
        .profile-image {
            display: flex;
            justify-content: center;
            margin-bottom: 25px;
        }
        .profile-image img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #bde0fe;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .bottom-text {
            text-align: center;
            margin-top: 30px;
        }
        .bottom-text a {
            color: #a2d2ff;
            text-decoration: none;
            font-weight: 600;
            margin: 0 10px;
            transition: color 0.3s;
        }
        .bottom-text a:hover {
            color: #ffafcc;
            text-decoration: underline;
        }
        footer {
            text-align: center;
            margin-top: 40px;
            color: #bca37f;
        }
    </style>
</head>
<body>

<div class="profile-box">
    <h2>Profil Saya</h2>
    <div class="form-group profile-image">
        <?php if ($user['foto']): ?>
            <img src="../assets/<?= htmlspecialchars($user['foto']) ?>" alt="Foto Profil">
        <?php else: ?>
            <img src="../assets/default-profile.png" alt="Foto Profil Default"> <?php endif; ?>
    </div>
    <div class="form-group">
        <label>Nama Lengkap:</label>
        <p><?= htmlspecialchars($user['nama_lengkap']) ?></p>
    </div>
    <div class="form-group">
        <label>Username:</label>
        <p><?= htmlspecialchars($user['username']) ?></p>
    </div>
    <div class="form-group">
        <label>Keterangan</label>
        <p><?= ($user['keterangan']) ?></p>
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