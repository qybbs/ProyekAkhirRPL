<?php
    session_start();
    include "koneksi.php";

    if (isset($_GET['produk'])) {
      $_SESSION['produk'] = $_GET['produk'];
    }
    $id = $_SESSION['produk'];

    $produk = $produk = mysqli_query($konek, "select * from produk where id='$id'");
    $dataproduk = mysqli_fetch_array($produk);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $dataproduk['nama']; ?></title>
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
  <div class="container my-4">
    <div class="row">
      <?php
          if (isset($_GET['pesan'])) {
            if ($_GET['pesan'] == "nol") { ?>
              <div class="alert alert-danger" role="alert">
                Jumlah Produk minimal adalah 1!
              </div>  
            <?php } else if ($_GET['pesan'] == "berhasil") { ?>
                <div class="alert alert-success" role="alert">
                Tambah ke Keranjang berhasil!
              </div>
            <?php } else if ($_GET['pesan'] == "gagal") { ?>
              <div class="alert alert-danger" role="alert">
                Tambah ke Keranjang gagal!
              </div>
            <?php }
          }
        ?>
      <div class="col-6">
        <img src="assets/produk/<?php echo $dataproduk['gambar']; ?>" alt="gambar" width="100%">
      </div>
      <div class="col-6">
        <h3><?php echo $dataproduk['nama']; ?></h3>
        <h4>Rp<?php echo $dataproduk['harga']; ?></h4>
        <a href="#" class="text-dark text-decoration-none">Rating : <?php echo $dataproduk['rating']; ?></a>
        <p><?php echo $dataproduk['deskripsi']; ?></p>
        <form method="POST" action="input_cart.php">
          <label for="input" class="form-label my-2 col-form-label-sm">Kuantitas</label>
          <div class="input-group input-group-sm mb-3" style="width: 90px;">
            <input type="number" name="kuantitas" class="form-control border-secondary" placeholder="" value="0" aria-label="Example text with button addon" aria-describedby="button-addon1">
          </div>
          <input type="hidden" name="id" value="<?php echo $dataproduk['id']; ?>">
          <input type="submit" name="masuk" data-bs-toggle="modal" data-bs-target="#exampleModal" value="Masukkan Keranjang" class="btn btn-sm btn-dark">
        </form>
        <div class="container my-4" style="background-color: rgb(252, 242, 228);padding: 20px;">
        <h3 class="mb-3">Ulasan Produk</h3>
        <?php
          $ulasan = mysqli_query($konek, "select * from ulasan where id_produk='$id'");
          if (mysqli_num_rows($ulasan) > 0) {
            while ($dataulasan = mysqli_fetch_array($ulasan)) { ?>
              <p class="mb-2"><?php echo $dataulasan['ulasan']; ?><br>Rating : <?php echo $dataulasan['rating']; ?></p>
            <?php }
          }
        ?>
      </div>
      </div>
    </div>
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