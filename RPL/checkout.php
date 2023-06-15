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
    <title>Checkout</title>
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
  <div class="container-fluid">
    <center>
        <h2 class="text-dark my-5">Checkout</h2>
    </center>
    <?php
      if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "gagal") { ?>
          <div class="alert alert-danger" role="alert">
            Proses checkout gagal!
          </div>
        <?php }
      }
    ?>
    <div class="container" style="background-color: rgb(252, 242, 228);">
    <form action="input_checkout.php" method="post">
        <table class="table">
            <thead>
                <th colspan="3">Alamat Pengiriman</th>
            </thead>
            <?php
              $alamat = mysqli_query($konek, "select * from alamat where id_user='$id_user'");
              if (mysqli_num_rows($alamat) < 1) { ?>
                <tbody>
                  <tr>
                      <td colspan="2">
                        <p>Belum ada alamat tersimpan</p>
                      </td>
                      <td style="width: 100px;" class="align-middle">
                          <a href="alamat.php">
                            <button class="btn btn-dark">Tambah</button>
                          </a>
                      </td>
                  </tr>
              </tbody>
              <?php } else { ?>
                <tbody>
                  <tr>
                      <td colspan="3">
                      <select name="alamat" class="form-select w-100" aria-label="Default select example">
                          <?php
                            while ($dataalamat = mysqli_fetch_array($alamat)) { ?>
                              <option value="<?php echo $dataalamat['id']; ?>"><?php echo $dataalamat['nama_penerima']; ?> | <?php echo $dataalamat['alamat']; ?></option>
                            <?php }
                          ?>
                            </select>
                      </td>
                  </tr>
              </tbody>
              <?php }
            ?>
        </table>
    </div>
    <div class="container">
      <?php
      $cart = mysqli_query($konek, "select c.*, p.gambar, p.harga, p.nama from cart c, produk p  where id_user='$id_user' and c.id_produk=p.id");
      $total = 0;
      ?>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Produk yang dipesan</th>
                <th scope="col">Harga Satuan</th>
                <th scope="col">Kuantitas</th>
                <th scope="col">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($datacart = mysqli_fetch_array($cart)) { ?>
                <tr>
                    <td>
                      <div class="row p-3 flex-column"> 
                          <div class="col-auto d-none d-lg-block mb-3">
                            <svg class="bd-placeholder-img" width="300px" height="200px" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false" style="background-image: url(assets/produk/<?php echo $datacart['gambar']; ?>);background-size:cover"></svg>
                          </div>                 
                          <div class="col-auto flex-column">
                            <h3 class="mb-0"><?php echo $datacart['nama']; ?></h3>
                          </div>
                        </div> 
                    </td>
                    <td class="align-middle">
                      <h5 class="mb-0">Rp<?php echo $datacart['harga']; ?></h5>
                    </td>
                    <td class="align-middle">
                      <h5><?php echo $datacart['kuantitas']; ?></h5>
                    </td>
                    <td class="align-middle">
                      <?php
                      $subtotal = ($datacart['harga']*$datacart['kuantitas']);
                      $total = $total+$subtotal;
                      ?>
                      <h5 class="mb-0">Rp<?php echo $subtotal; ?></h5>
                    </td>
                  </tr>
              <?php }
              ?>
            </tbody>
          </table>
    </div>
    <div class="container" style="background-color: rgb(252, 242, 228);">  
      <table class="table">
            <tbody>
                <tr>
                    <td rowspan="3">
                        <div class="row g-2 align-items-center">
                            <div class="col-auto">
                              <label for="inputPassword6" class="col-form-label" style="margin-right:20px;">Metode Pembayaran</label>
                            </div>
                            <select name="metode" class="form-select w-50" aria-label="Default select example">
                              <option selected value="Indomaret">Indomaret</option>
                              <option value="Alfamart">Alfamart</option>
                              <option value="Dana">Dana</option>
                              <option value="BRIVA">BRIVA</option>
                            </select>
                          </div> 
                    </td>
                    <td>
                        Total Semua Pesanan :
                    </td>
                    <td>
                        <h5>Rp<?php echo $total; ?></h5>
                        <input type="hidden" name="total" value="<?php echo $total; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Total Ongkir :
                    </td>
                    <?php
                      $ongkir = $total/10;
                    ?>
                    <td>
                        <h5>Rp<?php echo $ongkir; ?></h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        Total Pembayaran :
                    </td>
                    <td>
                      <?php
                      $bayar = $total+$ongkir;
                      ?>
                        <h4 style="font-weight: bold;">Rp<?php echo $bayar; ?></h4>
                        <input type="hidden" name="ongkir" value="<?php echo $ongkir; ?>">
                        <input type="hidden" name="bayar" value="<?php echo $bayar; ?>">
                    </td>
                </tr>
                <?php
                                            function createRandomPassword() { 

                                              $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
                                              srand((double)microtime()*1000000); 
                                              $i = 0; 
                                              $pass = '' ; 
                                          
                                              while ($i <= 7) { 
                                                  $num = rand() % 33; 
                                                  $tmp = substr($chars, $num, 1); 
                                                  $pass = $pass . $tmp; 
                                                  $i++; 
                                              } 
                                          
                                              return $pass; 
                                          
                                          } 
                                          ?>
                                            <?php
                                              $kode = createRandomPassword();
                                            ?>
                <tr>
                    <td colspan="2"></td>
                    <input type="hidden" name="kode" value="<?php echo $kode; ?>">
                    <td>
                        <a href="#" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">Buat Pesanan</a>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Pembayaran</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <center>
                                            <h4><?php echo $kode; ?></h4>
                                            <span>Silahkan bayar menggunakan kode pembayaran di atas!</span>
                                        </center>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                <input type="submit" value="OK" class="btn btn-dark" data-bs-dismiss="modal">
                                </div>
                            </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        </form>
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