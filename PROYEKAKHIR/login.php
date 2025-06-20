<?php
session_start();
require_once "config/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi input
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        $error = "Username dan Password tidak boleh kosong!";
    } else {
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = $_POST["password"];

        // Menggunakan prepared statement untuk menghindari SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && mysqli_num_rows($result) === 1) {
            $user = $result->fetch_assoc();

            // Verifikasi password
            if (password_verify($password, $user["password"])) {
                $_SESSION["id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["role"] = $user["role"];

                if ($user["role"] == "admin") {
                    header("Location: dashboard_admin.php");
                } else {
                    header("Location: dashboard_user.php");
                }
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Akun tidak ditemukan!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Perpustakaan</title>
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
        .login-box {
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
            margin-bottom: 5px;
        }
        h3 {
            text-align: center;
            color: #a2d2ff;
            font-weight: 600;
            margin-top: 0;
            margin-bottom: 25px;
        }
        .form-group { margin-bottom: 20px; }
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
        .btn { 
            padding: 12px; 
            background: #bde0fe; 
            color: #582f0e; 
            border: none; 
            width: 100%; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #ffafcc;
        }
        .error, .success {
            text-align: center; 
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
        }
        .error { 
            color: #d32f2f; 
            background-color: #ffcdd2;
        }
        /* Style baru untuk pesan sukses */
        .success {
            color: #2e7d32;
            background-color: #c8e6c9;
        }
        p.bottom-text {
            text-align: center; 
            margin-top: 20px;
            color: #582f0e;
        }
        p.bottom-text a {
            color: #a2d2ff;
            text-decoration: none;
            font-weight: 600;
        }
        p.bottom-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="login-box">
    <h2>PINJEMIN</h2>
    <h3>Login</h3>
    
    <?php if (isset($_GET['registered'])) : ?>
        <p class="success">Registrasi berhasil! Silakan login.</p>
    <?php endif; ?>
    <?php if (isset($_GET['message']) && $_GET['message'] == 'profile_deleted_successfully') : ?>
        <p class="success">Akun Anda telah berhasil dihapus.</p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" required autocomplete="off">
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <button class="btn" type="submit">Login</button>
    </form>

    <p class="bottom-text">
        Belum punya akun? 
        <a href="register.php">Daftar di sini</a>
    </p>
</div>
</body>
</html>
