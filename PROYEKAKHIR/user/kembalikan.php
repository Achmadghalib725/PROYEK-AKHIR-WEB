<?php
session_start();
require_once "../config/db.php";

// Pastikan pengguna sudah login dan memiliki peran 'user'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['book_id'])) {
    $book_id = filter_var($_POST['book_id'], FILTER_SANITIZE_NUMBER_INT);
    $user_id = $_SESSION['id'];

    // Mulai transaksi untuk konsistensi data
    mysqli_begin_transaction($conn);

    try {
        // Update status buku menjadi 'tersedia'
        $update = mysqli_query($conn, "UPDATE buku SET status='tersedia' WHERE id=$book_id");
        if (!$update) {
            mysqli_rollback($conn);
            header("Location: buku_saya.php?message=gagal_update_status");
            exit();
        }

        // Hapus data peminjaman dari tabel peminjaman
        $delete = mysqli_query($conn, "DELETE FROM peminjaman WHERE id_user=$user_id AND id_buku=$book_id");
        if (!$delete) {
            mysqli_rollback($conn);
            header("Location: buku_saya.php?message=gagal_hapus_data");
            exit();
        }

        mysqli_commit($conn);
        header("Location: buku_saya.php?message=success");
        exit();
    } catch (Exception $e) {
        mysqli_rollback($conn);
        header("Location: buku_saya.php?message=error");
        exit();
    }
} else {
    header("Location: buku_saya.php?message=error");
    exit();
}
?>
