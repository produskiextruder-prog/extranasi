<?php

include "koneksi.php";

/* HEADER EXCEL */

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_grafik_downtime_extruder.xls");


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
PARETO
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

<h3>Laporan grafik Downtime Extruder</h3>

<br>

<table border="1">

<tr>
<th>Shift</th>
<th>A</th>
<th>B</th>
<th>C</th>
<th>Total KG</th>
<th>Total TON</th>
</tr>

<tr>

<td>Hasil Produksi</td>

<td><?php echo $fgA ?></td>
<td><?php echo $fgB ?></td>
<td><?php echo $fgC ?></td>

<td><?php echo $total_fg ?></td>
<td><?php echo $total_fg/1000 ?></td>

</tr>

<tr>

<td>Total Afal</td>

<td><?php echo $afalA ?></td>
<td><?php echo $afalB ?></td>
<td><?php echo $afalC ?></td>

<td><?php echo $total_afal ?></td>
<td><?php echo $total_afal/1000 ?></td>

</tr>

</table>

<br><br>

<h4>Pareto Downtime</h4>

<table border="1">

<tr>
<th>No</th>
<th>Penyebab</th>
<th>Total Downtime</th>
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