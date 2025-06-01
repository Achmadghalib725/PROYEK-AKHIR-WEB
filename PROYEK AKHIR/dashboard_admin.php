<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
echo "<h2>Selamat datang, Admin {$_SESSION['username']}!</h2>";
echo "<a href='logout.php'>Logout</a>";
