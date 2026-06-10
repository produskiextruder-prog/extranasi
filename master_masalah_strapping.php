<?php

include "koneksi.php";

/* ==========================
   SIMPAN DATA
========================== */

if(isset($_POST['simpan'])){

    $nama_masalah = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama_masalah']
    );

    mysqli_query($koneksi,"
    INSERT INTO master_masalah_strapping(
        nama_masalah
    )
    VALUES(
        '$nama_masalah'
    )
    ");

    echo "<script>
    alert('Data berhasil ditambahkan');
    location='master_masalah_strapping.php';
    </script>";
}

/* ==========================
   UPDATE DATA
========================== */

if(isset($_POST['update'])){

    $id = $_POST['id'];

    $nama_masalah = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama_masalah']
    );

    $aktif = $_POST['aktif'];

    mysqli_query($koneksi,"
    UPDATE master_masalah_strapping
    SET
        nama_masalah='$nama_masalah',
        aktif='$aktif'
    WHERE id='$id'
    ");

    echo "<script>
    alert('Data berhasil diupdate');
    location='master_masalah_strapping.php';
    </script>";
}

/* ==========================
   HAPUS DATA
========================== */

if(isset($_GET['hapus'])){

    $id = $_GET['hapus'];

    mysqli_query(
        $koneksi,
        "DELETE FROM master_masalah_strapping
         WHERE id='$id'"
    );

    echo "<script>
    alert('Data berhasil dihapus');
    location='master_masalah_strapping.php';
    </script>";
}

/* ==========================
   EDIT DATA
========================== */

$data_edit = null;

if(isset($_GET['edit'])){

    $id = $_GET['edit'];

    $qEdit = mysqli_query(
        $koneksi,
        "SELECT * FROM master_masalah_strapping
         WHERE id='$id'"
    );

    $data_edit = mysqli_fetch_assoc($qEdit);
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Master Masalah Strapping</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    font-family:Arial;
    background:#f4f6f9;
}

.sidebar{
    position:fixed;
    width:220px;
    height:100%;
    background:#1f2d3d;
    color:white;
    padding-top:20px;
}

.sidebar a{
    display:block;
    color:white;
    padding:12px;
    text-decoration:none;
}

.sidebar a:hover{
    background:#007bff;
}

.content{
    margin-left:240px;
    padding:30px;
}

.card{
    box-shadow:0 0 10px rgba(0,0,0,0.15);
}

</style>

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

<h4 style="text-align:center">
STRAPPING
</h4>

<a href="dashboard_strapping.php">
Dashboard
</a>

<a href="input_downtime_strapping.php">
Input Downtime
</a>

<a href="tabel_downtime_strapping.php">
Data Downtime
</a>

<a href="grafik_downtime_strapping.php">
Grafik Downtime
</a>

<a href="master_masalah_strapping.php">
Master Masalah
</a>

</div>

<!-- CONTENT -->

<div class="content">

<div class="card p-4">

<h3 class="mb-4">
MASTER MASALAH STRAPPING
</h3>

<form method="POST">

<?php if($data_edit){ ?>

<input
type="hidden"
name="id"
value="<?= $data_edit['id']; ?>">

<?php } ?>

<div class="row">

<div class="col-md-6">

<label>Nama Masalah</label>

<input
type="text"
name="nama_masalah"
class="form-control"
required
value="<?= $data_edit['nama_masalah'] ?? ''; ?>">

</div>

<?php if($data_edit){ ?>

<div class="col-md-3">

<label>Status</label>

<select
name="aktif"
class="form-control">

<option value="Y"
<?= ($data_edit['aktif']=='Y')?'selected':'' ?>>
Aktif
</option>

<option value="N"
<?= ($data_edit['aktif']=='N')?'selected':'' ?>>
Non Aktif
</option>

</select>

</div>

<?php } ?>

</div>

<br>

<?php if($data_edit){ ?>

<button
type="submit"
name="update"
class="btn btn-warning">

Update Data

</button>

<a
href="master_masalah_strapping.php"
class="btn btn-secondary">

Batal

</a>

<?php }else{ ?>

<button
type="submit"
name="simpan"
class="btn btn-primary">

Tambah Masalah

</button>

<?php } ?>

</form>

</div>

<br>

<div class="card p-4">

<h4>Data Master Masalah</h4>

<table class="table table-bordered table-striped">

<tr>

<th width="10%">No</th>
<th>Nama Masalah</th>
<th width="15%">Status</th>
<th width="20%">Aksi</th>

</tr>

<?php

$no = 1;

$qData = mysqli_query(
$koneksi,
"SELECT *
 FROM master_masalah_strapping
 ORDER BY nama_masalah ASC"
);

while($d = mysqli_fetch_assoc($qData)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $d['nama_masalah']; ?></td>

<td>

<?php

if($d['aktif']=="Y"){

    echo "<span class='badge bg-success'>
    Aktif
    </span>";

}else{

    echo "<span class='badge bg-danger'>
    Non Aktif
    </span>";
}

?>

</td>

<td>

<a
href="?edit=<?= $d['id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="?hapus=<?= $d['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Hapus data ini?')">

Hapus

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>

