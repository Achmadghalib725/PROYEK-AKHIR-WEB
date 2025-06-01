<?php
session_start();
require_once "../config/db.php";

// Pastikan pengguna sudah login dan memiliki peran 'user'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

// Ambil ID buku dari permintaan
if (isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];

    // Update status buku menjadi 'dipinjam'
    $query = "UPDATE buku SET status='dipinjam' WHERE id=$book_id";
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, redirect kembali ke dashboard user dengan pesan sukses
        header("Location: dashboard_user.php?message=success");
    } else {
        // Jika gagal, redirect dengan pesan error
        header("Location: dashboard_user.php?message=error");
    }
    exit();
} else {
    // Jika tidak ada book_id yang diterima, redirect ke dashboard dengan pesan error
    header("Location: dashboard_user.php?message=error");
    exit();
}
?>
