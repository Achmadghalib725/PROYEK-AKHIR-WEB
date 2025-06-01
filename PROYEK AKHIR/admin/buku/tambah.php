<?php
session_start();
require_once "../../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun = $_POST['tahun'];
    $kategori = $_POST['kategori'];
    
    $query = "INSERT INTO buku (judul, penulis, tahun_terbit, id_kategori) 
              VALUES ('$judul', '$penulis', '$tahun', '$kategori')";
    mysqli_query($conn, $query);
    header("Location: index.php");
}

$kategori = mysqli_query($conn, "SELECT * FROM kategori");
?>

<h2>Tambah Buku</h2>
<form method="post">
    <label>Judul:</label><br>
    <input type="text" name="judul" required><br><br>

    <label>Penulis:</label><br>
    <input type="text" name="penulis" required><br><br>

    <label>Tahun Terbit:</label><br>
    <input type="number" name="tahun" required><br><br>

    <label>Kategori:</label><br>
    <select name="kategori" required>
        <?php while ($k = mysqli_fetch_assoc($kategori)) : ?>
            <option value="<?= $k['id'] ?>"><?= $k['nama_kategori'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <button type="submit">Simpan</button>
</form>
<a href="index.php">Kembali</a>
