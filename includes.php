<?php
session_start();
if (!isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) != 'index.php') {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Sampah - <?php echo $title ?? 'Home'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-success" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">🏦 Bank Sampah</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="setor.php">Setor Sampah</a></li>
                <li class="nav-item"><a class="nav-link" href="riwayat.php">Riwayat</a></li>
                <li class="nav-item"><a class="nav-link" href="info.php">Info Harga & Jadwal</a></li>
                <li class="nav-item"><a class="nav-link" href="tarik.php">Tarik/Tukar Poin</a></li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">