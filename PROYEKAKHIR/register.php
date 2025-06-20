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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #fdf8e1; 
            padding: 40px; 
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .register-box {
            max-width: 400px;
            width: 100%;
            margin: auto;
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.05);
        }
        h2 { 
            text-align: center; 
            color: #582f0e;
            font-weight: 600;
            margin-bottom: 25px;
        }
        .form-group { margin-bottom: 15px; }
        label { 
            display: block; 
            width: 100%; 
            font-weight: 600;
            color: #582f0e;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] {
            padding: 12px; 
            margin-top: 5px; 
            border: 1px solid #e9edc9; 
            border-radius: 8px;
            width: 100%;
            box-sizing: border-box;
            color: #582f0e;
        }
        button {
            padding: 12px;
            background: #bde0fe;
            color: #582f0e;
            border: none;
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background: #ffafcc;
        }
        .errors {
            color: #ffb4a2;
            margin-bottom: 15px;
            list-style-type: none;
            padding: 10px;
            border-radius: 8px;
            background-color: #fff1f0;
            text-align: center;
        }
        .bottom-text {
            text-align: center;
            margin-top: 20px;
            color: #582f0e;
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

    <div class="register-box">
        <h2>Daftar Akun PINJEMIN</h2>

        <?php if (!empty($errors)) : ?>
            <div class="errors">
                <?php foreach ($errors as $e) : ?>
                    <p><?= $e ?></p>
                <?php endforeach; ?>
            </div>
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
