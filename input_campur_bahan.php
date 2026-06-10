<?php 
include "koneksi.php";

if(isset($_POST['simpan']))
{

$tanggal=$_POST['tanggal'];
$shift=$_POST['shift'];
$grup_shift=$_POST['grup_shift'];
$campuran_pp=$_POST['campuran_pp'];

$komposisi1=$_POST['komposisi1'];
$berat1=$_POST['berat1'];

$komposisi2=$_POST['komposisi2'];
$berat2=$_POST['berat2'];

$komposisi3=$_POST['komposisi3'];
$berat3=$_POST['berat3'];

$komposisi4=$_POST['komposisi4'];
$berat4=$_POST['berat4'];

$komposisi5=$_POST['komposisi5'];
$berat5=$_POST['berat5'];

$stock_awal=$_POST['stock_awal'];
$tambah_stock=$_POST['tambah_stock'];
$jumlah_total=$_POST['jumlah_total'];

$shift_pemakaian=$_POST['shift_pemakaian'];
$grup_pemakaian=$_POST['grup_pemakaian'];

$pemakaian=$_POST['pemakaian'];
$stock_akhir=$_POST['stock_akhir'];

mysqli_query($koneksi,"INSERT INTO campuran_bahan(
tanggal,shift,grup_shift,campuran_pp,
komposisi1,berat1,
komposisi2,berat2,
komposisi3,berat3,
komposisi4,berat4,
komposisi5,berat5,
stock_awal,tambah_stock,jumlah_total,
shift_pemakaian,grup_pemakaian,
pemakaian,stock_akhir
)

VALUES(

'$tanggal','$shift','$grup_shift','$campuran_pp',
'$komposisi1','$berat1',
'$komposisi2','$berat2',
'$komposisi3','$berat3',
'$komposisi4','$berat4',
'$komposisi5','$berat5',
'$stock_awal','$tambah_stock','$jumlah_total',
'$shift_pemakaian','$grup_pemakaian',
'$pemakaian','$stock_akhir'
)");

echo "<script>alert('Data berhasil disimpan');</script>";

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Input Campuran Bahan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
font-family:arial;
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

</style>

</head>

<body>

<div class="sidebar">

<h4 style="text-align:center">EXTRUDER</h4>

<a href="dashboard.php">Dashboard</a>
<a href="input_campur_bahan.php">Input Campuran Bahan</a>
<a href="tabel_campuran_bahan.php">Data Campuran Bahan</a>

</div>

<div class="content">

<div class="card p-4">

<h4>Input Campuran Bahan Produksi</h4>

<form method="POST">

<div class="row">

<div class="col-md-3">
Tanggal
<input type="date" name="tanggal" class="form-control">
</div>

<div class="col-md-2">
Shift
<select name="shift" class="form-control">
<option>1</option>
<option>2</option>
<option>3</option>
</select>
</div>

<div class="col-md-2">
Grup Shift
<select name="grup_shift" class="form-control">
<option>A</option>
<option>B</option>
<option>C</option>
</select>
</div>

<div class="col-md-3">
Campuran PP
<input type="text" name="campuran_pp" class="form-control">
</div>

</div>

<hr>

<h5>Komposisi Campuran</h5>

<table class="table table-bordered">

<tr>
<th>No</th>
<th>Komposisi</th>
<th>Berat</th>
</tr>

<tr>
<td>1</td>
<td><input type="text" name="komposisi1" class="form-control"></td>
<td><input type="number" id="berat1" name="berat1" class="form-control" onkeyup="hitungBerat()"></td>
</tr>

<tr>
<td>2</td>
<td><input type="text" name="komposisi2" class="form-control"></td>
<td><input type="number" id="berat2" name="berat2" class="form-control" onkeyup="hitungBerat()"></td>
</tr>

<tr>
<td>3</td>
<td><input type="text" name="komposisi3" class="form-control"></td>
<td><input type="number" id="berat3" name="berat3" class="form-control" onkeyup="hitungBerat()"></td>
</tr>

<tr>
<td>4</td>
<td><input type="text" name="komposisi4" class="form-control"></td>
<td><input type="number" id="berat4" name="berat4" class="form-control" onkeyup="hitungBerat()"></td>
</tr>

<tr>
<td>5</td>
<td><input type="text" name="komposisi5" class="form-control"></td>
<td><input type="number" id="berat5" name="berat5" class="form-control" onkeyup="hitungBerat()"></td>
</tr>

<tr>
<td colspan="2"><b>Total Berat</b></td>
<td><input type="number" id="total_berat" class="form-control" readonly></td>
</tr>

</table>

<hr>

<h5>Stock Bahan</h5>

<div class="row">

<div class="col-md-3">
Stock Awal
<input type="number" id="stock_awal" name="stock_awal" class="form-control" onkeyup="hitungStock()">
</div>

<div class="col-md-3">
Tambah Stock
<input type="number" id="tambah_stock" name="tambah_stock" class="form-control" onkeyup="hitungStock()">
</div>

<div class="col-md-3">
Jumlah Total
<input type="number" id="jumlah_total" name="jumlah_total" class="form-control" readonly>
</div>

</div>

<br>

<div class="row">

<div class="col-md-3">
Pemakaian
<input type="number" id="pemakaian" name="pemakaian" class="form-control" onkeyup="hitungStock()">
</div>

<div class="col-md-3">
Stock Akhir
<input type="number" id="stock_akhir" name="stock_akhir" class="form-control" readonly>
</div>

</div>

<br>

<div class="row">

<div class="col-md-3">
Shift Pemakaian
<select name="shift_pemakaian" class="form-control">
<option>1</option>
<option>2</option>
<option>3</option>
</select>
</div>

<div class="col-md-3">
Grup Pemakaian
<select name="grup_pemakaian" class="form-control">
<option>A</option>
<option>B</option>
<option>C</option>
</select>
</div>

</div>

<br>

<button type="submit" name="simpan" class="btn btn-primary">
Simpan Data
</button>

</form>

</div>

</div>

<script>

function hitungBerat(){

let b1 = parseInt(document.getElementById("berat1").value) || 0;
let b2 = parseInt(document.getElementById("berat2").value) || 0;
let b3 = parseInt(document.getElementById("berat3").value) || 0;
let b4 = parseInt(document.getElementById("berat4").value) || 0;
let b5 = parseInt(document.getElementById("berat5").value) || 0;

let total = b1+b2+b3+b4+b5;

document.getElementById("total_berat").value = total;

}

function hitungStock(){

let awal = parseInt(document.getElementById("stock_awal").value) || 0;
let tambah = parseInt(document.getElementById("tambah_stock").value) || 0;
let pemakaian = parseInt(document.getElementById("pemakaian").value) || 0;

let total = awal + tambah;
let akhir = total - pemakaian;

document.getElementById("jumlah_total").value = total;
document.getElementById("stock_akhir").value = akhir;

}

</script>

</body>
</html>