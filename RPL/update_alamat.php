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
        $id_alamat = $_POST['id_alamat'];
        $metode = $_POST['metode'];

        if ($metode == "Ubah") {
            $update = mysqli_query($konek, "update alamat set nama_penerima='$nama_penerima', alamat='$alamat', kota='$kota', kecamatan='$kecamatan', desa='$desa', no_hp='$no_hp' where id='$id_alamat'");
            if ($update) {
                header("location:alamat.php?pesan=updated");
            } else {
                header("location:alamat.php?pesan=gagal");
            }
        } else if ($metode == "Hapus") {
            $delete = mysqli_query($konek, "delete from alamat where id='$id_alamat'");
            if ($delete) {
                header("location:alamat.php?pesan=deleted");
            } else {
                header("location:alamat.php?pesan=gagal");
            }
        } else {
            header("location:alamat.php?pesan=gagal");
        }
    } else {
        header("location:login.php");
    }
?>