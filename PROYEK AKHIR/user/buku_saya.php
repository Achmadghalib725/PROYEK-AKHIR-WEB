<?php
session_start();
if ($_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}
require_once "../config/db.php";

$buku = mysqli_query($conn, "SELECT * FROM buku WHERE status='dipinjam'");
?>

<h2>Buku yang Sedang Dipinjam</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Judul</th>
        <th>Penulis</th>
        <th>Status</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($buku)) : ?>
    <tr>
        <td><?= $row['judul'] ?></td>
        <td><?= $row['penulis'] ?></td>
        <td><?= $row['status'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<a href="dashboard.php">⬅️ Kembali ke Dashboard</a>
