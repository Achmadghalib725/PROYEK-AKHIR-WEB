<?php
session_start();
require_once "../config/db.php";

// Pastikan pengguna sudah login dan memiliki ID di session
if (!isset($_SESSION['id'])) {
    // Jika tidak, redirect ke halaman login
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['id'];

// Menggunakan transaksi database untuk memastikan semua query berhasil atau tidak sama sekali
mysqli_begin_transaction($conn);

try {
    // 1. Hapus semua riwayat peminjaman yang terkait dengan pengguna ini
    // Ini penting untuk menjaga integritas data (foreign key constraints)
    $stmt1 = mysqli_prepare($conn, "DELETE FROM peminjaman WHERE id_user = ?");
    mysqli_stmt_bind_param($stmt1, "i", $user_id);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);

    // 2. Hapus data pengguna dari tabel `users`
    $stmt2 = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt2, "i", $user_id);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);
    
    // Jika semua query berhasil, commit transaksi
    mysqli_commit($conn);

    // Hapus file foto profil dari server jika ada
    if (isset($_SESSION['foto']) && $_SESSION['foto'] && $_SESSION['foto'] !== 'default-profile.png') {
        if (file_exists("../assets/" . $_SESSION['foto'])) {
            unlink("../assets/" . $_SESSION['foto']);
        }
    }

    // Hancurkan session untuk logout pengguna
    session_unset();
    session_destroy();
    
    // Redirect ke halaman login dengan pesan sukses
    header("Location: ../login.php?message=profile_deleted_successfully");
    exit();

} catch (mysqli_sql_exception $exception) {
    // Jika terjadi error, batalkan semua perubahan (rollback)
    mysqli_rollback($conn);
    
    // Hancurkan session dan redirect ke halaman login dengan pesan error
    session_unset();
    session_destroy();
    header("Location: ../login.php?message=profile_delete_failed");
    exit();
}

?>