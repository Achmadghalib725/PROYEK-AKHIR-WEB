<?php
session_start();
require_once "config/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

// Ambil daftar kategori untuk dropdown
$kategori_query = "SELECT * FROM kategori";
$kategori_result = mysqli_query($conn, $kategori_query);

// Ambil kategori yang dipilih dari dropdown
$selected_kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Ambil daftar buku yang statusnya tersedia, filter berdasarkan kategori jika ada
$sql = "SELECT b.id, b.judul, b.penulis, b.status, k.nama_kategori 
        FROM buku b 
        JOIN kategori k ON b.id_kategori = k.id";
if ($selected_kategori) {
    $sql .= " WHERE b.id_kategori = " . intval($selected_kategori);
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard User - Sistem Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0; padding: 0;
        }
        header {
            background-color: #007BFF;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h2 {
            margin: 0;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            padding: 20px 30px;
        }
        h3 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        button.pinjam-btn {
            padding: 7px 15px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button.pinjam-btn.available {
            background-color: #28a745; /* Warna untuk buku tersedia */
        }
        button.pinjam-btn.available:hover {
            background-color: #218838;
        }
        button.pinjam-btn.borrowed {
            background-color: #dc3545; /* Warna untuk buku dipinjam */
            cursor: not-allowed; /* Menonaktifkan kursor */
        }
        footer {
            text-align: center;
            margin-top: 40px;
            color: #666;
        }
        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header>
    <h2>Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <nav>
        <a href="user/profile.php">Profil Saya</a>
        <a href="user/buku_saya.php">Buku saya</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<main>
    <h3>Daftar Buku Tersedia</h3>

    <!-- Dropdown untuk memilih kategori -->
    <form method="GET" action="">
        <label for="kategori">Pilih Kategori:</label>
        <select name="kategori" id="kategori" onchange="this.form.submit()">
            <option value="">-- Semua Kategori --</option>
            <?php while ($kategori = mysqli_fetch_assoc($kategori_result)): ?>
                <option value="<?= $kategori['id'] ?>" <?= ($selected_kategori == $kategori['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($kategori['nama_kategori']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php if (isset($_GET['message'])): ?>
        <script>
            window.onload = function() {
                var modal = document.getElementById("myModal");
                modal.style.display = "block";
                var message = document.getElementById("modal-message");
                message.innerText = "<?php echo $_GET['message'] == 'success' ? 'Buku berhasil dipinjam!' : 'Terjadi kesalahan saat meminjam buku. Silakan coba lagi.'; ?>";
            }
        </script>
    <?php endif; ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($book = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($book['judul']) ?></td>
                    <td><?= htmlspecialchars($book['nama_kategori']) ?></td>
                    <td><?= htmlspecialchars($book['penulis']) ?></td>
                    <td>
                        <form method="post" action="user/pinjam.php" style="margin:0;">
                            <input type="hidden" name="book_id" value="<?= $book['id'] ?>" />
                            <?php if ($book['status'] == 'tersedia'): ?>
                                <button class="pinjam-btn available" type="submit" onclick="return confirm('Yakin ingin meminjam buku ini?')">Pinjam</button>
                            <?php else: ?>
                                <button class="pinjam-btn borrowed" type="button" disabled>Buku Dipinjam</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada buku tersedia saat ini.</p>
    <?php endif; ?>
</main>

<!-- Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
        <p id="modal-message"></p>
    </div>
</div>

<script>
// Close the modal when the user clicks anywhere outside of it
window.onclick = function(event) {
    var modal = document.getElementById("myModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<footer>
    &copy; <?= date("Y") ?> Sistem Perpustakaan
</footer>

</body>
</html>
