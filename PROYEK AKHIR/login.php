<?php
session_start();
require_once "config/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

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
?>

<?php if (isset($_GET['registered'])) : ?>
    <p style="color: green;">Registrasi berhasil! Silakan login.</p>
<?php endif; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Perpustakaan</title>
    <style>
        body { font-family: Arial; background-color: #f4f4f4; padding: 40px; }
        .login-box {
            max-width: 400px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; }
        .form-group { margin-bottom: 15px; }
        label, input { display: block; width: 100%; }
        input[type="text"], input[type="password"] {
            padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;
        }
        .btn { padding: 10px; background: #007BFF; color: white; border: none; width: 100%; border-radius: 5px; cursor: pointer; }
        .error { color: red; text-align: center; margin-top: 10px; }
    </style>
</head>
<div class="login-box">
        <h2>Login</h2>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
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

        <p style="text-align: center; margin-top: 15px;">
            Belum punya akun? 
            <a href="register.php" style="color: #007BFF; text-decoration: none; font-weight: bold;">
                Daftar di sini
            </a>
        </p>
    </div>
    
</body>
</html>
