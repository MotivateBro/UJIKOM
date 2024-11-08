<?php
session_start();
include '../config/koneksi.php';

// Cek apakah user sudah login dan memiliki role admin
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
    <title>Gallery Foto</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <style>
        /* CSS styling */
        header {
            background-size: cover;
            background-position: center center;
            position: relative;
            height: 400px;
            margin-top: -2px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgb(9, 16, 87), rgb(70, 17, 17));
            z-index: 1;
        }

        header .container {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .navbar {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
    </style>
</head>

<body class="bg-white text-dark">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Gallery</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">My Album</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Add some here</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="album.php">Add Album</a></li>
                            <li><a class="dropdown-item" href="foto.php">Add Photo</a></li>
                            <li><a class="dropdown-item" href="user_management.php">Check User</a></li>
                        </ul>
                    </li>
                </ul>
                <a href="../config/aksi_logout.php" class="btn btn-outline-danger">Keluar</a>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header>
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Welcome To User Management, <?php echo $_SESSION['username']?></h1>
                <p class="lead fw-normal text-white-50 mb-0">Would you like to edit or delete user, <?php echo $_SESSION['username']?>?</p>
            </div>
        </div>
    </header>

    <!-- User Management Section -->
    <div class="container mt-5">
        <h1 class="text-center">Manage Users</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama lengkap</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Role</th>
                    <th>Action</th>
                    <a href="tambah_user.php" class="btn btn-primary btn-sm">Tambah user</a>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($koneksi, "SELECT * FROM user");
                $no = 1;
                while ($user = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['namalengkap']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['alamat']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <?php if ($user['userid'] != $_SESSION['userid']) { ?>
                                <a href="../config/proses_hapus_user.php?userid=<?php echo $user['userid']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">Delete</a>
                                <a href="edit_user.php?userid=<?php echo $user['userid']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>


    <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
        <p>&copy; UJIKOM PPLG 2024 | BIMMO LEXI RAMADHAN</p>
    </footer>
    
    <!-- Include Bootstrap JS -->
    <script src="../assets/js/bootstrap.min.js"></script>
</body>

</html>
