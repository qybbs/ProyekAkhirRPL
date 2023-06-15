<?php
    session_start();
    if ($_SESSION['status'] == "login") {
        include "koneksi.php";

        $id_user = $_SESSION['id'];

        $user = mysqli_query($konek, "select * from user where id='$id_user'");
        $datauser = mysqli_fetch_array($user);

        $oldpass = $_POST['oldpass'];
        $pass = $_POST['pass'];
        $conpass = $_POST['conpass'];

        if ($oldpass == $datauser['password']) {
            if ($pass = $conpass) {
                $update = mysqli_query($konek, "update user set password='$pass' where id='$id_user'");
                if ($update) {
                    header("location:password.php?pesan=berhasil");
                } else {
                    header("location:password.php?pesan=gagal");
                }
            } else {
                header("location:password.php?pesan=beda");
            }
        } else {
            header("location.php?pesan=bukan");
        }
    } else {
        header("location:login.php");
    }
?>