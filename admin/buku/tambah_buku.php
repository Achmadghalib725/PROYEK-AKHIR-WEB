<?php
include ../'../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun = $_POST['tahun'];
    $kategori = $_POST['kategori'];
    $status = isset($_POST['status']) ? 1 : 0;

    $conn->query("INSERT INTO buku (judul_buku, nama_penulis, tahun_terbit, kategori, status)
                  VALUES ('$judul', '$penulis', '$tahun', '$kategori', $status)");
    header("Location: ../index_admin.php");
}
?>

<form method="POST">
    Judul: <input type="text" name="judul"><br>
    Penulis: <input type="text" name="penulis"><br>
    Tahun Terbit: <input type="number" name="tahun"><br>
    Kategori: <input type="text" name="kategori"><br>
    Tersedia: <input type="checkbox" name="status" checked><br>
    <button type="submit">Simpan</button>
</form>
