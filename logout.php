<?php
// connection 
include "connection.php";

session_start();  // Mulai sesi
session_unset();  // Hapus semua data sesi
session_destroy();  // Hancurkan sesi
header("Location: login.php");  // Redirect ke halaman login
exit();
?>

