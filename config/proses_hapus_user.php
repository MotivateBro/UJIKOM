<?php
session_start();
include 'koneksi.php';

// Cek apakah user adalah admin
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login' || $_SESSION['role'] != 'admin') {
  echo "<script>
        alert('Akses ditolak!');
        location.href='../login.php';
        </script>";
  exit();
}

// Ambil userid dari parameter URL
$userid = $_GET['userid'];

// Query untuk menghapus user
$query = "DELETE FROM user WHERE userid='$userid'";
if (mysqli_query($koneksi, $query)) {
  echo "<script>
        alert('Pengguna berhasil dihapus');
        location.href='../admin/user_management.php';
        </script>";
} else {
  echo "<script>
        alert('Gagal menghapus pengguna');
        location.href='../admin/user_management.php';
        </script>";
}
?>
