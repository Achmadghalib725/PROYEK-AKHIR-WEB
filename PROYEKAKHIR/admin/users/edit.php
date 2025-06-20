<?php
require_once "../../config/db.php";

$id = $_GET['id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $id"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $keterangan = $_POST['keterangan'];
    $role = $_POST['role'];

    // Cek jika password ingin diubah
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "UPDATE users SET nama_lengkap='$nama_lengkap', username='$username', keterangan='$keterangan', role='$role', password='$password' WHERE id=$id";
    } else {
        $query = "UPDATE users SET nama_lengkap='$nama_lengkap', username='$username', keterangan='$keterangan', role='$role' WHERE id=$id";
    }

    mysqli_query($conn, $query);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Akun Pengguna - Sistem Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fdf8e1;
            margin: 0;
            padding: 20px;
            color: #582f0e;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        h2 {
            text-align: center;
            color: #a2d2ff;
            font-weight: 600;
        }
        .edit-box {
            max-width: 600px;
            width: 100%;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
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
        input[type="text"], input[type="email"], input[type="password"], select {
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
    </style>
</head>
<body>

<div class="edit-box">
    <h2>Edit Akun Pengguna</h2>
    <form method="POST">
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
            <label>Ganti Password (opsional):</label>
            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin ganti">
        </div>
        <div class="form-group">
            <label>Role:</label>
            <select name="role">
                <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User </option>
                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <button type="submit">Simpan Perubahan</button>
    </form>
    <div class="bottom-text">
        <a href="index.php">Kembali</a>
    </div>
</div>

</body>
</html>
