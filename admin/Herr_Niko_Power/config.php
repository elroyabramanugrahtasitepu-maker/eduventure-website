<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_eduventure";

// Pastikan urutannya: host, user, password, database
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>