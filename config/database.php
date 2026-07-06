<?php
$host = 'localhost';
$user = 'root';
$pass = '';      // default XAMPP password kosong
$dbname = 'bank_sampah';

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");
?>