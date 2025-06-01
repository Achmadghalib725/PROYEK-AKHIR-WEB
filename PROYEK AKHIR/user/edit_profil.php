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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
            margin: 0;
        }
        .edit-box {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }
        .edit-box:hover {
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
        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .bottom-text {
            text-align: center;
            margin-top: 20px;
        }
        .bottom-text a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        .bottom-text a:hover {
            color: #0056b3;
            text-decoration: underline;
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
                <img src="../assets/<?= htmlspecialchars($user['foto']) ?>" width="100" alt="Foto Profil"><br>
            <?php endif; ?>
            <input type="file" name="foto">
        </div>
        <button type="submit">Simpan</button>
    </form>
    <div class="bottom-text">
        <a href="profile.php">Kembali ke Profil</a>
    </div>
</div>

</body>
</html>
