<?php
session_start();
require_once "../../config/db.php";

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM buku WHERE id = $id");

header("Location: index.php");
