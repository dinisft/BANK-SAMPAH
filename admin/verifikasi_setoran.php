<?php
require_once '../config/database.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

// Proses terima/tolak
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $aksi = $_POST['aksi'];
    $poin = isset($_POST['poin']) ? (int)$_POST['poin'] : 0;

    if ($aksi == 'terima') {
        // Ambil data setoran
        $q = mysqli_query($conn, "SELECT user_id, berat_kg, jenis_sampah FROM setoran WHERE id=$id");
        $data = mysqli_fetch_assoc($q);
        $user_id = $data['user_id'];
        // Ambil harga per kg
        $harga = mysqli_fetch_assoc(mysqli_query($conn, "SELECT harga_per_kg FROM harga_sampah WHERE jenis_sampah='{$data['jenis_sampah']}'"))['harga_per_kg'];
        $poin_dapat = $data['berat_kg'] * $harga;
        // Update setoran
        mysqli_query($conn, "UPDATE setoran SET status='diterima', poin_didapat=$poin_dapat WHERE id=$id");
        // Update saldo & poin user
        mysqli_query($conn, "UPDATE users SET saldo = saldo + $poin_dapat, poin = poin + $poin_dapat WHERE id=$user_id");
    } elseif ($aksi == 'tolak') {
        mysqli_query($conn, "UPDATE setoran SET status='ditolak' WHERE id=$id");
    }
    header("Location: verifikasi_setoran.php");
    exit;
}

$query = "SELECT s.*, u.nama FROM setoran s JOIN users u ON s.user_id = u.id WHERE s.status='pending' ORDER BY s.created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head><title>Verifikasi Setoran</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container mt-4">
    <h2>Verifikasi Setoran Sampah</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Kembali</a>
    <?php if (mysqli_num_rows($result) == 0): ?>
        <div class="alert alert-info">Tidak ada setoran menunggu verifikasi.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead><tr><th>ID</th><th>Nasabah</th><th>Jenis</th><th>Berat (kg)</th><th>Foto</th><th>Tgl</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= ucfirst($row['jenis_sampah']) ?></td>
                    <td><?= $row['berat_kg'] ?></td>
                    <td><?php if($row['foto']): ?><a href="../uploads/<?= $row['foto'] ?>" target="_blank">Lihat</a><?php else: ?>-<?php endif; ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <form method="POST" style="display:inline-block">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="aksi" value="terima" class="btn btn-success btn-sm" onclick="return confirm('Terima setoran ini?')">Terima</button>
                        </form>
                        <form method="POST" style="display:inline-block">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="aksi" value="tolak" class="btn btn-danger btn-sm" onclick="return confirm('Tolak setoran ini?')">Tolak</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>