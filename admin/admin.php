<?php
require_once '../config/database.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

// Statistik
$total_nasabah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role='nasabah'"))['total'];
$total_setoran_pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM setoran WHERE status='pending'"))['total'];
$total_penarikan_pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM penarikan WHERE status='pending'"))['total'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Admin Panel - Bank Sampah</h2>
    <p>Halo, <?= htmlspecialchars($_SESSION['nama']) ?> (Admin)</p>
    <div class="row mt-4">
        <div class="col-md-4"><div class="card text-white bg-primary"><div class="card-body"><h5>Total Nasabah</h5><h2><?= $total_nasabah ?></h2></div></div></div>
        <div class="col-md-4"><div class="card text-white bg-warning"><div class="card-body"><h5>Setoran Menunggu</h5><h2><?= $total_setoran_pending ?></h2></div></div></div>
        <div class="col-md-4"><div class="card text-white bg-danger"><div class="card-body"><h5>Penarikan Menunggu</h5><h2><?= $total_penarikan_pending ?></h2></div></div></div>
    </div>
    <div class="mt-4">
        <a href="verifikasi_setoran.php" class="btn btn-primary">Verifikasi Setoran</a>
        <a href="verifikasi_penarikan.php" class="btn btn-warning">Verifikasi Penarikan</a>
        <a href="kelola_harga.php" class="btn btn-info">Kelola Harga Sampah</a>
        <a href="kelola_jadwal.php" class="btn btn-secondary">Kelola Jadwal</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>
</body>
</html>