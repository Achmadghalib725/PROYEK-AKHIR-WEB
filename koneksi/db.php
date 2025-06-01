<?php
$conn = mysqli_connect("localhost", "root", "", "uas");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>