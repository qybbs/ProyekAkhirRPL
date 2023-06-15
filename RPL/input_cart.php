<?php
    session_start();
    if ($_SESSION['status'] == "login") {
        include "koneksi.php";

        $idproduk = $_POST['id'];
        $kuantitas = $_POST['kuantitas'];
        $iduser = $_SESSION['id'];

        if ($kuantitas <= 0) {
            header("location:detail-produk.php?pesan=nol");
        } else {
            $input = mysqli_query($konek, "insert into cart values('','$iduser','$idproduk','$kuantitas','unchecked')");
            if ($input) {
                header("location:detail-produk.php?pesan=berhasil");
            } else {
                header("location:detail-produk.php?pesan=gagal");
            }
        }
    } else {
        header("location:login.php");
    }
?>