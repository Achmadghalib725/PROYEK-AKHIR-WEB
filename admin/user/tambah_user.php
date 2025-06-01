<?php
include '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Gunakan hash!
    $role = $_POST['role'];

    $conn->query("INSERT INTO user (username, password, role)
                  VALUES ('$username', '$password', '$role')");
    header("Location: ../index_admin.php");
}
?>

<form method="POST">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    Role:
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br>
    <button type="submit">Simpan</button>
</form>
