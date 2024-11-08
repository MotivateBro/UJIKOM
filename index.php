<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Foto</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <style>
        /* Menambahkan gambar latar belakang dengan efek fade */
        body {
            background-image: url('assets/img/fade.gif');
            /* Path menuju file GIF */
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: #fff;
            /* Ubah warna teks agar kontras dengan background */
        }


        header {
            background-image: url('assets/img/fade-valorant.gif');
            /* Path menuju file GIF */
            background-size: cover;
            background-position: center center;
            position: relative;
            height: 400px;
            margin-top: -2px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Atur transparansi gradient agar GIF terlihat */
        header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0));
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

        footer {
            background-image: url('assets/bg-img/footer-bg.jpg');
            /* Sesuaikan path gambar */
            background-size: cover;
            background-position: center;
            color: #000;
            /* Warna teks kontras */
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Gallery</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4"> </ul>
                <!-- Tombol Daftar -->
                <div class="d-flex">
                    <a href="register.php" class="btn btn-outline-light me-2">Register</a>
                    <a href="login.php" class="btn btn-outline-light">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header dengan background gambar dan efek fade-->
    <header>
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-black ">
                <h1 class="display-4 fw-bolder">Welcome</h1>
                <p class="lead fw-normal text-bla-50 mb-0">Random Album And Photo With High Standard Picture</p>
            </div>
        </div>
    </header>

    <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
        <p>&copy; UJIKOM PPLG 2024 | BIMMO LEXI RAMADHAN</p>
    </footer>

    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>

</html>