<?php
include '../../koneksi/db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM user WHERE id = $id");
header("Location: ../index_admin.php");
?>
