<?php
session_start();
include 'koneksi.php';

// Mendapatkan data dari form
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password
$email = $_POST['email'];
$namalengkap = $_POST['namalengkap'];
$role = $_POST['role'];

// Query untuk menambahkan pengguna baru
$query = "INSERT INTO user (username, password, email, namalengkap, role) VALUES ('$username', '$password', '$email', '$namalengkap', '$role')";

if (mysqli_query($koneksi, $query)) {
    echo "<script>
        alert('Pengguna berhasil ditambahkan!');
        location.href='../admin/user_management.php';
        </script>";
} else {
    echo "<script>
        alert('Gagal menambahkan pengguna!');
        location.href='../admin/user_management.php';
        </script>";
}

mysqli_close($koneksi);
?>
