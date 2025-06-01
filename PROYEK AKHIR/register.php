<?php
require_once "config/db.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if (empty($nama_lengkap) || empty($username) || empty($password) || empty($confirm)) {
        $errors[] = "Semua field harus diisi.";
    } elseif ($password !== $confirm) {
        $errors[] = "Konfirmasi password tidak cocok.";
    } else {
        $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($cek) > 0) {
            $errors[] = "Username sudah digunakan.";
        } else {
            $password_hashed = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO users (nama_lengkap, username, password, role) 
                    VALUES ('$nama_lengkap', '$username', '$password_hashed', 'user')";

            mysqli_query($conn, $query);
            header("Location: login.php?registered=1");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Sistem Perpustakaan</title>
    <style>
        body { font-family: Arial; background-color: #f4f4f4; padding: 40px; }
        .register-box {
            max-width: 400px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label, input { display: block; width: 100%; }
        input[type="text"], input[type="password"] {
            padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            padding: 10px;
            background: #007BFF;
            color: white;
            border: none;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #0056b3;
        }
        .errors {
            color: red;
            margin-bottom: 15px;
            list-style-type: none;
            padding-left: 0;
        }
        .bottom-text {
            text-align: center;
            margin-top: 15px;
        }
        .bottom-text a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }
        .bottom-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="register-box">
        <h2>Daftar Akun</h2>

        <?php if (!empty($errors)) : ?>
            <ul class="errors">
                <?php foreach ($errors as $e) : ?>
                    <li><?= $e ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="form-group">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama_lengkap" required autocomplete="off" value="<?= isset($nama_lengkap) ? htmlspecialchars($nama_lengkap) : '' ?>">
            </div>

            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" required autocomplete="off" value="<?= isset($username) ? htmlspecialchars($username) : '' ?>">
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password:</label>
                <input type="password" name="confirm" required>
            </div>

            <button type="submit">Daftar</button>
        </form>

        <p class="bottom-text">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </p>
    </div>

</body>
</html>
