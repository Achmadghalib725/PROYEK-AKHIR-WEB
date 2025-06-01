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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku - Sistem Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #007BFF;
        }
        .edit-box {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            color: #333;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .bottom-text {
            text-align: center;
            margin-top: 20px;
        }
        .bottom-text a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }
        .bottom-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="edit-box">
    <h2>Edit Buku</h2>
    <form method="post">
        <div class="form-group">
            <label>Judul:</label>
            <input type="text" name="judul" value="<?= htmlspecialchars($data['judul']) ?>" required>
        </div>
        <div class="form-group">
            <label>Penulis:</label>
            <input type="text" name="penulis" value="<?= htmlspecialchars($data['penulis']) ?>" required>
        </div>
        <div class="form-group">
            <label>Tahun:</label>
            <input type="number" name="tahun" value="<?= htmlspecialchars($data['tahun_terbit']) ?>" required>
        </div>
        <div class="form-group">
            <label>Kategori:</label>
            <select name="kategori" required>
                <?php while ($k = mysqli_fetch_assoc($kategori)) : ?>
                    <option value="<?= $k['id'] ?>" <?= $data['id_kategori'] == $k['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($k['nama_kategori']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Status:</label>
            <select name="status" required>
                <option value="tersedia" <?= $data['status'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                <option value="dipinjam" <?= $data['status'] == 'dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
            </select>
        </div>
        <button type="submit">Simpan</button>
    </form>
    <div class="bottom-text">
        <a href="index.php">Kembali</a>
    </div>
</div>

</body>
</html>
