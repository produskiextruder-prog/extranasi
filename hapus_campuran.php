<?php
include "koneksi.php";

/* Hapus 1 data */

if(isset($_GET['id']))
{

$id=$_GET['id'];

mysqli_query($koneksi,"DELETE FROM campuran_bahan WHERE id='$id'");

header("location:tabel_campuran_bahan.php");

}

/* Hapus banyak data */

if(isset($_POST['hapus']))
{

$hapus = $_POST['hapus'];

foreach($hapus as $id)
{

mysqli_query($koneksi,"DELETE FROM campuran_bahan WHERE id='$id'");

}

echo "<script>
alert('Data berhasil dihapus');
window.location='tabel_campuran_bahan.php';
</script>";

}
?>