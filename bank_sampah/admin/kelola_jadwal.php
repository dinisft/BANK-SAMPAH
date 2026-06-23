<?php
require_once '../config/database.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hari = $_POST['hari'];
    $jam_buka = $_POST['jam_buka'];
    $jam_tutup = $_POST['jam_tutup'];
    $keterangan = $_POST['keterangan'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    if ($id > 0) {
        mysqli_query($conn, "UPDATE jadwal SET hari='$hari', jam_buka='$jam_buka', jam_tutup='$jam_tutup', keterangan='$keterangan' WHERE id=$id");
    } else {
        mysqli_query($conn, "INSERT INTO jadwal (hari, jam_buka, jam_tutup, keterangan) VALUES ('$hari', '$jam_buka', '$jam_tutup', '$keterangan')");
    }
    header("Location: kelola_jadwal.php");
    exit;
}
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM jadwal WHERE id=$id");
    header("Location: kelola_jadwal.php");
    exit;
}
$jadwal = mysqli_query($conn, "SELECT * FROM jadwal ORDER BY FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')");
?>
<!DOCTYPE html>
<html>
<head><title>Kelola Jadwal</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container mt-4">
    <h2>Kelola Jadwal Operasional</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Kembali</a>
    <div class="card mb-4">
        <div class="card-header">Tambah Jadwal</div>
        <div class="card-body">
            <form method="POST">
                <div class="row">
                    <div class="col"><input type="text" name="hari" class="form-control" placeholder="Hari" required></div>
                    <div class="col"><input type="time" name="jam_buka" class="form-control" required></div>
                    <div class="col"><input type="time" name="jam_tutup" class="form-control" required></div>
                    <div class="col"><input type="text" name="keterangan" class="form-control" placeholder="Keterangan"></div>
                    <div class="col"><button type="submit" class="btn btn-primary">Simpan</button></div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered">
        <thead><tr><th>Hari</th><th>Jam Buka</th><th>Jam Tutup</th><th>Keterangan</th><th>Aksi</th></tr></thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($jadwal)): ?>
            <tr>
                <td><?= $row['hari'] ?></td>
                <td><?= $row['jam_buka'] ?></td>
                <td><?= $row['jam_tutup'] ?></td>
                <td><?= htmlspecialchars($row['keterangan']) ?></td>
                <td><a href="?hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>