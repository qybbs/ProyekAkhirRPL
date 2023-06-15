<?php
    session_start();
    include "koneksi.php";

    $id = $_GET['id'];

    $delete = mysqli_query($konek, "delete from cart where id='$id'");
    if ($delete) {
        header("location:cart.php?pesan=berhasil");
    } else {
        header("location:cart.php?pesan=gagal");
    }
?>