<?php
    session_start();
    if ($_SESSION['status'] == "login") {
        include "koneksi.php";

        $alamat = $_POST['alamat'];
        $metode = $_POST['metode'];
        $total = $_POST['total'];
        $bayar = $_POST['bayar'];
        $kode = $_POST['kode'];
        $ongkir = $_POST['ongkir'];
        $id_user = $_SESSION['id'];

        $input = mysqli_query($konek, "insert into checkout values('','$id_user','$alamat','$kode','$total','$ongkir','$bayar','$metode')");
            if ($input) {
                $update = mysqli_query($konek, "update cart set kode_checkout='$kode' where kode_checkout='unchecked'");
                if ($update) {
                    header("location:pesanan.php");
                } else {
                    header("location:checkout.php?pesan=gagal");    
                }
            } else {
                header("location:checkout.php?pesan=gagal");
            }
    } else {
        header("location:login.php");
    }
?>