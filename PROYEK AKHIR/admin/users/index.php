<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}
require_once "../../config/db.php";

$result = mysqli_query($conn, "SELECT * FROM users");
?>

<h2>Data Akun Pengguna</h2>
<a href="tambah.php">+ Tambah Pengguna</a>
<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
        <th>Foto</th>
        <th>Aksi</th>
    </tr>
    <?php $no = 1; while($row = mysqli_fetch_assoc($result)) : ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['nama'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['role'] ?></td>
        <td>
            <?php if ($row['foto']) : ?>
                <img src="../../uploads/<?= $row['foto'] ?>" width="50">
            <?php else: ?>
                Tidak ada
            <?php endif; ?>
        </td>
        <td>
            <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus pengguna?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<a href="../../dashboard_admin.php">Kembali ke Dashboard</a>
