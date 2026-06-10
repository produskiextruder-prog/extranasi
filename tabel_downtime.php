<?php
include "koneksi.php";

/* FILTER */

$where="";

if(isset($_GET['tanggal']) && $_GET['tanggal']!=""){
$tanggal=$_GET['tanggal'];
$where.=" AND tanggal='$tanggal'";
}

if(isset($_GET['shift']) && $_GET['shift']!=""){
$shift=$_GET['shift'];
$where.=" AND shift='$shift'";
}

$data=mysqli_query($koneksi,"SELECT * FROM downtime_mesin WHERE 1=1 $where ORDER BY tanggal DESC");

?>

<!DOCTYPE html>
<html>
<head>

<title>Data Downtime Extruder</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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

.table th{
font-size:13px;
text-align:center;
}

.table td{
font-size:12px;
}

</style>

</head>

<body>

<div class="sidebar">

<h4 style="text-align:center">EXTRUDER</h4>

<a href="dashboard.php">Dashboard</a>
<a href="input_downtime.php">Input Downtime</a>
<a href="tabel_downtime.php">Data Downtime</a>
<a href="grafik_downtime.php">Grafik Downtime</a>

</div>


<div class="content">

<div class="card p-4">

<h4>Data Downtime Mesin Extruder</h4>

<form method="GET" class="row">

<div class="col-md-3">
<input type="date" name="tanggal" class="form-control">
</div>

<div class="col-md-3">
<select name="shift" class="form-control">
<option value="">Semua Shift</option>
<option>Shift 1</option>
<option>Shift 2</option>
<option>Shift 3</option>
</select>
</div>

<div class="col-md-3">
<button class="btn btn-primary">Filter</button>
<a href="tabel_downtime.php" class="btn btn-secondary">Reset</a>
<a href="export_excel.php?tanggal=<?php echo $_GET['tanggal']??'' ?>" class="btn btn-success">Export Excel</a>
</div>

</form>

<br>

<div style="overflow-x:auto">

<table class="table table-bordered table-striped">

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

<th>Aksi</th>

</tr>

<?php

$no=1;

while($d=mysqli_fetch_array($data)){

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

<td>

<a href="edit_downtime.php?id=<?php echo $d['id'] ?>" class="btn btn-warning btn-sm">
Edit
</a>

<a href="hapus_downtime.php?id=<?php echo $d['id'] ?>" 
class="btn btn-danger btn-sm"
onclick="return confirm('Hapus data?')">
Hapus
</a>

<button class="btn btn-success btn-sm"
onclick="shareWA(<?php echo htmlspecialchars(json_encode($d)); ?>)">
WA
</button>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>


<script>

function shareWA(data){

let pesan="*LAPORAN DOWNTIME EXTRUDER*%0A%0A";

pesan+="Tanggal : "+data.tanggal+"%0A";
pesan+="Shift : "+data.shift+"%0A%0A";

for(let i=1;i<=4;i++){

let durasi=data["durasi"+i];

if(durasi>0){

pesan+="Downtime "+i+"%0A";
pesan+="Penyebab : "+data["penyebab"+i]+"%0A";
pesan+="Stop : "+data["stop"+i]+"%0A";
pesan+="Start : "+data["start"+i]+"%0A";
pesan+="Durasi : "+durasi+" menit%0A";
pesan+="FG : "+data["fg"+i]+"%0A";
pesan+="Afal : "+data["afal"+i]+"%0A%0A";

}

}

pesan+="Total FG : "+data.total_fg+"%0A";
pesan+="Total Afal : "+data.total_afal+"%0A";
pesan+="Total Downtime : "+data.total_downtime+" menit%0A";
pesan+="Runtime : "+data.runtime_mesin+" menit";

window.open("https://wa.me/?text="+pesan);

}

</script>

</body>
</html>