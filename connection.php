<?php
// Cek error keseluruhan
error_reporting(E_ALL);

// Database connection
$user = "root";
$pw = "mii123"; // jika anda menggunakan password di db nya
$db = "coba";
$host = "localhost";
$conn = mysqli_connect($host, $user, $pw, $db);

// // untuk tes connection
// if ($conn) {
//    echo 'connect';
// } else {
//    echo 'no connect';
// }
