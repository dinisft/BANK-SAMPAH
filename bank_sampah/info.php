<?php
// Koneksi database
$conn = mysqli_connect("localhost", "root", "", "bank_sampah");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

session_start();
// (Optional: jika ingin hanya user login yang bisa lihat info, buka komentar di bawah)
// if (!isset($_SESSION['user_id'])) {
//     header("Location: index.php");
//     exit;
// }

// Ambil data harga sampah
$query_harga = "SELECT jenis_sampah, harga_per_kg FROM harga_sampah ORDER BY jenis_sampah";
$result_harga = mysqli_query($conn, $query_harga);

// Ambil data jadwal
$query_jadwal = "SELECT hari, jam_buka, jam_tutup, keterangan FROM jadwal ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')";
$result_jadwal = mysqli_query($conn, $query_jadwal);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Info Bank Sampah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f8f0; }
        .card-header-custom { background: #2e7d32; color: white; }
        .table-harga th { background: #d4edda; }
    </style>
</head>
<body>
    <!-- Navbar sederhana (mirip dengan dashboard) -->
    <nav class="navbar navbar-expand-lg bg-success">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="dashboard.php">🏦 Bank Sampah</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="setor.php">Setor Sampah</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="riwayat.php">Riwayat</a></li>
                    <li class="nav-item"><a class="nav-link text-white active" href="info.php">Info</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="tarik.php">Tarik Poin</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-4">📢 Informasi Bank Sampah</h2>
        
        <div class="row">
            <!-- Kolom Harga -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header card-header-custom">
                        <h5 class="mb-0">💰 Harga Sampah per Kilogram</h5>
                    </div>
                    <div class="card-body">
                        <?php if (mysqli_num_rows($result_harga) > 0): ?>
                            <table class="table table-bordered table-hover">
                                <thead class="table-harga">
                                    <tr><th>Jenis Sampah</th><th>Harga (Rp/kg)</th></tr>
                                </thead>
                                <tbody>
                                    <?php while($row = mysqli_fetch_assoc($result_harga)): ?>
                                    <tr>
                                        <td><?= ucfirst($row['jenis_sampah']) ?></td>
                                        <td>Rp <?= number_format($row['harga_per_kg'], 0, ',', '.') ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="alert alert-warning">Belum ada data harga. Silakan tambah di phpMyAdmin.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Kolom Jadwal -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header card-header-custom">
                        <h5 class="mb-0">📅 Jadwal Buka & Jemput</h5>
                    </div>
                    <div class="card-body">
                        <?php if (mysqli_num_rows($result_jadwal) > 0): ?>
                            <table class="table table-bordered table-hover">
                                <thead class="table-harga">
                                    <tr><th>Hari</th><th>Jam Buka</th><th>Jam Tutup</th><th>Keterangan</th></tr>
                                </thead>
                                <tbody>
                                    <?php while($row = mysqli_fetch_assoc($result_jadwal)): ?>
                                    <tr>
                                        <td><?= $row['hari'] ?></td>
                                        <td><?= date('H:i', strtotime($row['jam_buka'])) ?></td>
                                        <td><?= date('H:i', strtotime($row['jam_tutup'])) ?></td>
                                        <td><?= htmlspecialchars($row['keterangan']) ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="alert alert-warning">Belum ada data jadwal. Silakan tambah di phpMyAdmin.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3 text-center">
            <a href="dashboard.php" class="btn btn-secondary">← Kembali ke Dashboard</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>