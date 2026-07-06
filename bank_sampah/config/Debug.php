<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'bank_sampah';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
} else {
    echo "Koneksi berhasil ke database <strong>$dbname</strong><br>";
}

mysqli_set_charset($conn, "utf8");
?>