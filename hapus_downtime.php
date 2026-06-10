<?php
include "koneksi.php";

// Ambil ID dari URL
$id = $_GET['id'] ?? 0;

if($id){
    // Hapus data berdasarkan ID
    $hapus = mysqli_query($koneksi, "DELETE FROM downtime_mesin WHERE id='$id'");

    if($hapus){
        // Redirect kembali ke tabel dengan notifikasi
        echo "<script>
            alert('Data berhasil dihapus');
            window.location='tabel_downtime.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus data');
            window.location='tabel_downtime.php';
        </script>";
    }
} else {
    echo "<script>
        alert('ID tidak valid');
        window.location='tabel_downtime.php';
    </script>";
}
?>