<?php
    session_start();
    if ($_SESSION['status'] == "login") {
        include "koneksi.php";

        $nama_penerima = $_POST['nama_penerima'];
        $kota = $_POST['kota'];
        $kecamatan = $_POST['kecamatan'];
        $desa = $_POST['desa'];
        $no_hp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];
        $id_user = $_POST['id_user'];

        $input = mysqli_query($konek, "insert into alamat values('','$id_user','$alamat','$nama_penerima','$kota','$kecamatan','$desa','$no_hp')");
        if ($input) {
            header("location:alamat.php?pesan=inputed");
        } else {
            header("location:alamat.php?pesan=gagal");
        }
    } else {
        header("location:login.php");
    }
?>