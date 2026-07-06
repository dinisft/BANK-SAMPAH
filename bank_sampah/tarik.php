<?php
$title = "Tarik Poin";
require_once 'config/database.php';
include 'includes/header.php';

$user_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT poin FROM users WHERE id=$user_id"));
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jumlah_poin = (int)$_POST['jumlah'];
    $metode = $_POST['metode'];
    $detail = $_POST['detail'] ?? '';
    
    if ($jumlah_poin > $user['poin']) {
        $message = "<div class='alert alert-danger'>Poin tidak mencukupi.</div>";
    } else {
        $query = "INSERT INTO penarikan (user_id, jumlah_poin, metode, detail) VALUES ('$user_id', '$jumlah_poin', '$metode', '$detail')";
        if (mysqli_query($conn, $query)) {
            // Kurangi poin user
            $new_poin = $user['poin'] - $jumlah_poin;
            mysqli_query($conn, "UPDATE users SET poin=$new_poin WHERE id=$user_id");
            $message = "<div class='alert alert-success'>Pengajuan penarikan berhasil! Menunggu proses admin.</div>";
            $user['poin'] = $new_poin; // refresh
        } else {
            $message = "<div class='alert alert-danger'>Gagal mengajukan.</div>";
        }
    }
}
?>
<h2>💰 Tarik / Tukar Poin</h2>
<div class="alert alert-info">Poin Anda saat ini: <strong><?= $user['poin'] ?></strong></div>
<?= $message ?>
<form method="POST" class="card p-4">
    <div class="mb-3">
        <label>Jumlah Poin yang akan ditarik</label>
        <input type="number" name="jumlah" class="form-control" min="1" max="<?= $user['poin'] ?>" required>
    </div>
    <div class="mb-3">
        <label>Metode</label>
        <select name="metode" id="metode" class="form-select" required>
            <option value="tunai">Tarik Tunai (datang ke kantor)</option>
            <option value="hadiah">Tukar Hadiah</option>
        </select>
    </div>
    <div class="mb-3" id="detailField">
        <label>Detail (no. HP atau nama hadiah)</label>
        <input type="text" name="detail" class="form-control" placeholder="Contoh: 08123456789 atau Sabun cuci">
    </div>
    <button type="submit" class="btn btn-success">Ajukan Penarikan</button>
</form>
<?php include 'includes/footer.php'; ?>