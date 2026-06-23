<?php
$title = "Setor Sampah";
require_once 'config/database.php';
include 'includes/header.php';

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Buat folder uploads jika belum ada
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jenis = mysqli_real_escape_string($conn, $_POST['jenis']);
    $berat = floatval($_POST['berat']);
    
    // Validasi berat
    if ($berat <= 0) {
        $error = "Berat harus lebih dari 0 kg.";
    } else {
        // Proses upload foto (opsional)
        $foto_name = NULL;
        $upload_ok = true;
        
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] != UPLOAD_ERR_NO_FILE) {
            $file_tmp = $_FILES['foto']['tmp_name'];
            $file_size = $_FILES['foto']['size'];
            $file_ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
                $error = "Terjadi error saat upload file (kode: " . $_FILES['foto']['error'] . ")";
                $upload_ok = false;
            } elseif (!in_array($file_ext, $allowed_ext)) {
                $error = "Hanya file JPG, JPEG, PNG, GIF, WEBP yang diperbolehkan.";
                $upload_ok = false;
            } elseif ($file_size > 2 * 1024 * 1024) { // maks 2MB
                $error = "Ukuran foto maksimal 2 MB.";
                $upload_ok = false;
            }
            
            if ($upload_ok) {
                $foto_name = time() . "_" . uniqid() . "." . $file_ext;
                if (!move_uploaded_file($file_tmp, $target_dir . $foto_name)) {
                    $error = "Gagal menyimpan foto, coba lagi.";
                    $foto_name = NULL;
                }
            }
        }
        
        // Jika tidak ada error, simpan ke database
        if (empty($error)) {
            // Gunakan prepared statement
            $stmt = mysqli_prepare($conn, "INSERT INTO setoran (user_id, jenis_sampah, berat_kg, foto) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "isds", $user_id, $jenis, $berat, $foto_name);
            
            if (mysqli_stmt_execute($stmt)) {
                $message = "<div class='alert alert-success'>✅ Pengajuan setor berhasil! Menunggu konfirmasi petugas.</div>";
            } else {
                $error = "Gagal menyimpan data: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<h2>📦 Form Setor Sampah</h2>

<?php if (!empty($message)) echo $message; ?>
<?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="POST" enctype="multipart/form-data" class="card p-4">
    <div class="mb-3">
        <label class="form-label">Jenis Sampah</label>
        <select name="jenis" class="form-select" required>
            <option value="plastik">Plastik</option>
            <option value="kertas">Kertas</option>
            <option value="kaca">Kaca</option>
            <option value="kaleng">Kaleng</option>
            <option value="organik">Organik</option>
        </select>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Berat (kg)</label>
        <input type="number" step="0.1" name="berat" class="form-control" required min="0.1">
        <small class="text-muted">Contoh: 1.5</small>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Foto Sampah (Opsional)</label>
        <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
        <small class="text-muted">Maksimal 2MB, format JPG, PNG, GIF, WEBP</small>
    </div>
    
    <button type="submit" class="btn btn-success">Kirim Pengajuan</button>
</form>

<?php include 'includes/footer.php'; ?>