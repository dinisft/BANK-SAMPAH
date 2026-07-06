<?php
$title = "Riwayat Setoran";
require_once 'config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM setoran WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Setoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>📋 Riwayat Setoran Sampah</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <?php if (mysqli_num_rows($result) == 0): ?>
        <div class="alert alert-info">Belum ada data setoran. Yuk, <a href="setor.php">setor sampah</a> sekarang!</div>
    <?php else: ?>
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-success">
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis Sampah</th>
                    <th>Berat (kg)</th>
                    <th>Status</th>
                    <th>Poin Didapat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                    <td><?= ucfirst($row['jenis_sampah']) ?></td>
                    <td><?= $row['berat_kg'] ?> kg</td>
                    <td>
                        <?php if($row['status'] == 'pending'): ?>
                            <span class="badge bg-warning text-dark">Diproses</span>
                        <?php elseif($row['status'] == 'diterima'): ?>
                            <span class="badge bg-success">Diterima</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Ditolak</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $row['poin_didapat'] ?? '-' ?></td>
                    <td>
                        <?php if($row['status'] == 'pending'): ?>
                            <a href="hapus_setoran.php?id=<?= $row['id'] ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Yakin ingin menghapus setoran ini?')">🗑️ Hapus</a>
                        <?php else: ?>
                            <span class="text-muted">Tidak bisa dihapus</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Hapus parameter URL setelah beberapa detik (agar notifikasi tidak muncul terus)
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.pathname);
    }
</script>
</body>
</html>