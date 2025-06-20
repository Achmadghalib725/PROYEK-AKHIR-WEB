<?php
session_start();
require_once "../config/db.php";

// Pastikan pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aksi untuk menghapus foto profil
    if (isset($_POST['delete_photo'])) {
        $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT foto FROM users WHERE id=$id"));
        $current_photo = $user['foto'];

        // Hapus file foto lama jika ada dan bukan default
        if ($current_photo && $current_photo !== 'default-profile.png') {
            if (file_exists("../assets/" . $current_photo)) {
                unlink("../assets/" . $current_photo);
            }
        }

        // Update database, set kolom foto menjadi NULL
        $stmt = mysqli_prepare($conn, "UPDATE users SET foto = NULL WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        
        header("Location: edit_profil.php?message=photo_deleted");
        exit();
    } 
    // Aksi untuk menyimpan perubahan profil (logika yang sudah ada)
    else if (isset($_POST['update_profile'])) {
        $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT foto FROM users WHERE id=$id"));
        
        // Escape input untuk mencegah SQL Injection
        $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
        $foto = $user['foto']; // Menyimpan foto lama secara default

        // Upload foto baru jika ada
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

            if (in_array($ext, $allowed_ext)) {
                if ($user['foto'] && $user['foto'] !== 'default-profile.png' && file_exists("../assets/" . $user['foto'])) {
                    unlink("../assets/" . $user['foto']);
                }
                
                $filename = uniqid() . "." . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/" . $filename);
                $foto = $filename;
            }
        }

        // Update data pengguna di database
        $update_query = "UPDATE users SET nama_lengkap='$nama_lengkap', username='$username', keterangan='$keterangan', foto='$foto' WHERE id=$id";
        mysqli_query($conn, $update_query);
        $_SESSION['username'] = $username;
        
        header("Location: profile.php?message=update_success");
        exit();
    }
}

// Ambil data user terbaru untuk ditampilkan di form
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - Sistem Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif; background-color: #fdf8e1;
            padding: 40px; margin: 0; color: #582f0e;
        }
        .edit-box {
            max-width: 600px; margin: auto; background: #fff;
            padding: 40px; border-radius: 16px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }
        h2 { text-align: center; color: #a2d2ff; margin-bottom: 25px; font-weight: 600; }
        .form-group { margin-bottom: 20px; }
        label { font-weight: 600; color: #582f0e; display: block; margin-bottom: 8px; }
        input[type="text"], textarea, input[type="file"] {
            width: 100%; padding: 12px; border: 1px solid #e9edc9; border-radius: 8px;
            box-sizing: border-box; background-color: #fefcf5; color: #582f0e;
            font-family: 'Poppins', sans-serif;
        }
        textarea { resize: vertical; min-height: 80px; }
        button, .btn {
            width: 100%; padding: 12px; border: none; border-radius: 8px;
            cursor: pointer; font-size: 16px; font-weight: 600;
            transition: background-color 0.3s; text-align: center;
            display: inline-block; box-sizing: border-box; text-decoration: none;
        }
        .btn-save { background-color: #bde0fe; color: #582f0e; margin-bottom: 15px; }
        .btn-save:hover { background-color: #ffafcc; }
        .btn-delete-photo { background-color: #ffb4a2; color: #582f0e; }
        .btn-delete-photo:hover { background-color: #e59887; }
        .btn-danger { background-color: #ff758f; color: white; margin-top: 10px; }
        .btn-danger:hover { background-color: #e0647c; }
        .bottom-text { text-align: center; margin-top: 20px; }
        .bottom-text a { color: #a2d2ff; text-decoration: none; font-weight: 600; }
        .bottom-text a:hover { text-decoration: underline; }
        .current-photo-container { display: flex; align-items: center; gap: 20px; margin-bottom: 10px; }
        .current-photo {
            width: 100px; height: 100px; object-fit: cover;
            border-radius: 50%; border: 3px solid #bde0fe;
        }
        .notification {
            padding: 15px; background-color: #a9d6a9; color: #582f0e;
            border-radius: 8px; margin-bottom: 20px; text-align: center;
        }
    </style>
</head>
<body>

<div class="edit-box">
    <h2>Edit Profil</h2>

    <?php if(isset($_GET['message']) && $_GET['message'] == 'photo_deleted'): ?>
        <div class="notification">
            Foto profil berhasil dihapus.
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" required>
        </div>
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>
        <div class="form-group">
            <label>Keterangan:</label>
            <textarea name="keterangan" required><?= htmlspecialchars($user['keterangan']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Foto Profil:</label>
            <div class="current-photo-container">
                <img src="../assets/<?= htmlspecialchars($user['foto'] ?? 'default-profile.png') ?>" class="current-photo" alt="Foto Profil">
                <?php if ($user['foto']): ?>
                    <button type="submit" name="delete_photo" class="btn btn-delete-photo" onclick="return confirm('Yakin ingin menghapus foto profil?')">Hapus Foto</button>
                <?php endif; ?>
            </div>
            <input type="file" name="foto" accept="image/png, image/jpeg, image/gif">
            <small style="color: #bca37f;">Kosongkan jika tidak ingin mengubah foto.</small>
        </div>
        <button type="submit" name="update_profile" class="btn btn-save">Simpan Perubahan</button>
    </form>
    <div class="bottom-text">
        <a href="profile.php">Kembali ke Profil</a>
    </div>
    
    <hr style="border: 1px solid #e9edc9; margin: 30px 0;">

    <div class="danger-zone">
        <h3 style="text-align: center; color: #d32f2f;">Zona Berbahaya</h3>
        <p style="text-align: center; color: #582f0e;">Tindakan ini akan menghapus akun Anda secara permanen.</p>
        <a href="hapus_profil.php" class="btn btn-danger" onclick="return confirm('APAKAH ANDA YAKIN INGIN MENGHAPUS PROFIL INI SECARA PERMANEN?')">Hapus Akun Saya</a>
    </div>
</div>

</body>
</html>
