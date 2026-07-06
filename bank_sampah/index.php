<?php
require_once 'config/database.php';
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: dashboard.php");
    }
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = $_POST['password'];
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['nama'] = $row['nama'];
                $_SESSION['role'] = $row['role'];
                if ($row['role'] == 'admin') {
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit;
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Username tidak terdaftar.";
        }
    } elseif (isset($_POST['register'])) {
        $nama = trim($_POST['nama']);
        $username = trim($_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = 'nasabah'; // default nasabah

        $check = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username'");
        if ($check && mysqli_num_rows($check) > 0) {
            $error = "Username sudah digunakan.";
        } else {
            $query = "INSERT INTO users (nama, username, password, role) VALUES ('$nama', '$username', '$password', '$role')";
            if (mysqli_query($conn, $query)) {
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $error = "Gagal registrasi: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bank Sampah - Login & Daftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h3>🏦 Bank Sampah</h3>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#login">Login</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#register">Daftar</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="login">
                            <form method="POST">
                                <div class="mb-3"><label>Username</label><input type="text" name="username" class="form-control" required></div>
                                <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
                                <button type="submit" name="login" class="btn btn-success w-100">Login</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="register">
                            <form method="POST">
                                <div class="mb-3"><label>Nama Lengkap</label><input type="text" name="nama" class="form-control" required></div>
                                <div class="mb-3"><label>Username</label><input type="text" name="username" class="form-control" required></div>
                                <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
                                <button type="submit" name="register" class="btn btn-outline-success w-100">Daftar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>