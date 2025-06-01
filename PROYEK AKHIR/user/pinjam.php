<?php
session_start();
require_once "../config/db.php";

// Pastikan pengguna sudah login dan memiliki peran 'user'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['book_id'])) {
    $book_id = filter_var($_POST['book_id'], FILTER_SANITIZE_NUMBER_INT);
    $user_id = $_SESSION['id'];
    
    // Validasi input
    if (filter_var($book_id, FILTER_VALIDATE_INT) === false) {
        header("Location: ../dashboard_user.php?message=error");
        exit();
    }
    
    // Mulai transaksi untuk konsistensi data
    mysqli_begin_transaction($conn);

    try {
        // Cek status buku terkini
        $check = mysqli_query($conn, "SELECT status FROM buku WHERE id = $book_id FOR UPDATE");
        if (!$check || mysqli_num_rows($check) === 0) {
            // Buku tidak ditemukan
            mysqli_rollback($conn);
            header("Location: ../dashboard_user.php?message=buku_tidak_ditemukan");
            exit();
        }

        $row = mysqli_fetch_assoc($check);
        if ($row['status'] !== 'tersedia') {
            // Buku sudah dipinjam
            mysqli_rollback($conn);
            header("Location: ../dashboard_user.php?message=buku_sudah_dipinjam");
            exit();
        }

        // Update status buku menjadi dipinjam
        $update = mysqli_query($conn, "UPDATE buku SET status='dipinjam' WHERE id=$book_id");
        if (!$update) {
            mysqli_rollback($conn);
            header("Location: ../dashboard_user.php?message=gagal_update_status");
            exit();
        }

        // Insert data peminjaman
        $tanggal_pinjam = date('Y-m-d H:i:s');
        $insert = mysqli_query($conn, "INSERT INTO peminjaman (id_user, id_buku, tanggal_pinjam) VALUES ($user_id, $book_id, '$tanggal_pinjam')");
        if (!$insert) {
            mysqli_rollback($conn);
            header("Location: ../dashboard_user.php?message=gagal_input_data");
            exit();
        }

        mysqli_commit($conn);
        header("Location: ../dashboard_user.php?message=success");
        exit();
    } catch (Exception $e) {
        mysqli_rollback($conn);
        header("Location: ../dashboard_user.php?message=error");
        exit();
    }
} else {
    header("Location: ../dashboard_user.php?message=error");
    exit();
}
?>
