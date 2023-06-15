<?php
    session_start();
    //menghubungkan dengan koneksi
    include "koneksi.php";

    //menangkap data yang dikirim dari form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conpassword = $_POST['conpassword'];

    if ($password == $conpassword) {
        $data = mysqli_query($konek, "select * from user where username='$username' and password='$password'") or die (mysqli_error($query));
        $cek = mysqli_num_rows($data);

        if ($cek == 0) {
            $input = mysqli_query($konek, "insert into user values('', '$username', '$password')") or die(mysqli_error($input));
            if ($input) {
                header("location:login.php?pesan=daftar");
            }
        } else {
            header("location:register.php?pesan=ada");
        }
    } else {
        header("location:register.php?pesan=beda");
    }
    
?>