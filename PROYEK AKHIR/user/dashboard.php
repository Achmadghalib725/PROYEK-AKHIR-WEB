<?php
session_start();
if ($_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}
require_once "../config/db.php";

// Filter berdasarkan kategori
$filter = isset($_GET['kategori']) ? "AND kategori_id = " . $_GET['kategori'] : "";
$buku = mysqli_query($conn, "SELECT * FROM buku WHERE status='tersedia' $filter");

// Ambil semua kategori
$kategori = mysqli_query($conn, "SELECT * FROM kategori");
?>

<h2>Daftar Buku Tersedia</h2>

<form method="GET">
    <label>Filter Kategori:</label>
    <select name="kategori" onchange="this.form.submit()">
        <option value="">-- Semua --</option>
        <?php while($k = mysqli_fetch_assoc($kategori)) : ?>
            <option value="<?= $k['id'] ?>" <?= isset($_GET['kategori']) && $_GET['kategori'] == $k['id'] ? 'selected' : '' ?>>
                <?= $k['nama'] ?>
            </option>
        <?php endwhile; ?>
    </select>
</form>

<table border="1" cellpadding="8">
    <tr>
        <th>Judul</th>
        <th>Penulis</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($buku)) : ?>
    <tr>
        <td><?= $row['judul'] ?></td>
        <td><?= $row['penulis'] ?></td>
        <td>
            <a href="pinjam.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin meminjam buku ini?')">Pinjam</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<a href="buku_saya.php">📚 Lihat Buku yang Sedang Dipinjam</a> | 
<a href="edit_profil.php">✏️ Edit Profil</a> | 
<a href="../logout.php">Logout</a>
