<?php
  session_start();
  if (empty($_SESSION['username'])) {
    header("location:login.php");
  }

  include "koneksi.php";
  $id_user = $_SESSION['id'];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout History</title>
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
  <div class="container">
    <div class="row">
        <div class="col-3">
            <div class="container d-flex flex-column">
            <span class="badge my-3 d-flex align-items-center p-1 pe-2 text-dark">
                  <img class="rounded-circle me-1" width="36" height="36" alt="" style="margin-right: 10px;background-image:url(assets/user/<?php echo $_SESSION['username']; ?>.JPG);background-size:cover;"><?php echo $_SESSION['username']; ?>
              </span>
                <a href="#" class="text-decoration-none text-dark">Alamat</a>
                <a href="#" class="text-decoration-none text-dark">Ubah Password</a>
                <a href="#" class="text-decoration-none text-dark" style="font-weight: bold;">Pesanan Saya</a>
            </div>
        </div>
        <div class="col-9">
            <div class="container m-3">
            <center><h4 class="mb-2">Riwayat Pesanan</h4></center>
              <?php
                $checkout = mysqli_query($konek, "select * from checkout where id_user='$id_user'");
                if (mysqli_num_rows($checkout) > 0) {
                  while ($datacheckout = mysqli_fetch_array($checkout)) { ?>
                    <div class="container mb-2" style="background-color: rgb(252, 242, 228);">
                      <table class="table">
                          <tbody>
                              <tr>
                                  <td colspan="2">Kode Pesanan : <strong><?php echo $datacheckout['kode']; ?></strong></td>
                              </tr>
                              <?php
                                $kode = $datacheckout['kode'];
                                $cart = mysqli_query($konek, "select c.*, p.gambar, p.harga, p.nama from cart c, produk p  where id_user='$id_user' and c.id_produk=p.id and c.kode_checkout='$kode'");
                                while ($datacart = mysqli_fetch_array($cart)) { ?>
                                  <tr>
                                  <td>
                                      <div class="row p-3"> 
                                      <div class="col-auto d-none d-lg-block mb-3">
                                        <svg class="bd-placeholder-img" width="300px" height="200px" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false" style="background-image: url(assets/produk/<?php echo $datacart['gambar']; ?>);background-size:cover"></svg>
                                      </div>                 
                                          <div class="col-auto flex-column">
                                            <h3 class="mb-0"><?php echo $datacart['nama']; ?></h3>
                                            <div class="text-body-secondary">x<?php echo $datacart['kuantitas']; ?></div>
                                          </div>
                                        </div>
                                  </td>
                                  <td class="align-middle">
                                      <h5>Rp<?php echo ($datacart['harga']*$datacart['kuantitas']); ?></h5>
                                  </td>
                              </tr>
                                <?php }
                              ?>
                              <tr>
                                  <td>
                                      <div class="container position-relative">
                                          <div class="position-absolute end-0">
                                              Total Pesanan :
                                          </div>
                                      </div>
                                  </td>
                                  <td>
                                      <h4>Rp<?php echo $datacheckout['total_pesanan']; ?></h4>
                                  </td>
                              </tr>
                          </tbody>
                        </table>
                    </div>
                  <?php }
                } else { ?>
                  <center>Belum ada pesanan!</center>
                <?php }
              ?>                    
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