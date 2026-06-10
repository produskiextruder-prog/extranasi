<?php
include 'koneksi.php';

$id = $_GET['id'];

mysqli_query($koneksi,"DELETE FROM input_tpm WHERE id='$id'");

header("Location: tabel_tpm.php");