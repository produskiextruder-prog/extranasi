<?php
include "koneksi.php";

// Hapus banyak
if(isset($_POST['hapus'])){
    foreach($_POST['hapus'] as $id){
        mysqli_query($koneksi, "DELETE FROM shutdown_mesin WHERE id='$id'");
    }
}

// Hapus satu
if(isset($_GET['id'])){
    mysqli_query($koneksi, "DELETE FROM shutdown_mesin WHERE id='$_GET[id]'");
}

header("location:tabel_shutdown.php");
?>