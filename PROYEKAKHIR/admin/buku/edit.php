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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fdf8e1;
            margin: 0;
            padding: 20px;
            color: #582f0e;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        h2 {
            text-align: center;
            color: #a2d2ff;
            font-weight: 600;
        }
        .edit-box {
            max-width: 600px;
            width: 100%;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: 600;
            color: #582f0e;
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 12px;
            border: 1px solid #e9edc9;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: #fefcf5;
            color: #582f0e;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #bde0fe;
            color: #582f0e;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #ffafcc;
        }
        .bottom-text {
            text-align: center;
            margin-top: 20px;
        }
        .bottom-text a {
            color: #a2d2ff;
            text-decoration: none;
            font-weight: 600;
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
        <button type="submit">Simpan Perubahan</button>
    </form>
    <div class="bottom-text">
        <a href="index.php">Kembali</a>
    </div>
</div>

</body>
</html>
