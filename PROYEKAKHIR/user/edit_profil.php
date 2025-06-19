<?php
session_start();
require_once "../config/db.php";

// Pastikan pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = $_POST['nama_lengkap']; // Menggunakan nama_lengkap
    $username = $_POST['username']; // Menggunakan username
    $keterangan = $_POST['keterangan']; // Menggunakan keterangan
    $foto = $user['foto']; // Menyimpan foto lama

    // Upload foto baru jika ada
    if ($_FILES['foto']['name']) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION); // Mengambil ekstensi file
        $filename = uniqid() . "." . $ext; // Membuat nama file unik
        move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/" . $filename); // Simpan ke folder assets
        $foto = $filename; // Update nama file foto
    }

    // Update data pengguna di database
    $update_query = "UPDATE users SET nama_lengkap='$nama_lengkap', username='$username', keterangan='$keterangan', foto='$foto' WHERE id=$id";
    mysqli_query($conn, $update_query);
    $_SESSION['username'] = $username;
    header("Location: profile.php"); // Redirect ke halaman profil setelah berhasil
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - Sistem Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fdf8e1;
            padding: 40px;
            margin: 0;
            color: #582f0e;
        }
        .edit-box {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }
        h2 {
            text-align: center;
            color: #a2d2ff;
            margin-bottom: 25px;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: 600;
            color: #582f0e;
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #e9edc9;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: #fefcf5;
            color: #582f0e;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #bde0fe;
            color: #582f0e;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #ffafcc;
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
        .current-photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #bde0fe;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="edit-box">
    <h2>Edit Profil</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" required>
        </div>
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>
        <div class="form-group">
            <label>Keterangan:</label>
            <input type="text" name="keterangan" value="<?= htmlspecialchars($user['keterangan']) ?>" required>
        </div>
        <div class="form-group">
            <label>Foto Profil:</label><br>
            <?php if ($user['foto']): ?>
                <img src="../assets/<?= htmlspecialchars($user['foto']) ?>" class="current-photo" alt="Foto Profil"><br>
            <?php endif; ?>
            <input type="file" name="foto">
        </div>
        <button type="submit">Simpan Perubahan</button>
    </form>
    <div class="bottom-text">
        <a href="profile.php">Kembali ke Profil</a>
    </div>
</div>

</body>
</html>