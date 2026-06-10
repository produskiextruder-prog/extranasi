<?php
include "koneksi.php";

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Downtime_Extruder.xls");

/* FILTER TANGGAL */

$where="";

if(isset($_GET['tanggal']) && $_GET['tanggal']!=""){
$tanggal=$_GET['tanggal'];
$where="WHERE tanggal='$tanggal'";
}

/* AMBIL DATA */

$data=mysqli_query($koneksi,"SELECT * FROM downtime_mesin $where ORDER BY tanggal DESC");

$total_fg=0;
$total_afal=0;
$total_downtime=0;

?>

<h2>LAPORAN DOWNTIME MESIN EXTRUDER</h2>

<table border="1">

<tr>
<th>No</th>
<th>Tanggal</th>
<th>Shift</th>

<th>Penyebab1</th>
<th>Stop1</th>
<th>Start1</th>
<th>Durasi1</th>
<th>Spec1</th>
<th>FG1</th>
<th>Afal1</th>

<th>Penyebab2</th>
<th>Stop2</th>
<th>Start2</th>
<th>Durasi2</th>
<th>Spec2</th>
<th>FG2</th>
<th>Afal2</th>

<th>Penyebab3</th>
<th>Stop3</th>
<th>Start3</th>
<th>Durasi3</th>
<th>Spec3</th>
<th>FG3</th>
<th>Afal3</th>

<th>Penyebab4</th>
<th>Stop4</th>
<th>Start4</th>
<th>Durasi4</th>
<th>Spec4</th>
<th>FG4</th>
<th>Afal4</th>

<th>Total FG</th>
<th>Total Afal</th>
<th>Total Downtime</th>
<th>Runtime</th>
</tr>

<?php

$no=1;

while($d=mysqli_fetch_array($data)){

$total_fg+=$d['total_fg'];
$total_afal+=$d['total_afal'];
$total_downtime+=$d['total_downtime'];

?>

<tr>

<td><?php echo $no++ ?></td>

<td><?php echo $d['tanggal'] ?></td>
<td><?php echo $d['shift'] ?></td>

<td><?php echo $d['penyebab1'] ?></td>
<td><?php echo $d['stop1'] ?></td>
<td><?php echo $d['start1'] ?></td>
<td><?php echo $d['durasi1'] ?></td>
<td><?php echo $d['spec1'] ?></td>
<td><?php echo $d['fg1'] ?></td>
<td><?php echo $d['afal1'] ?></td>

<td><?php echo $d['penyebab2'] ?></td>
<td><?php echo $d['stop2'] ?></td>
<td><?php echo $d['start2'] ?></td>
<td><?php echo $d['durasi2'] ?></td>
<td><?php echo $d['spec2'] ?></td>
<td><?php echo $d['fg2'] ?></td>
<td><?php echo $d['afal2'] ?></td>

<td><?php echo $d['penyebab3'] ?></td>
<td><?php echo $d['stop3'] ?></td>
<td><?php echo $d['start3'] ?></td>
<td><?php echo $d['durasi3'] ?></td>
<td><?php echo $d['spec3'] ?></td>
<td><?php echo $d['fg3'] ?></td>
<td><?php echo $d['afal3'] ?></td>

<td><?php echo $d['penyebab4'] ?></td>
<td><?php echo $d['stop4'] ?></td>
<td><?php echo $d['start4'] ?></td>
<td><?php echo $d['durasi4'] ?></td>
<td><?php echo $d['spec4'] ?></td>
<td><?php echo $d['fg4'] ?></td>
<td><?php echo $d['afal4'] ?></td>

<td><?php echo $d['total_fg'] ?></td>
<td><?php echo $d['total_afal'] ?></td>
<td><?php echo $d['total_downtime'] ?></td>
<td><?php echo $d['runtime_mesin'] ?></td>

</tr>

<?php } ?>

<tr style="background:#ddd;font-weight:bold">

<td colspan="31" align="right">TOTAL</td>

<td><?php echo $total_fg ?></td>
<td><?php echo $total_afal ?></td>
<td><?php echo $total_downtime ?></td>
<td></td>

</tr>

</table>