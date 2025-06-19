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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fdf8e1;
            margin: 0; 
            padding: 0;
            color: #582f0e;
        }
        header {
            background-color: #a2d2ff;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h2 {
            margin: 0;
            font-weight: 600;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 600;
            transition: color 0.3s;
        }
        nav a:hover {
            color: #ffafcc;
        }
        main {
            padding: 30px 40px;
        }
        h3 {
            color: #582f0e;
            font-weight: 600;
            font-size: 22px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.05);
            border-radius: 16px;
            overflow: hidden;
        }
        th, td {
            padding: 15px 20px;
            border-bottom: 1px solid #e9edc9;
            text-align: left;
        }
        th {
            background-color: #bde0fe;
            color: #582f0e;
            font-weight: 600;
        }
        tr:hover {
            background-color: #fefcf5;
        }
        tr:last-child td {
            border-bottom: none;
        }
        button.pinjam-btn {
            padding: 8px 16px;
            color: #582f0e;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        button.pinjam-btn.available {
            background-color: #a9d6a9; 
        }
        button.pinjam-btn.available:hover {
            background-color: #97c497;
        }
        button.pinjam-btn.borrowed {
            background-color: #ffb4a2;
            cursor: not-allowed;
        }
        footer {
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            color: #bca37f;
            border-top: 1px solid #e9edc9;
        }
        .filter-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.05);
        }
        .filter-form label {
            font-weight: 600;
            margin-right: 10px;
        }
        .filter-form select {
            padding: 10px;
            border: 1px solid #e9edc9;
            border-radius: 8px;
            min-width: 200px;
        }
        /* Modal Styles */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 100; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(88, 47, 14, 0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; 
            padding: 30px;
            border: 1px solid #e9edc9;
            width: 80%;
            max-width: 500px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: #582f0e;
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

    <form method="GET" action="" class="filter-form">
        <label for="kategori">Pilih Kategori:</label>
        <select name="kategori" id="kategori" onchange="this.form.submit()">
            <option value="">-- Semua Kategori --</option>
            <?php mysqli_data_seek($kategori_result, 0); // Reset pointer ?>
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
                var msgText = "<?php echo $_GET['message']; ?>";
                if(msgText === 'success') {
                    message.innerText = 'Buku berhasil dipinjam!';
                } else if(msgText === 'buku_sudah_dipinjam') {
                    message.innerText = 'Maaf, buku ini sudah dipinjam oleh orang lain.';
                } else {
                    message.innerText = 'Terjadi kesalahan. Silakan coba lagi.';
                }
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
                                <button class="pinjam-btn borrowed" type="button" disabled>Dipinjam</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada buku tersedia dalam kategori ini.</p>
    <?php endif; ?>
</main>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
        <p id="modal-message"></p>
    </div>
</div>

<script>
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
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