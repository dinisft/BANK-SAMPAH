<?php
require_once 'config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id_setoran = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_setoran <= 0) {
    header("Location: riwayat.php?error=ID tidak valid");
    exit;
}

// Cek apakah setoran milik user ini dan statusnya masih pending
$query = "SELECT foto, status FROM setoran WHERE id = $id_setoran AND user_id = $user_id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: riwayat.php?error=Data tidak ditemukan");
    exit;
}

if ($row['status'] != 'pending') {
    header("Location: riwayat.php?error=Hanya bisa menghapus setoran yang masih diproses");
    exit;
}

// Hapus file foto jika ada
if (!empty($row['foto']) && file_exists("uploads/" . $row['foto'])) {
    unlink("uploads/" . $row['foto']);
}

// Hapus data dari database
$delete = mysqli_query($conn, "DELETE FROM setoran WHERE id = $id_setoran AND user_id = $user_id");

if ($delete) {
    header("Location: riwayat.php?success=Setoran berhasil dihapus");
} else {
    header("Location: riwayat.php?error=Gagal menghapus: " . mysqli_error($conn));
}
exit;
?>