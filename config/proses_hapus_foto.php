<?php
session_start();
include 'koneksi.php';

// Cek apakah admin yang mengakses
if ($_SESSION['role'] != 'admin') {
  echo "<script>
        alert('Hanya admin yang bisa menghapus foto');
        location.href='../user/foto.php'; // Ganti dengan halaman yang sesuai
        </script>";
  exit();
}

// Pastikan ada fotoid yang dikirimkan
if (isset($_GET['fotoid'])) {
    $fotoid = $_GET['fotoid'];

    // Ambil data foto berdasarkan fotoid
    $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE fotoid='$fotoid'");
    $data = mysqli_fetch_array($query);

    if ($data) {
        // Hapus foto dari direktori
        $filePath = '../assets/img/' . $data['lokasifile'];
        if (is_file($filePath)) {
            unlink($filePath); // Menghapus foto dari direktori
        }

        // Hapus foto dari database
        $hapus = mysqli_query($koneksi, "DELETE FROM foto WHERE fotoid='$fotoid'");

        if ($hapus) {
            echo "<script>
                alert('Foto berhasil dihapus!');
                location.href='../admin/index.php'; // Ganti dengan halaman yang sesuai
            </script>";
        } else {
            echo "<script>
                alert('Gagal menghapus foto');
                location.href='../admin/index.php'; // Ganti dengan halaman yang sesuai
            </script>";
        }
    } else {
        echo "<script>
            alert('Foto tidak ditemukan');
            location.href='../user/foto.php'; // Ganti dengan halaman yang sesuai
        </script>";
    }
} else {
    echo "<script>
        alert('ID foto tidak ditemukan');
        location.href='../user/foto.php'; // Ganti dengan halaman yang sesuai
    </script>";
}
?>
