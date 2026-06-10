<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

/* ========================
   CEK SUBMIT
======================== */
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    /* ========================
       UPLOAD FOTO
    ======================== */
    $foto = "";
    if(isset($_FILES['foto_sparepart']) && $_FILES['foto_sparepart']['name'] != ""){

        $folder = "upload/";
        if(!is_dir($folder)){
            mkdir($folder);
        }

        $namaFile = time() . "_" . $_FILES['foto_sparepart']['name'];
        $tmp = $_FILES['foto_sparepart']['tmp_name'];

        move_uploaded_file($tmp, $folder.$namaFile);

        $foto = $folder.$namaFile;
    }

    /* ========================
       SIMPAN DATA
    ======================== */
    $query = "INSERT INTO input_tpm (
        tanggal, shift, mesin, kategori, permasalahan,
        permasalahan_detail, jam_mesin_off, jam_mesin_start,
        jam_selesai_perbaikan, perbaikan, pergantian_sparepart,
        foto_sparepart, pengecekan_teknik, pengecekan_produksi
    ) VALUES (
        '$_POST[tanggal]',
        '$_POST[shift]',
        '$_POST[mesin]',
        '$_POST[kategori]',
        '$_POST[permasalahan]',
        '$_POST[permasalahan_detail]',
        '$_POST[jam_mesin_off]',
        '$_POST[jam_mesin_start]',
        '$_POST[jam_selesai_perbaikan]',
        '$_POST[perbaikan]',
        '$_POST[pergantian_sparepart]',
        '$foto',
        '$_POST[pengecekan_teknik]',
        '$_POST[pengecekan_produksi]'
    )";

    $simpan = mysqli_query($koneksi, $query);

    if(!$simpan){
        die("Gagal simpan: " . mysqli_error($koneksi));
    }

    echo "<script>alert('Data berhasil disimpan');window.location='tabel_tpm.php';</script>";
}
?>