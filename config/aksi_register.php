<?php
include 'koneksi.php';

if (isset($_POST['kirim'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $email = $_POST['email'];
    $namalengkap = $_POST['namalengkap'];
    $alamat = $_POST['alamat'];
    $role = $_POST['role'];

    // Cek apakah username sudah ada di database
    $checkQuery = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($koneksi, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // Username sudah ada, tampilkan pesan kesalahan
        echo "<script>
            alert('Username sudah terdaftar, silakan gunakan username lain.');
            location.href='../register.php';
            </script>";
    } else {
        // Username belum ada, lanjutkan proses penyimpanan data
        $sql = "INSERT INTO user (username, password, email, namalengkap, alamat, role) VALUES ('$username', '$password', '$email', '$namalengkap', '$alamat', '$role')";
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>
                alert('Registrasi berhasil!');
                location.href='../login.php';
                </script>";
        } else {
            echo "<script>
                alert('Registrasi gagal. Coba lagi.');
                location.href='../register.php';
                </script>";
        }
    }
}
?>
