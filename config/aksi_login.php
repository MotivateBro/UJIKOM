<?php
session_start();
include 'koneksi.php';

// Ambil data dari form login
$username = $_POST['username'];
$password = md5($_POST['password']);

// Cek apakah username dan password ada di database
$sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");

$cek = mysqli_num_rows($sql);

if ($cek > 0) {
    // Jika username dan password cocok
    $data = mysqli_fetch_array($sql);
    $_SESSION['username'] = $data['username'];
    $_SESSION['userid'] = $data['userid'];
    $_SESSION['role'] = $data['role'];
    $_SESSION['status'] = 'login';

    // Cek role pengguna dan arahkan sesuai role
    if ($data['role'] == 'admin') {
        echo "<script>
        alert('Login Sukses, Welcome Admin " . $_SESSION['username'] . "!');
        location.href='../admin/index.php';
        </script>";
    } elseif ($data['role'] == 'user') {
        echo "<script>
        alert('Login Sukses, Welcome User " . $_SESSION['username'] . "!');
        location.href='../user/index.php';
        </script>";
    } else {
        echo "<script>
        alert('Login Sukses, Welcome " . $_SESSION['username'] . "!');
        location.href='../index.php';
        </script>";
    }
} else {
    // Jika login gagal
    echo "<script>
    alert('Username atau Password anda salah!');
    location.href='../login.php';
    </script>";
}
