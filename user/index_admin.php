<?php
include '../koneksi/db.php';

// Ambil data buku
$buku = $conn->query("SELECT * FROM buku");

// Ambil data user
$user = $conn->query("SELECT * FROM user");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-bottom: 40px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        a.button { padding: 5px 10px; background: #007BFF; color: white; text-decoration: none; border-radius: 4px; }
        a.button:hover { background: #0056b3; }
    </style>
</head>
<body>

<h2>Data Buku</h2>
<a href="buku/tambah_buku.php" class="button">Tambah Buku</a>
<table>
    <tr>
        <th>ID</th><th>Judul</th><th>Penulis</th><th>Tahun</th><th>Kategori</th><th>Status</th><th>Aksi</th>
    </tr>
    <?php while ($row = $buku->fetch_assoc()) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['judul_buku'] ?></td>
        <td><?= $row['nama_penulis'] ?></td>
        <td><?= $row['tahun_terbit'] ?></td>
        <td><?= $row['kategori'] ?></td>
        <td><?= $row['status'] ? 'Tersedia' : 'Tidak Tersedia' ?></td>
        <td>
            <a href="buku/edit_buku.php?id=<?= $row['id'] ?>" class="button">Edit</a>
            <a href="buku/hapus_buku.php?id=<?= $row['id'] ?>" class="button" onclick="return confirm('Yakin?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>

<h2>Data User</h2>
<a href="user/tambah_user.php" class="button">Tambah User</a>
<table>
    <tr>
        <th>ID</th><th>Username</th><th>Role</th><th>Aksi</th>
    </tr>
    <?php while ($row = $user->fetch_assoc()) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['username'] ?></td>
        <td><?= $row['role'] ?></td>
        <td>
            <a href="user/edit_user.php?id=<?= $row['id'] ?>" class="button">Edit</a>
            <a href="user/hapus_user.php?id=<?= $row['id'] ?>" class="button" onclick="return confirm('Yakin?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
