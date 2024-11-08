<?php
session_start();
include '../config/koneksi.php';

$userid = $_SESSION['userid'];
if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum login');
    location.href='../index.php';
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
        /* Menambahkan gambar latar belakang dengan efek fade */
        header {
            background-size: cover;
            background-position: center center;
            position: relative;
            height: 400px;
            /* Anda bisa menyesuaikan tinggi header sesuai kebutuhan */
            margin-top: -2px;
            /* Menghilangkan jarak antara navbar dan header */
            display: flex;
            align-items: center;
            /* Memusatkan secara vertikal */
            justify-content: center;
            /* Memusatkan secara horizontal */
        }

        /* Efek fade menggunakan gradient */
        header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgb(0, 0, 0), rgb(135, 35, 65));
            /* Efek fade */
            z-index: 1;
        }

        /* Menambahkan teks agar berada di atas gambar latar */
        header .container {
            position: relative;
            z-index: 2;
            text-align: center;
            /* Memastikan teks terletak di tengah */
        }

        /* Mengurangi padding navbar agar lebih rapat */
        .navbar {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        /* Menambahkan padding untuk tombol album */
        .album-btns {
            margin-top: 20px;
            margin-bottom: 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .album-btns a {
            margin: 5px;
        }

        /* Style untuk card foto */
        .card-img-top {
            height: 12rem;
            object-fit: cover;
        }

        /* Footer lebih terstruktur dan lebih nyaman di bawah */
        footer {
            padding: 10px;
            text-align: center;
            background-color: #f8f9fa;
            margin-top: 30px;
        }
    </style>
</head>

<body class="sb-nav-fixed text-dark">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Gallery</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">My Album</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Add some here</a>
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
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder"><?php echo $_SESSION['username']?>'s Album</h1>
                <p class="lead fw-normal text-white-50 mb-0">See them albums</p>
            </div>
        </div>
    </header>

    <div class="container mt-3">

        <!-- Album Buttons -->
        <div class="album-btns">
            <strong>Album:</strong>
            <?php
            $album = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid'");
            while ($row = mysqli_fetch_array($album)) {
                echo '<a href="home.php?albumid=' . $row['albumid'] . '" class="btn btn-outline-primary">' . $row['namaalbum'] . '</a>';
            }
            ?>
        </div>

        <!-- Photos -->
        <div class="row">
            <?php
            if (isset($_GET['albumid'])) {
                $albumid = $_GET['albumid'];
                $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid' AND albumid='$albumid'");
                while ($data = mysqli_fetch_array($query)) {
                    $fotoid = $data['fotoid'];
            ?>
                    <div class="col-md-3 mt-2">
                        <div class="card">
                            <img class="card-img-top" src="../assets/img/<?php echo $data['lokasifile']; ?>" title="<?php echo $data['judulfoto']; ?>">
                            <div class="card-footer text-center">
                                <?php
                                $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                                if (mysqli_num_rows($ceksuka) == 1) {
                                    echo '<a href="../config/proses_like.php?fotoid=' . $fotoid . '"><i class="fa fa-heart"></i></a>';
                                } else {
                                    echo '<a href="../config/proses_like.php?fotoid=' . $fotoid . '"><i class="fa-regular fa-heart"></i></a>';
                                }
                                $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                                echo mysqli_num_rows($like) . ' Suka';
                                ?>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $fotoid; ?>"><i class="fa-regular fa-comment"></i></a>
                                <?php
                                $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
                                echo mysqli_num_rows($jmlkomen) . ' Komentar';
                                ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid'");
                while ($data = mysqli_fetch_array($query)) {
                    $fotoid = $data['fotoid'];
                ?>
                    <div class="col-md-3 mt-2">
                        <a data-bs-toggle="modal" data-bs-target="#komentar<?php echo $fotoid; ?>">
                            <div class="card mb-2">
                                <img class="card-img-top" src="../assets/img/<?php echo $data['lokasifile']; ?>" title="<?php echo $data['judulfoto']; ?>">
                                <div class="card-footer text-center">
                                    <?php
                                    $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                                    echo '<a href="../config/proses_like.php?fotoid=' . $fotoid . '">' .
                                        (mysqli_num_rows($ceksuka) == 1 ? '<i class="fa fa-heart"></i>' : '<i class="fa-regular fa-heart"></i>') .
                                        '</a>';
                                    ?>
                                    <?php
                                    $likeCount = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                                    echo mysqli_num_rows($likeCount) . ' Suka';
                                    ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $fotoid; ?>"><i class="fa-regular fa-comment"></i></a>
                                    <?php
                                    $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
                                    echo mysqli_num_rows($jmlkomen) . ' Komentar';
                                    ?>
                                </div>
                            </div>
                        </a>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
        <p>&copy; UJIKOM PPLG 2024 | BIMMO LEXI RAMADHAN</p>
    </footer>

    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>

</html>