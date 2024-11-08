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

// Ambil data user berdasarkan userid
if (isset($_GET['userid'])) {
    $userid = $_GET['userid'];
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE userid = '$userid'");
    $user = mysqli_fetch_array($query);

    if (!$user) {
        echo "<script>
            alert('User tidak ditemukan!');
            location.href='user_management.php';
            </script>";
        exit();
    }
}

// Proses update data user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $updateQuery = "UPDATE user SET username='$username', alamat='$alamat', email='$email', role='$role' WHERE userid='$userid'";
    if (mysqli_query($koneksi, $updateQuery)) {
        echo "<script>
            alert('User berhasil diperbarui!');
            location.href='user_management.php';
            </script>";
    } else {
        echo "<script>
            alert('Gagal memperbarui user!');
            location.href='edit_user.php?userid=$userid';
            </script>";
    }
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
            background: linear-gradient(to bottom, rgb(190, 49, 68), rgb(9, 16, 87));
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

    

    <header>
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Welcome To User Management, <?php echo $_SESSION['username']?>?</h1>
                <p class="lead fw-normal text-white-50 mb-0">This is the edit area, <?php echo $_SESSION['username']?></p>
            </div>
        </div>
    </header>

    <body class="bg-light text-dark">
        <div class="container mt-5">
            <h2 class="text-center">Would you like to edit, <?php echo $_SESSION['username']?>?</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $user['alamat']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                        <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="user_management.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>

        <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
        <p>&copy; UJIKOM PPLG 2024 | BIMMO LEXI RAMADHAN</p>
    </footer>

        <!-- Include Bootstrap JS -->
        <script src="../assets/js/bootstrap.min.js"></script>
    </body>

</html>