<?php
include '../../koneksi/db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM user WHERE id = $id");
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $conn->query("UPDATE user SET username='$username', role='$role', password='$hash' WHERE id=$id");
    } else {
        $conn->query("UPDATE user SET username='$username', role='$role' WHERE id=$id");
    }

    header("Location: ../index_admin.php");
}
?>

<form method="POST">
    Username: <input type="text" name="username" value="<?= $data['username'] ?>"><br>
    Password (biarkan kosong jika tidak diubah): <input type="password" name="password"><br>
    Role:
    <select name="role">
        <option value="user" <?= $data['role'] === 'user' ? 'selected' : '' ?>>User</option>
        <option value="admin" <?= $data['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
    </select><br>
    <button type="submit">Update</button>
</form>
