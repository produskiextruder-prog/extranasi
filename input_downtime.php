<?php

/* ==============================
KONEKSI DATABASE
============================== */
include "koneksi.php";


/* ==============================
INISIALISASI VARIABEL
Agar tidak muncul error
============================== */

$penyebab1="";
$penyebab2="";
$penyebab3="";
$penyebab4="";


/* ==============================
SIMPAN DATA
============================== */

if(isset($_POST['simpan'])){

$tanggal=$_POST['tanggal'];
$shift=$_POST['shift'];

$total_fg=$_POST['total_fg'];
$total_afal=$_POST['total_afal'];
$total_downtime=$_POST['total_downtime'];
$runtime=$_POST['runtime'];


/* ==============================
AMBIL DATA CHECKBOX PENYEBAB
============================== */

$penyebab1 = isset($_POST['penyebab1']) ? implode(",", $_POST['penyebab1']) : "";
$penyebab2 = isset($_POST['penyebab2']) ? implode(",", $_POST['penyebab2']) : "";
$penyebab3 = isset($_POST['penyebab3']) ? implode(",", $_POST['penyebab3']) : "";
$penyebab4 = isset($_POST['penyebab4']) ? implode(",", $_POST['penyebab4']) : "";


/* ==============================
QUERY SIMPAN DATABASE
============================== */

mysqli_query($koneksi,"INSERT INTO downtime_mesin(

tanggal,shift,

penyebab1,penyebab_lain1,stop1,start1,durasi1,spec1,fg1,afal1,
penyebab2,penyebab_lain2,stop2,start2,durasi2,spec2,fg2,afal2,
penyebab3,penyebab_lain3,stop3,start3,durasi3,spec3,fg3,afal3,
penyebab4,penyebab_lain4,stop4,start4,durasi4,spec4,fg4,afal4,

total_fg,total_afal,total_downtime,runtime_mesin

)

VALUES(

'$tanggal','$shift',

'$penyebab1','$_POST[penyebab_lain1]','$_POST[stop1]','$_POST[start1]','$_POST[durasi1]','$_POST[spec1]','$_POST[fg1]','$_POST[afal1]',
'$penyebab2','$_POST[penyebab_lain2]','$_POST[stop2]','$_POST[start2]','$_POST[durasi2]','$_POST[spec2]','$_POST[fg2]','$_POST[afal2]',
'$penyebab3','$_POST[penyebab_lain3]','$_POST[stop3]','$_POST[start3]','$_POST[durasi3]','$_POST[spec3]','$_POST[fg3]','$_POST[afal3]',
'$penyebab4','$_POST[penyebab_lain4]','$_POST[stop4]','$_POST[start4]','$_POST[durasi4]','$_POST[spec4]','$_POST[fg4]','$_POST[afal4]',

'$total_fg','$total_afal','$total_downtime','$runtime'

)");

echo "<script>alert('Data berhasil disimpan')</script>";

}

?>


<!DOCTYPE html>
<html>

<head>

<title>Input Downtime Extruder</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
font-family:arial;
background:#f4f6f9;
}

/* SIDEBAR */

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

.table-input th{
background:#e9ecef;
text-align:center;
}

.kolom-penyebab{
width:250px;
}

.kolom-penyebab label{
display:block;
}

</style>

</head>

<body>


<!-- SIDEBAR -->

<div class="sidebar">

<h4 style="text-align:center">EXTRUDER</h4>

<a href="dashboard.php">Dashboard</a>
<a href="input_downtime.php">Input Downtime</a>
<a href="tabel_downtime.php">Data Downtime</a>
<a href="grafik_downtime.php">Grafik Downtime</a>

</div>


<div class="content">

<div class="card p-4">

<h4>Input Downtime Mesin Extruder</h4>

<form method="POST">

<label>Tanggal</label>
<input type="date" name="tanggal" class="form-control" required>

<br>

<label>Shift</label>

<select name="shift" class="form-control">
<option>Shift 1</option>
<option>Shift 2</option>
<option>Shift 3</option>
</select>

<br>


<table class="table table-bordered table-input">

<tr>

<th>No</th>
<th class="kolom-penyebab">Penyebab</th>
<th>Penyebab Lain</th>
<th>Stop</th>
<th>Start</th>
<th>Durasi</th>
<th>Spec</th>
<th>FG</th>
<th>Afal</th>

</tr>


<?php for($i=1;$i<=4;$i++){ ?>

<tr>

<td><?php echo $i ?></td>

<td class="kolom-penyebab">

<label>
<input type="checkbox" name="penyebab<?php echo $i ?>[]" value="Cleaning Dies"> Cleaning Dies
</label>

<label>
<input type="checkbox" name="penyebab<?php echo $i ?>[]" value="Ganti Filter Piston"> Ganti Filter Piston
</label>

<label>
<input type="checkbox" name="penyebab<?php echo $i ?>[]" value="Ganti Cutter"> Ganti Cutter
</label>

<label>
<input type="checkbox" name="penyebab<?php echo $i ?>[]" value="Ganti Filter Melt Pump"> Ganti Filter Melt Pump
</label>

</td>

<td>
<input type="text" name="penyebab_lain<?php echo $i ?>" class="form-control">
</td>

<td>
<input type="time" id="stop<?php echo $i ?>" name="stop<?php echo $i ?>" class="form-control">
</td>

<td>
<input type="time" id="start<?php echo $i ?>" name="start<?php echo $i ?>" class="form-control">
</td>

<td>
<input type="number" id="durasi<?php echo $i ?>" name="durasi<?php echo $i ?>" class="form-control" readonly>
</td>

<td>
<input type="text" name="spec<?php echo $i ?>" class="form-control">
</td>

<td>
<input type="number" id="fg<?php echo $i ?>" name="fg<?php echo $i ?>" class="form-control">
</td>

<td>
<input type="number" id="afal<?php echo $i ?>" name="afal<?php echo $i ?>" class="form-control">
</td>

</tr>

<?php } ?>

</table>


<label>Total FG</label>
<input type="number" id="total_fg" name="total_fg" class="form-control" readonly>

<br>

<label>Total Afal</label>
<input type="number" id="total_afal" name="total_afal" class="form-control" readonly>

<br>

<label>Total Downtime</label>
<input type="number" id="total_downtime" name="total_downtime" class="form-control" readonly>

<br>

<label>Runtime Mesin</label>
<input type="number" id="runtime" name="runtime" class="form-control" readonly>

<br>

<button type="submit" name="simpan" class="btn btn-primary">
Simpan Data
</button>

</form>

</div>

</div>


<script>

/* HITUNG DURASI */

function hitung(no){

var stop=document.getElementById("stop"+no).value;
var start=document.getElementById("start"+no).value;

if(stop && start){

var s=new Date("1970-01-01T"+stop+":00");
var e=new Date("1970-01-01T"+start+":00");

var durasi=(e-s)/60000;

document.getElementById("durasi"+no).value=durasi;

hitungTotal();

}

}


/* HITUNG TOTAL */

function hitungTotal(){

var downtime=0;
var fg=0;
var afal=0;

for(i=1;i<=4;i++){

var d=document.getElementById("durasi"+i).value;
var f=document.getElementById("fg"+i).value;
var a=document.getElementById("afal"+i).value;

if(d!="") downtime+=parseInt(d);
if(f!="") fg+=parseInt(f);
if(a!="") afal+=parseInt(a);

}

document.getElementById("total_downtime").value=downtime;
document.getElementById("runtime").value=480-downtime;

document.getElementById("total_fg").value=fg;
document.getElementById("total_afal").value=afal;

}


/* EVENT */

for(let i=1;i<=4;i++){

document.getElementById("stop"+i).addEventListener("change",function(){hitung(i)});
document.getElementById("start"+i).addEventListener("change",function(){hitung(i)});

document.getElementById("fg"+i).addEventListener("keyup",hitungTotal);
document.getElementById("afal"+i).addEventListener("keyup",hitungTotal);

}

</script>

</body>
</html>