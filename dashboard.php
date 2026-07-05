<?php
// Koneksi database
$conn = mysqli_connect("localhost", "root", "", "bank_sampah");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mulai session
session_start();

// Jika belum login, redirect ke index.php
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data user
$query = "SELECT nama, saldo, poin FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    // Jika user tidak ditemukan, logout
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bank Sampah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f8f0;
        }
        .card-dashboard {
            border-radius: 15px;
            transition: 0.3s;
        }
        .card-dashboard:hover {
            transform: translateY(-5px);
        }
        .nav-custom {
            background: #2e7d32;
        }
        .nav-custom a {
            color: white !important;
        }
    </style>
</head>
<body>
    <!-- Navbar sederhana -->
    <nav class="navbar navbar-expand-lg nav-custom">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="#">🏦 Bank Sampah</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="setor.php">Setor Sampah</a></li>
                    <li class="nav-item"><a class="nav-link" href="riwayat.php">Riwayat</a></li>
                    <li class="nav-item"><a class="nav-link" href="info.php">Info</a></li>
                    <li class="nav-item"><a class="nav-link" href="tarik.php">Tarik Poin</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success">
                    <h4>Selamat datang, <strong><?= htmlspecialchars($user['nama']) ?></strong>! 👋</h4>
                    <p>Selamat datang di Bank Sampah. Yuk, setor sampahmu dan kumpulkan poin!</p>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card text-white bg-primary card-dashboard">
                    <div class="card-body text-center">
                        <h5>💰 Saldo (Rupiah)</h5>
                        <h2 class="display-5">Rp <?= number_format($user['saldo'], 0, ',', '.') ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-warning card-dashboard">
                    <div class="card-body text-center">
                        <h5>⭐ Poin Anda</h5>
                        <h2 class="display-5"><?= number_format($user['poin']) ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4 text-center">
            <div class="col-md-4 mb-2">
                <a href="setor.php" class="btn btn-success w-100 py-3">➕ Setor Sampah</a>
            </div>
            <div class="col-md-4 mb-2">
                <a href="riwayat.php" class="btn btn-info w-100 py-3 text-white">📋 Riwayat Setoran</a>
            </div>
            <div class="col-md-4 mb-2">
                <a href="tarik.php" class="btn btn-warning w-100 py-3">💸 Tarik / Tukar Poin</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>