<?php
include '../../koneksi/db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM buku WHERE id = $id");
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun = $_POST['tahun'];
    $kategori = $_POST['kategori'];
    $status = isset($_POST['status']) ? 1 : 0;

    $conn->query("UPDATE buku SET 
        judul_buku = '$judul',
        nama_penulis = '$penulis',
        tahun_terbit = '$tahun',
        kategori = '$kategori',
        status = $status
        WHERE id = $id");

    header("Location: ../index_admin.php");
}
?>

<form method="POST">
    Judul: <input type="text" name="judul" value="<?= $data['judul_buku'] ?>"><br>
    Penulis: <input type="text" name="penulis" value="<?= $data['nama_penulis'] ?>"><br>
    Tahun Terbit: <input type="number" name="tahun" value="<?= $data['tahun_terbit'] ?>"><br>
    Kategori: <input type="text" name="kategori" value="<?= $data['kategori'] ?>"><br>
    Tersedia: <input type="checkbox" name="status" <?= $data['status'] ? 'checked' : '' ?>><br>
    <button type="submit">Update</button>
</form>
