<?php
    include "koneksi.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
  <body>
    <div class="container-fluid" style="align-items: center;justify-content: center;height: 100vh;">
      <div class="container my-5" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width:500px;margin:auto;padding:30px;border-radius:20px;">
        <center>
          <main class="form-signin m-auto" style="width: 400px;">
          <?php
            if (isset($_GET['pesan'])) {
                if ($_GET['pesan'] == "beda") { ?>
                  <div class="alert alert-danger" role="alert">
                    Register Failed! Your passwords isn't same!
                    </div>  
               <?php } else if ($_GET['pesan'] == "ada") { ?>
                    <div class="alert alert-danger" role="alert">
                        Register Failed! Username is not available!
                    </div>
                <?php }
            }
        ?>
            <form method="POST" action="cek_register.php">
              <a href="index.php">
                <img class="mb-4" src="logo.png" alt="" width="72" height="57">
              </a>
              <h1 class="h3 mb-3 fw-normal">Please Register</h1>
          
              <div class="form-floating mb-2">
                <input name="username" type="text" class="form-control" id="floatingInput" placeholder="Username">
                <label for="floatingInput">Username</label>
              </div>
              <div class="form-floating mb-2">
                <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
              </div>
              <div class="form-floating mb-3">
                <input name="conpassword" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Confirm Password</label>
              </div>
              <button class="btn btn-primary py-2 mb-3" type="submit">Register</button><br>
            </form>
          </main>
          <div class="my-5">
            <span class="mb-md-0 text-body-secondary">&copy; 2023 Syafal Company, Inc</span>
          </div>
        </center>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>