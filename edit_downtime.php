<?php
include "koneksi.php";

$id=$_GET['id'];

$data=mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM downtime_mesin WHERE id='$id'"));

if(isset($_POST['update'])){

$tanggal=$_POST['tanggal'];
$shift=$_POST['shift'];

$penyebab1 = isset($_POST['penyebab1']) ? implode(",", $_POST['penyebab1']) : "";
$penyebab2 = isset($_POST['penyebab2']) ? implode(",", $_POST['penyebab2']) : "";
$penyebab3 = isset($_POST['penyebab3']) ? implode(",", $_POST['penyebab3']) : "";
$penyebab4 = isset($_POST['penyebab4']) ? implode(",", $_POST['penyebab4']) : "";

mysqli_query($koneksi,"UPDATE downtime_mesin SET

tanggal='$tanggal',
shift='$shift',

penyebab1='$penyebab1',
penyebab_lain1='$_POST[penyebab_lain1]',
stop1='$_POST[stop1]',
start1='$_POST[start1]',
durasi1='$_POST[durasi1]',
spec1='$_POST[spec1]',
fg1='$_POST[fg1]',
afal1='$_POST[afal1]',

penyebab2='$penyebab2',
penyebab_lain2='$_POST[penyebab_lain2]',
stop2='$_POST[stop2]',
start2='$_POST[start2]',
durasi2='$_POST[durasi2]',
spec2='$_POST[spec2]',
fg2='$_POST[fg2]',
afal2='$_POST[afal2]',

penyebab3='$penyebab3',
penyebab_lain3='$_POST[penyebab_lain3]',
stop3='$_POST[stop3]',
start3='$_POST[start3]',
durasi3='$_POST[durasi3]',
spec3='$_POST[spec3]',
fg3='$_POST[fg3]',
afal3='$_POST[afal3]',

penyebab4='$penyebab4',
penyebab_lain4='$_POST[penyebab_lain4]',
stop4='$_POST[stop4]',
start4='$_POST[start4]',
durasi4='$_POST[durasi4]',
spec4='$_POST[spec4]',
fg4='$_POST[fg4]',
afal4='$_POST[afal4]',

total_fg='$_POST[total_fg]',
total_afal='$_POST[total_afal]',
total_downtime='$_POST[total_downtime]',
runtime_mesin='$_POST[runtime]'

WHERE id='$id'");

echo "<script>alert('Data berhasil diupdate');location='tabel_downtime.php';</script>";

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Downtime</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h4>Edit Downtime Mesin</h4>

<form method="POST">

<label>Tanggal</label>
<input type="date" name="tanggal" value="<?php echo $data['tanggal']?>" class="form-control">

<br>

<label>Shift</label>

<select name="shift" class="form-control">

<option <?php if($data['shift']=="Shift 1") echo "selected"; ?>>Shift 1</option>
<option <?php if($data['shift']=="Shift 2") echo "selected"; ?>>Shift 2</option>
<option <?php if($data['shift']=="Shift 3") echo "selected"; ?>>Shift 3</option>

</select>

<br>

<table class="table table-bordered">

<tr>

<th>No</th>
<th>Penyebab</th>
<th>Penyebab Lain</th>
<th>Stop</th>
<th>Start</th>
<th>Durasi</th>
<th>Spec</th>
<th>FG</th>
<th>Afal</th>

</tr>

<?php for($i=1;$i<=4;$i++){

$penyebab_db = explode(",",$data['penyebab'.$i]);

?>

<tr>

<td><?php echo $i ?></td>

<td>

<label>
<input type="checkbox" name="penyebab<?php echo $i ?>[]" value="Cleaning Dies"
<?php if(in_array("Cleaning Dies",$penyebab_db)) echo "checked"; ?>>
Cleaning Dies
</label><br>

<label>
<input type="checkbox" name="penyebab<?php echo $i ?>[]" value="Ganti Filter Piston"
<?php if(in_array("Ganti Filter Piston",$penyebab_db)) echo "checked"; ?>>
Ganti Filter Piston
</label><br>

<label>
<input type="checkbox" name="penyebab<?php echo $i ?>[]" value="Ganti Cutter"
<?php if(in_array("Ganti Cutter",$penyebab_db)) echo "checked"; ?>>
Ganti Cutter
</label><br>

<label>
<input type="checkbox" name="penyebab<?php echo $i ?>[]" value="Ganti Filter Melt Pump"
<?php if(in_array("Ganti Filter Melt Pump",$penyebab_db)) echo "checked"; ?>>
Ganti Filter Melt Pump
</label>

</td>

<td>
<input type="text" name="penyebab_lain<?php echo $i ?>" value="<?php echo $data['penyebab_lain'.$i] ?>" class="form-control">
</td>

<td>
<input type="time" id="stop<?php echo $i ?>" name="stop<?php echo $i ?>" value="<?php echo $data['stop'.$i] ?>" class="form-control">
</td>

<td>
<input type="time" id="start<?php echo $i ?>" name="start<?php echo $i ?>" value="<?php echo $data['start'.$i] ?>" class="form-control">
</td>

<td>
<input type="number" id="durasi<?php echo $i ?>" name="durasi<?php echo $i ?>" value="<?php echo $data['durasi'.$i] ?>" class="form-control" readonly>
</td>

<td>
<input type="text" name="spec<?php echo $i ?>" value="<?php echo $data['spec'.$i] ?>" class="form-control">
</td>

<td>
<input type="number" id="fg<?php echo $i ?>" name="fg<?php echo $i ?>" value="<?php echo $data['fg'.$i] ?>" class="form-control">
</td>

<td>
<input type="number" id="afal<?php echo $i ?>" name="afal<?php echo $i ?>" value="<?php echo $data['afal'.$i] ?>" class="form-control">
</td>

</tr>

<?php } ?>

</table>


<label>Total FG</label>
<input type="number" id="total_fg" name="total_fg" value="<?php echo $data['total_fg']?>" class="form-control" readonly>

<br>

<label>Total Afal</label>
<input type="number" id="total_afal" name="total_afal" value="<?php echo $data['total_afal']?>" class="form-control" readonly>

<br>

<label>Total Downtime</label>
<input type="number" id="total_downtime" name="total_downtime" value="<?php echo $data['total_downtime']?>" class="form-control" readonly>

<br>

<label>Runtime Mesin</label>
<input type="number" id="runtime" name="runtime" value="<?php echo $data['runtime_mesin']?>" class="form-control" readonly>

<br>

<button class="btn btn-primary" name="update">
Update Data
</button>

<a href="tabel_downtime.php" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

<script>

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

for(let i=1;i<=4;i++){

document.getElementById("stop"+i).addEventListener("change",function(){hitung(i)});
document.getElementById("start"+i).addEventListener("change",function(){hitung(i)});

document.getElementById("fg"+i).addEventListener("keyup",hitungTotal);
document.getElementById("afal"+i).addEventListener("keyup",hitungTotal);

}

</script>

</body>
</html>