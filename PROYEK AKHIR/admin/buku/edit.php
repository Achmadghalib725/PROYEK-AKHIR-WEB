<?php
session_start();
require_once "../../config/db.php";

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM buku WHERE id = $id"));
$kategori = mysqli_query($conn, "SELECT * FROM kategori");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun = $_POST['tahun'];
    $kategori_id = $_POST['kategori'];
    $status = $_POST['status'];

    $query = "UPDATE buku SET judul='$judul', penulis='$penulis', tahun_terbit='$tahun', id_kategori='$kategori_id', status='$status' WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: index.php");
}
?>

<h2>Edit Buku</h2>
<form method="post">
    <label>Judul:</label><br>
    <input type="text" name="judul" value="<?= $data['judul'] ?>" required><br><br>

    <label>Penulis:</label><br>
    <input type="text" name="penulis" value="<?= $data['penulis'] ?>" required><br><br>

    <label>Tahun:</label><br>
    <input type="number" name="tahun" value="<?= $data['tahun_terbit'] ?>" required><br><br>

    <label>Kategori:</label><br>
    <select name="kategori" required>
        <?php while ($k = mysqli_fetch_assoc($kategori)) : ?>
            <option value="<?= $k['id'] ?>" <?= $data['id_kategori'] == $k['id'] ? 'selected' : '' ?>>
                <?= $k['nama_kategori'] ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Status:</label><br>
    <select name="status" required>
        <option value="tersedia" <?= $data['status'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
        <option value="dipinjam" <?= $data['status'] == 'dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
    </select><br><br>

    <button type="submit">Simpan</button>
</form>
<a href="index.php">Kembali</a>
