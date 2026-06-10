<?php
include "koneksi.php";

/* TOTAL DATA */

$total_fg=0;
$total_afal=0;
$total_runtime=0;

$data=mysqli_query($koneksi,"SELECT * FROM downtime_mesin");

while($d=mysqli_fetch_array($data)){

$total_fg += $d['total_fg'];
$total_afal += $d['total_afal'];
$total_runtime += $d['runtime_mesin'];

}

/* DATA GRAFIK */

$grafik=mysqli_query($koneksi,"SELECT tanggal,total_fg,total_afal,runtime_mesin FROM downtime_mesin ORDER BY tanggal");

$tanggal=[];
$fg=[];
$afal=[];
$runtime=[];

while($g=mysqli_fetch_array($grafik)){

$tanggal[]=$g['tanggal'];
$fg[]=$g['total_fg'];
$afal[]=$g['total_afal'];
$runtime[]=$g['runtime_mesin'];

}

?>
<!DOCTYPE html>
<html>
<head>

<title>Monitoring Downtime Mesin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{
background:#f4f6f9;
font-family:arial;
}

.card{
margin-bottom:20px;
}

</style>

</head>

<body>

<div class="container mt-4">

<h3>Monitoring Downtime Mesin Extruder</h3>

<div class="row">

<div class="col-md-4">

<div class="card text-white bg-success">

<div class="card-body">

<h5>Total FG</h5>

<h3><?php echo $total_fg; ?></h3>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card text-white bg-danger">

<div class="card-body">

<h5>Total Afal</h5>

<h3><?php echo $total_afal; ?></h3>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card text-white bg-primary">

<div class="card-body">

<h5>Total Runtime</h5>

<h3><?php echo $total_runtime; ?></h3>

</div>

</div>

</div>

</div>

<!-- TABEL -->

<div class="card">

<div class="card-header">
Data Produksi
</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th>No</th>
<th>Tanggal</th>
<th>FG</th>
<th>Afal</th>
<th>Runtime</th>

</tr>

<?php

$no=1;

$data=mysqli_query($koneksi,"SELECT * FROM downtime_mesin ORDER BY tanggal DESC");

while($d=mysqli_fetch_array($data)){

?>

<tr>

<td><?php echo $no++; ?></td>

<td><?php echo $d['tanggal']; ?></td>

<td><?php echo $d['total_fg']; ?></td>

<td><?php echo $d['total_afal']; ?></td>

<td><?php echo $d['runtime_mesin']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</div>

<!-- GRAFIK FG AFAL -->

<div class="card">

<div class="card-header">
Grafik FG vs Afal
</div>

<div class="card-body">

<canvas id="grafik1"></canvas>

</div>

</div>

<!-- GRAFIK RUNTIME -->

<div class="card">

<div class="card-header">
Grafik Runtime Mesin
</div>

<div class="card-body">

<canvas id="grafik2"></canvas>

</div>

</div>

</div>

<script>

/* DATA PHP KE JS */

var tanggal=<?php echo json_encode($tanggal); ?>;
var fg=<?php echo json_encode($fg); ?>;
var afal=<?php echo json_encode($afal); ?>;
var runtime=<?php echo json_encode($runtime); ?>;

/* GRAFIK FG AFAL */

new Chart(document.getElementById("grafik1"),{

type:'bar',

data:{
labels:tanggal,
datasets:[
{
label:'FG',
data:fg,
backgroundColor:'green'
},
{
label:'Afal',
data:afal,
backgroundColor:'red'
}
]
}

});

/* GRAFIK RUNTIME */

new Chart(document.getElementById("grafik2"),{

type:'line',

data:{
labels:tanggal,
datasets:[
{
label:'Runtime',
data:runtime,
borderColor:'blue',
fill:false
}
]
}

});

</script>

</body>
</html>