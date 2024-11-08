<?php
session_start();
include 'koneksi.php';

// Pastikan pengguna sudah login
if ($_SESSION['status'] != 'login') {
    echo "<script>
          alert('Anda belum login');
          location.href='../login.php';
          </script>";
    exit();
}

// Ambil komentarid dan fotoid dari URL
$komentarid = $_GET['komentarid'];
$fotoid = $_GET['fotoid'];

// Hapus komentar dari database
$query = mysqli_query($koneksi, "DELETE FROM komentarfoto WHERE komentarid='$komentarid'");

// Redirect kembali ke halaman gallery foto
if ($query) {
    echo "<script>
          alert('Komentar berhasil dihapus');
          location.href='../admin/index.php?fotoid=$fotoid';
          </script>";
} else {
    echo "<script>
          alert('Komentar gagal dihapus');
          location.href='../admin/index.php?fotoid=$fotoid';
          </script>";
}
?>
