<?php
include "koneksi.php";

/* ========================
REKAP PRODUKSI SHIFT
======================== */

$shiftA=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(total_fg) fg, SUM(total_afal) afal FROM downtime_mesin WHERE shift='Shift 1'"));
$shiftB=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(total_fg) fg, SUM(total_afal) afal FROM downtime_mesin WHERE shift='Shift 2'"));
$shiftC=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(total_fg) fg, SUM(total_afal) afal FROM downtime_mesin WHERE shift='Shift 3'"));

$fgA=$shiftA['fg'] ?? 0;
$fgB=$shiftB['fg'] ?? 0;
$fgC=$shiftC['fg'] ?? 0;

$afalA=$shiftA['afal'] ?? 0;
$afalB=$shiftB['afal'] ?? 0;
$afalC=$shiftC['afal'] ?? 0;

$total_fg=$fgA+$fgB+$fgC;
$total_afal=$afalA+$afalB+$afalC;


/* ========================
PERSENTASE AMAN
======================== */

$persenA=0;
$persenB=0;
$persenC=0;
$persenTotal=0;

if(($fgA+$afalA)>0){
$persenA=($afalA/($fgA+$afalA))*100;
}

if(($fgB+$afalB)>0){
$persenB=($afalB/($fgB+$afalB))*100;
}

if(($fgC+$afalC)>0){
$persenC=($afalC/($fgC+$afalC))*100;
}

if(($total_fg+$total_afal)>0){
$persenTotal=($total_afal/($total_fg+$total_afal))*100;
}


/* ========================
DATA PARETO
======================== */

$data=mysqli_query($koneksi,"SELECT * FROM downtime_mesin");

$masalah=[];
$frekuensi=[];

while($d=mysqli_fetch_array($data)){

for($i=1;$i<=4;$i++){

$p=$d['penyebab'.$i];
$durasi=$d['durasi'.$i];

if($p!=""){

if(!isset($masalah[$p])){
$masalah[$p]=0;
$frekuensi[$p]=0;
}

$masalah[$p]+=$durasi;
$frekuensi[$p]+=1;

}

}

}

arsort($masalah);

?>

<!DOCTYPE html>
<html>

<head>

<title>Grafik Downtime</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{
background:#f4f6f9;
font-family:arial;
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
margin-bottom:30px;
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

<h3>Grafik Downtime Extruder</h3>
<a href="export_excel_grafik.php" class="btn btn-success mb-3">Export Excel</a>

<!-- TABEL PRODUKSI -->

<div class="card p-4">

<h4>Rekap Produksi per Shift</h4>

<table class="table table-bordered text-center">

<tr style="background:#f2c9a5">

<th>Shift</th>
<th>A</th>
<th>B</th>
<th>C</th>
<th>Total KG</th>
<th>Total TON</th>

</tr>

<tr>

<td><b>Hasil Produksi</b></td>

<td><?php echo number_format($fgA) ?></td>
<td><?php echo number_format($fgB) ?></td>
<td><?php echo number_format($fgC) ?></td>

<td><b><?php echo number_format($total_fg) ?></b></td>
<td><b><?php echo number_format($total_fg/1000,1) ?></b></td>

</tr>

<tr style="background:#d9e2f3">

<td><b>Total Afal</b></td>

<td><?php echo number_format($afalA) ?></td>
<td><?php echo number_format($afalB) ?></td>
<td><?php echo number_format($afalC) ?></td>

<td><b><?php echo number_format($total_afal) ?></b></td>
<td><b><?php echo number_format($total_afal/1000,1) ?></b></td>

</tr>

<tr>

<td><b>Persentase Afal</b></td>

<td><?php echo number_format($persenA,1) ?> %</td>
<td><?php echo number_format($persenB,1) ?> %</td>
<td><?php echo number_format($persenC,1) ?> %</td>

<td colspan="2"><b><?php echo number_format($persenTotal,1) ?> %</b></td>

</tr>

</table>

</div>


<!-- GRAFIK PRODUKSI -->

<div class="card p-4">

<h4>Grafik Produksi FG vs Afal</h4>

<canvas id="grafikProduksi"></canvas>

</div>


<!-- GRAFIK PARETO -->

<div class="card p-4">

<h4>Pareto Downtime</h4>

<canvas id="grafikPareto"></canvas>

</div>


<!-- TABEL PARETO -->

<div class="card p-4">

<h4>Tabel Pareto Downtime</h4>

<table class="table table-bordered">

<tr>

<th>No</th>
<th>Penyebab</th>
<th>Total Downtime (Menit)</th>
<th>Frekuensi</th>

</tr>

<?php

$no=1;

foreach($masalah as $key=>$value){

?>

<tr>

<td><?php echo $no++ ?></td>
<td><?php echo $key ?></td>
<td><?php echo $value ?></td>
<td><?php echo $frekuensi[$key] ?></td>

</tr>

<?php } ?>

</table>

</div>

</div>


<script>

/* GRAFIK PRODUKSI */

new Chart(document.getElementById("grafikProduksi"),{

type:'bar',

data:{

labels:['FG','Afal'],

datasets:[{

label:'Produksi',

data:[<?php echo $total_fg ?>,<?php echo $total_afal ?>],

backgroundColor:['green','red']

}]

}

});


/* GRAFIK PARETO */

new Chart(document.getElementById("grafikPareto"),{

type:'bar',

data:{

labels:[

<?php
foreach($masalah as $k=>$v){
echo "'".$k."',";
}
?>

],

datasets:[{

label:'Downtime (Menit)',

data:[

<?php
foreach($masalah as $v){
echo $v.",";
}
?>

],

backgroundColor:'orange'

}]

}

});

</script>

</body>
</html>