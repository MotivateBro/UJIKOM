<?php
session_start();
$userid = $_SESSION['userid'];
include '../config/koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
  echo "<script>
        alert('Anda belum login');
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
      background: linear-gradient(to bottom, rgb(0, 0, 0), rgba(104, 109, 118));
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

    #sidebar {
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1040;
      overflow-y: auto;
      transition: transform 0.3s ease;
      display: block;
    }

    #sidebar.show {
      transform: translateX(0);
    }

    @media (max-width: 992px) {
      #sidebar {
        transform: translateX(-250px);
      }

      #sidebar.show {
        transform: translateX(0);
      }
    }
  </style>
</head>

<body class="sb-nav-fixed text-dark bg-secondary">

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
          </li>
        </ul>
        <a href="../config/aksi_logout.php" class="btn btn-outline-danger">Keluar</a>
      </div>
    </div>
  </nav>

  <header>
    <div class="container px-4 px-lg-5 my-5">
      <div class="text-center text-white">
        <h1 class="display-4 fw-bolder">Welcome, <?php echo $_SESSION['username'] ?></h1>
        <p class="lead fw-normal text-white-50 mb-0">What would you like to do today <?php echo $_SESSION['username'] ?>?</p>
      </div>
    </div>
  </header>

  <div class="container mt-2">
    <div class="row">
      <?php
      $query = mysqli_query($koneksi, "SELECT * FROM foto 
                                       INNER JOIN user ON foto.userid=user.userid 
                                       INNER JOIN album ON foto.albumid=album.albumid");
      while ($data = mysqli_fetch_array($query)) {
        $fotoid = $data['fotoid'];
        $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
        $likeCount = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'"));
      ?>
        <div class="col-md-3 mt-2">
          <a type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid'] ?>">
            <div class="card mb-2">
              <img style="height: 12rem;" src="../assets/img/<?php echo $data['lokasifile'] ?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>">
              <div class="card-footer text-center">
                <a href="../config/proses_like.php?fotoid=<?php echo $fotoid ?>" type="submit" name="<?php echo (mysqli_num_rows($ceksuka) == 1) ? 'batalsuka' : 'suka'; ?>">
                  <i class="<?php echo (mysqli_num_rows($ceksuka) == 1) ? 'fa fa-heart' : 'fa-regular fa-heart'; ?>"></i>
                </a>
                <?php echo $likeCount . ' Suka'; ?>
                <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid'] ?>"><i class="fa-regular fa-comment"></i></a>
                <?php
                $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
                echo mysqli_num_rows($jmlkomen) . ' Komentar';
                ?>

                <?php if ($_SESSION['role'] == 'admin') { ?>
                  <a href="../config/proses_hapus_foto.php?fotoid=<?php echo $fotoid; ?>" class="text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                    <i class="fa fa-trash"></i>
                  </a>
                <?php } ?>
              </div>
            </div>
          </a>

          <div class="modal fade" id="komentar<?php echo $data['fotoid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-8">
                      <img src="../assets/img/<?php echo $data['lokasifile'] ?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>">
                    </div>
                    <div class="col-md-4">
                      <div class="m-2">
                        <div class="sticky-top">
                          <strong><?php echo $data['judulfoto'] ?></strong><br>
                          <span class="badge bg-secondary"><?php echo $data['namalengkap'] ?></span>
                          <span class="badge bg-secondary"><?php echo $data['tanggalunggah'] ?></span>
                          <span class="badge bg-primary"><?php echo $data['namaalbum'] ?></span>
                        </div>
                        <hr>
                        <p align="left">
                          <?php echo $data['deskripsifoto'] ?>
                          <hr>
                          <?php
                          $komentar = mysqli_query($koneksi, "SELECT * FROM komentarfoto 
                                     INNER JOIN user ON komentarfoto.userid=user.userid 
                                     WHERE komentarfoto.fotoid='$fotoid'");
                          while ($row = mysqli_fetch_array($komentar)) {
                          ?>
                        <p align="left">
                          <strong><?php echo $row['namalengkap'] ?></strong>
                          <?php echo $row['isikomentar'] ?>
                          <?php if ($_SESSION['role'] == 'admin') { ?>
                            <a href="../config/proses_hapus_komentar.php?komentarid=<?php echo $row['komentarid']; ?>&fotoid=<?php echo $fotoid; ?>" class="text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                              <i class="fa fa-trash"></i>
                            </a>
                          <?php } ?>
                        </p>
                      <?php } ?>

                      <hr>
                      <div class="sticky-bottom">
                        <form action="../config/proses.komentar.php" method="POST">
                          <div class="input-group">
                            <input type="hidden" name="fotoid" value="<?php echo $data['fotoid'] ?>">
                            <input type="text" name="isikomentar" class="form-control" placeholder="Tambahkan Komentar">
                            <div class="input-group-prepend">
                              <button type="submit" name="kirimkomentar" class="btn btn-outline-primary">Kirim</button>
                            </div>
                          </div>
                        </form>
                      </div>
                      </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>


  <!-- Footer -->
  <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
    <p>&copy; UJIKOM PPLG 2024 | BIMMO LEXI RAMADHAN</p>
  </footer>

  <!-- Include Bootstrap JS -->
  <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>

</body>

</html>