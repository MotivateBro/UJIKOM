<?php
session_start();
include '../config/koneksi.php';
$userid = $_SESSION['userid'];
if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum login');
    location.href='../index.php';
    </script>";
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
            background: linear-gradient(to bottom, rgb(9, 16, 87), rgb(2, 76, 170));
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
            background-color: #0000;
            margin-top: 30px;
        }
    </style>
</head>

<body>

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
                <h1 class="display-4 fw-bolder">Photo</h1>
                <p class="lead fw-normal text-white-50 mb-0">Add them picture</p>
            </div>
        </div>
    </header>

    <!-- bagi 2 kolom -->
    <!-- kolom 1 -->
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card mt-2">
                    <div class="card-header">Add Foto</div>
                    <div class="card-body">
                        <form action="../config/aksi_foto.php" method="POST" enctype="multipart/form-data">
                            <label class="form-label">Name</label>
                            <input type="text" name="judulfoto" class="form-control" required>
                            <label class="form-label">Deskription</label>
                            <textarea class="form-control" name="deskripsifoto" required></textarea>
                            <label class="form-label">Album</label>
                            <select class="form-control" name="albumid" required>
                                <?php
                                $sql_album = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid'");
                                while ($data_album = mysqli_fetch_array($sql_album)) { ?>
                                    <option value="<?php echo $data_album['albumid'] ?>"><?php echo $data_album['namaalbum'] ?></option>
                                <?php } ?>
                            </select>
                            <label class="form-label mt-2">File</label>
                            <input type="file" class="form-conrtol" name="lokasifile" required>
                            <button type="submit" class="btn btn-primary" name="tambah">Add Data</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- kolom 2 -->
            <div class="col-md-8">
                <div class="card mt-2">
                    <div class="card-header">Data Galeri Foto</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal </th>
                                    <th>Foto</th>
                                    <th>Deskripsi</th>
                                    <th>Nama Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $userid = $_SESSION['userid'];
                                $sql = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid'");
                                while ($data = mysqli_fetch_array($sql)) {
                                ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $data['tanggalunggah'] ?></td>
                                        <td><?php echo $data['judulfoto'] ?></td>
                                        <td><?php echo $data['deskripsifoto'] ?></td>
                                        <td><img src="../assets/img/<?php echo $data['lokasifile'] ?>" width="100"></td>
                                        <td>
                                            <!-- edit button -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['fotoid'] ?>">
                                                Edit
                                            </button>
                                            <div class="modal fade" id="edit<?php echo $data['fotoid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="../config/aksi_foto.php" method="POST" enctype="multipart/form-data">
                                                                <input type="hidden" name="fotoid" value="<?php echo $data['fotoid'] ?>">
                                                                <label class="form-label">Judul Foto</label>
                                                                <input type="text" name="judulfoto" value="<?php echo $data['judulfoto'] ?>" class="form-control" required>
                                                                <label class="form-label">Deskripsi</label>
                                                                <textarea class="form-control" name="deskripsifoto" required><?php echo $data['deskripsifoto'] ?>
                                                                </textarea>
                                                                <select class="form-control" name="albumid">
                                                                    <?php
                                                                    $sql_album = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid'");
                                                                    while ($data_album = mysqli_fetch_array($sql_album)) { ?>
                                                                        <option <?php if ($data_album['albumid'] == $data['albumid']) { ?> selected="selected" <?php } ?>
                                                                            value="<?php echo $data_album['albumid'] ?>"><?php
                                                                                                                            echo $data_album['namaalbum'] ?></option>
                                                                    <?php } ?>

                                                                </select>
                                                                <label class="form-label">Foto</label>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <img src="../assets/img/<?php echo $data['lokasifile'] ?>" width="100">
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <label class="form-label">Ganti File</label>
                                                                        <input type="file" class="form-conrtol" name="lokasifile">

                                                                    </div>
                                                                </div>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="edit" class="btn btn-primary">Edit Data</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- delete button -->
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['fotoid'] ?>">
                                                Hapus
                                            </button>
                                            <div class="modal fade" id="hapus<?php echo $data['fotoid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="../config/aksi_foto.php" method="POST">
                                                                <input type="hidden" name="fotoid" value="<?php echo $data['fotoid'] ?>">
                                                                Apakah anda yakin ingin menghapus data <strong> <?php echo $data['judulfoto'] ?> </strong> ?

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="hapus" class="btn btn-primary">Hapus Data</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
        <p>&copy; UKK PPLG 2024 | BIMMO LEXI RAMADHAN</p>
    </footer>


    <footer class="d-flex justify-content-center"></footer>


    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>

</html>