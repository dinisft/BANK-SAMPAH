<?php
require_once '../config/database.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

// Tambah/Edit Harga
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['simpan'])) {
    $jenis = $_POST['jenis'];
    $harga = (int)$_POST['harga'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    if ($id > 0) {
        mysqli_query($conn, "UPDATE harga_sampah SET harga_per_kg=$harga WHERE id=$id");
    } else {
        mysqli_query($conn, "INSERT INTO harga_sampah (jenis_sampah, harga_per_kg) VALUES ('$jenis', $harga)");
    }
    header("Location: kelola_harga.php");
    exit;
}
// Hapus
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM harga_sampah WHERE id=$id");
    header("Location: kelola_harga.php");
    exit;
}
$data = mysqli_query($conn, "SELECT * FROM harga_sampah ORDER BY jenis_sampah");
?>
<!DOCTYPE html>
<html>
<head><title>Kelola Harga Sampah</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container mt-4">
    <h2>Kelola Harga Sampah per KG</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Kembali</a>
    <div class="card mb-4">
        <div class="card-header">Tambah/Edit Harga</div>
        <div class="card-body">
            <form method="POST">
                <div class="row">
                    <div class="col"><input type="text" name="jenis" class="form-control" placeholder="Jenis sampah" required></div>
                    <div class="col"><input type="number" name="harga" class="form-control" placeholder="Harga per kg" required></div>
                    <div class="col"><button type="submit" name="simpan" class="btn btn-primary">Simpan</button></div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered">
        <thead><tr><th>Jenis</th><th>Harga (Rp/kg)</th><th>Aksi</th></tr></thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?= ucfirst($row['jenis_sampah']) ?></td>
                <td><?= number_format($row['harga_per_kg'],0,',','.') ?></td>
                <td>
                    <a href="?hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>