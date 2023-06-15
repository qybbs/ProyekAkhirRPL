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
    <title>User Address</title>
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
                <a href="alamat.php" class="text-decoration-none text-dark" style="font-weight: bold;">Alamat</a>
                <a href="#" class="text-decoration-none text-dark">Ubah Password</a>
                <a href="#" class="text-decoration-none text-dark">Pesanan Saya</a>
            </div>
        </div>
        <div class="col-9">
            <div class="container m-3">
                <center><h4 class="mb-2">Alamat Saya</h4></center>
                <?php
                  if (isset($_GET['pesan'])) {
                    if ($_GET['pesan'] == "inputed") { ?>
                      <div class="alert alert-success" role="alert">
                        Alamat berhasil ditambahkan!
                      </div>
                    <?php } else if ($_GET['pesan'] == "updated") { ?>
                      <div class="alert alert-success" role="alert">
                        Alamat berhasil diubah!
                      </div>
                    <?php } else if ($_GET['pesan'] == "deleted") { ?>
                      <div class="alert alert-success" role="alert">
                        Alamat berhasil ditambahkan!
                      </div>
                    <?php } else if ($_GET['pesan'] == "gagal") { ?>
                      <div class="alert alert-danger" role="alert">
                        Proses gagal!
                      </div>
                    <?php }
                  }
                ?>
                <?php
                  $alamat = mysqli_query($konek, "select * from alamat where id_user='$id_user'");
                  if (mysqli_num_rows($alamat) > 0) { 
                    while ($dataalamat = mysqli_fetch_array($alamat)) {?>
                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#exampleModals<?php echo $dataalamat['id']; ?>">
                    <div class="container mb-1" style="background-color: rgb(252, 242, 228);">
                      <table class="table">
                          <tbody>
                              <tr>
                                  <td style="font-weight: bold;width: 175px;" class="align-middle">
                                      <?php echo $dataalamat['nama_penerima']; ?><br>
                                      <?php echo $dataalamat['no_hp']; ?>
                                  </td>
                                  <td class="align-middle d-none d-lg-block">
                                      <p><?php echo $dataalamat['alamat']; ?></p>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
                    </a>
                  <form action="update_alamat.php" method="post">
                  <div class="modal fade" id="exampleModals<?php echo $dataalamat['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Alamat</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="form-floating mb-3">
                            <input name="nama_penerima" type="text" value="<?php echo $dataalamat['nama_penerima']; ?>" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Nama Penerima</label>
                          </div>
                          <div class="form-floating mb-3">
                            <input name="kota" type="text" value="<?php echo $dataalamat['kota']; ?>" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Kota</label>
                          </div>
                          <div class="form-floating mb-3">
                            <input name="kecamatan" type="text" value="<?php echo $dataalamat['kecamatan']; ?>" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Kecamatan</label>
                          </div>
                          <div class="form-floating mb-3">
                            <input name="desa" type="text" value="<?php echo $dataalamat['desa']; ?>" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Desa</label>
                          </div>
                          <div class="form-floating mb-3">
                            <input name="no_hp" type="text" value="<?php echo $dataalamat['no_hp']; ?>" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Nomor HP</label>
                          </div>
                          <div class="form-floating">
                            <textarea name="alamat" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"><?php echo $dataalamat['alamat']; ?></textarea>
                            <label for="floatingTextarea2">Alamat</label>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Close</a>
                          <input type="submit" name="metode" value="Ubah" class="btn btn-outline-dark">
                          <input type="submit" name="metode" value="Hapus" class="btn btn-outline-dark">
                        </div>
                        <input type="hidden" name="id_alamat" value="<?php echo $dataalamat['id']; ?>">
                        </form>
                      </div>
                    </div>
                  </div>
                  <?php }
                  } else { ?>
                    <center>Belum ada alamat!</center>
                  <?php }
                ?>
                <center>
                  <button class="btn btn-outline-dark btn-sm my-2" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Tambah</button>
                </center>
                <form action="input_alamat.php" method="post">
                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Alamat</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label for="nama" class="form-label">Nama Penerima</label>
                            <input type="text" name="nama_penerima" class="form-control" id="nama" placeholder="">
                          </div>
                          <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor Handphone</label>
                            <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="0000-0000-0000">
                          </div>
                          <div class="mb-3">
                            <label for="kota" class="form-label">Kota</label>
                            <input type="text" name="kota" class="form-control" id="kota" placeholder="">
                          </div>
                          <div class="mb-3">
                            <label for="Kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" id="kecamatan" placeholder="">
                          </div>
                          <div class="mb-3">
                            <label for="desa" class="form-label">Desa</label>
                            <input type="text" name="desa" class="form-control" id="desa" placeholder="desa">
                          </div>
                          <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" id="alamat" cols="30" rows="10"></textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                          <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Close</a>
                          <input type="submit" value="Tambah Alamat" class="btn btn-outline-dark">
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
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