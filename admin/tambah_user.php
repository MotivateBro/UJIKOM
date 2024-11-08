<?php
session_start();
include '../config/koneksi.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login' || $_SESSION['role'] != 'admin') {
    echo "<script>
        alert('Akses ditolak!');
        location.href='../login.php';
        </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
</head>

<body class="bg-white text-dark">
    <div class="container mt-5">
        <h1 class="text-center">Tambah User Baru</h1>
        <form action="../config/aksi_tambah_user.php" method="POST" class="mt-3">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="namalengkap" class="form-label">Nama Lengkap</label>
                <input type="text" name="namalengkap" class="form-control" id="namalengkap" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control" id="alamat" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" class="form-control" id="role" required>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Tambah Pengguna</button>
            <a href="user_management.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="../assets/js/bootstrap.min.js"></script>
</body>

</html>