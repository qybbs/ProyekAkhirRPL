<?php
    session_start();
    include "koneksi.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
  <body>
    <header class="p-3" style="background-color: rgb(255, 204, 204);">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none" style="padding-right: 30px;">
          <img src="logo.png" alt="logo" height="32px">
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="index.php" class="nav-link px-2 text-white">Beranda</a></li>
          <li><a href="category.php" class="nav-link px-2 text-white">Kategori</a></li>
          <li><a href="cart.php" class="nav-link px-2 text-white">Keranjang</a></li>
        </ul>

        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>

        <div class="text-end">
          <?php
            if (empty($_SESSION['username'])) {?>
                <a href="login.php">
                  <button type="button" class="btn btn-outline-light me-2">Login</button>
                </a>
            <?php } else { ?>
              <div class="dropdown">
              <a class="text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="badge my-3 d-flex align-items-center p-1 pe-2 text-dark">
                  <img class="rounded-circle me-1" width="36" height="36" alt="" style="margin-right: 10px;background-image:url(assets/user/<?php echo $_SESSION['username']; ?>.JPG);background-size:cover;"><?php echo $_SESSION['username']; ?>
              </span>
              </a>

              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="pesanan.php">Pesanan Saya</a></li>
                <li><a class="dropdown-item" href="alamat.php">Alamat Saya</a></li>
                <li><a class="dropdown-item" href="password.php">Ubah Password</a></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
              </ul>
            </div>
            <?php } ?>
        </div>
      </div>
    </div>
  </header>
  <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center text-light" style="background-image: url(assets/homeposter.JPG); background-size: cover;">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
      <h1 class="display-4 fw-normal text-bg-light">Syafal by syaffal</h1>
      <p class="lead fw-normal text-bg-light">And an even wittier subheading to boot. Jumpstart your marketing efforts with this example based on Apple’s marketing pages.</p>
    </div>
    <div class="product-device shadow-sm d-none d-md-block"></div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
  </div>
  <div class="album py-5 bg-body-tertiary">
    <div class="container">
      <div style="margin-bottom: 30px;">
        <h1 class="display-4 fw-normal">Kategori</h1>
      </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
          <?php
            $kategori = mysqli_query($konek, "select * from kategori limit 4");
            while ($datakategori = mysqli_fetch_array($kategori)) { ?>
              <div class="col">
              <a class="text-decoration-none" href="produk.php?category=<?php echo $datakategori['id']; ?>">
              <div class="card shadow-sm">
                <svg class="bd-placeholder-img card-img-top" width="100%" height="225" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false" style="background-image: url(assets/kategori/<?php echo $datakategori['nama']; ?>.JPG);background-size:cover"></svg>
                <div class="card-body">
                  <p class="card-text"><?php echo $datakategori['nama']; ?></p>
                </div>
              </div>
              </a>
            </div>
            <?php } ?>  
        </div>
        <a href="category.php">
          <button class="btn btn-outline-dark" style="margin-top: 30px;">Tampilkan Semua</button>
        </a>
    </div>
  </div>
  <div class="album py-5 bg-body-tertiary">
    <div class="container">
      <div style="margin-bottom: 30px;">
        <h1 class="display-4 fw-normal">Produk</h1>
      </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
        <?php
            $produk = mysqli_query($konek, "select * from produk limit 4");
            while ($dataproduk = mysqli_fetch_array($produk)) { ?>
              <div class="col">
              <a class="text-decoration-none" href="detail-produk.php?produk=<?php echo $dataproduk['id']; ?>">
                  <div class="card shadow-sm">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false" style="background-image: url(assets/produk/<?php echo $dataproduk['gambar']; ?>);background-size:cover"></svg>
                    <div class="card-body">
                      <h5 class="card-title"><?php echo $dataproduk['nama']; ?></h5>
                      <p class="card-text"><?php echo $dataproduk['deskripsi']; ?></p>
                      <div class="d-flex justify-content-between align-items-center">
                        <h6>Rp<?php echo $dataproduk['harga']; ?></h6>
                        <small class="text-body-secondary">Rating : <?php echo $dataproduk['rating']; ?></small>
                      </div>
                    </div>
                  </div>
              </a>
            </div>
            <?php } ?>
        </div>
        <a href="produk.php?category=all">
          <button class="btn btn-outline-dark" style="margin-top: 30px;">Tampilkan Semua</button>
        </a>
    </div>
  </div>
  <div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
      <div class="col-md-4 d-flex align-items-center">
        <span class="mb-3 mb-md-0 text-body-secondary">&copy; 2023 Syafal Company, Inc</span>
      </div>
    </footer>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>