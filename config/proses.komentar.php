<?php
session_start();
include 'koneksi.php';

$fotoid = $_POST['fotoid'];
$userid = $_SESSION['userid'];
$isikomentar = $_POST['isikomentar'];
$tanggalkomentar = date('y-m-d');

// Insert data komentar ke dalam database
$query = mysqli_query($koneksi, "INSERT INTO komentarfoto VALUES('', '$fotoid', '$userid', '$isikomentar', '$tanggalkomentar')");

// Mengecek peran pengguna
if ($_SESSION['role'] == 'admin') {
    // Jika admin, arahkan ke halaman index admin
    header("Location: ../admin/index.php");
} else {
    // Jika user, arahkan ke halaman index user
    header("Location: ../user/index.php");
}
exit();
?>
