<?php
require_once '../config/database.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $status = $_POST['status']; // 'selesai' atau 'ditolak'
    mysqli_query($conn, "UPDATE penarikan SET status='$status' WHERE id=$id");
    // Jika ditolak, kembalikan poin ke user
    if ($status == 'ditolak') {
        $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_id, jumlah_poin FROM penarikan WHERE id=$id"));
        mysqli_query($conn, "UPDATE users SET poin = poin + {$p['jumlah_poin']} WHERE id={$p['user_id']}");
    }
    header("Location: verifikasi_penarikan.php");
    exit;
}
$query = "SELECT p.*, u.nama FROM penarikan p JOIN users u ON p.user_id = u.id WHERE p.status='pending' ORDER BY p.created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head><title>Verifikasi Penarikan</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container mt-4">
    <h2>Verifikasi Penarikan Poin</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Kembali</a>
    <?php if (mysqli_num_rows($result) == 0): ?>
        <div class="alert alert-info">Tidak ada penarikan menunggu.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead><tr><th>ID</th><th>Nasabah</th><th>Jumlah Poin</th><th>Metode</th><th>Detail</th><th>Tgl</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= number_format($row['jumlah_poin']) ?></td>
                    <td><?= ucfirst($row['metode']) ?></td>
                    <td><?= htmlspecialchars($row['detail']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <form method="POST" style="display:inline">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="status" value="selesai" class="btn btn-success btn-sm" onclick="return confirm('Tandai selesai?')">Selesai</button>
                            <button type="submit" name="status" value="ditolak" class="btn btn-danger btn-sm" onclick="return confirm('Tolak penarikan?')">Tolak</button>
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