<?php
include "koneksi.php";

/* ==========================
   SIMPAN DATA
========================== */

if(isset($_POST['simpan'])){

    mysqli_query($koneksi,"
    INSERT INTO downtime_strapping(
        tanggal,
        shift,

        produksi1,masalah1,detail1,stop1,start1,durasi1,output1,afal1,
        produksi2,masalah2,detail2,stop2,start2,durasi2,output2,afal2,
        produksi3,masalah3,detail3,stop3,start3,durasi3,output3,afal3,
        produksi4,masalah4,detail4,stop4,start4,durasi4,output4,afal4,

        total_output,
        total_afal,
        persen_afal,
        total_downtime,
        runtime_mesin,
        kg_per_jam
    )
    VALUES(
        '$_POST[tanggal]',
        '$_POST[shift]',

        '$_POST[produksi1]','$_POST[masalah1]','$_POST[detail1]','$_POST[stop1]','$_POST[start1]','$_POST[durasi1]','$_POST[output1]','$_POST[afal1]',
        '$_POST[produksi2]','$_POST[masalah2]','$_POST[detail2]','$_POST[stop2]','$_POST[start2]','$_POST[durasi2]','$_POST[output2]','$_POST[afal2]',
        '$_POST[produksi3]','$_POST[masalah3]','$_POST[detail3]','$_POST[stop3]','$_POST[start3]','$_POST[durasi3]','$_POST[output3]','$_POST[afal3]',
        '$_POST[produksi4]','$_POST[masalah4]','$_POST[detail4]','$_POST[stop4]','$_POST[start4]','$_POST[durasi4]','$_POST[output4]','$_POST[afal4]',

        '$_POST[total_output]',
        '$_POST[total_afal]',
        '$_POST[persen_afal]',
        '$_POST[total_downtime]',
        '$_POST[runtime_mesin]',
        '$_POST[kg_per_jam]'
    )
    ");

    echo "<script>
    alert('Data berhasil disimpan');
    location='input_downtime_strapping.php';
    </script>";
}

/* ==========================
   MASTER MASALAH
========================== */

$qMasalah = mysqli_query(
$koneksi,
"SELECT * FROM master_masalah_strapping
WHERE aktif='Y'
ORDER BY nama_masalah ASC"
);
?>

<!DOCTYPE html>
<html>
<head>

<title>Input Downtime Strapping</title>

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

.table th{
    text-align:center;
    vertical-align:middle;
}

.table td{
    vertical-align:middle;
}

</style>

</head>

<body>

<div class="sidebar">

<h4 style="text-align:center">
STRAPPING
</h4>

<a href="dashboard_strapping.php">Dashboard</a>
<a href="input_downtime_strapping.php">Input Downtime</a>
<a href="tabel_downtime_strapping.php">Data Downtime</a>
<a href="grafik_downtime_strapping.php">Grafik Downtime</a>
<a href="master_masalah_strapping.php">Master Masalah</a>

</div>

<div class="content">

<div class="card p-4">

<h3>INPUT DOWNTIME STRAPPING</h3>

<form method="POST">

<div class="row mb-3">

<div class="col-md-3">
<label>Tanggal</label>
<input type="date" name="tanggal" class="form-control" required>
</div>

<div class="col-md-3">
<label>Shift</label>
<select name="shift" class="form-control">
<option>Shift 1</option>
<option>Shift 2</option>
<option>Shift 3</option>
</select>
</div>

</div>

<table class="table table-bordered">

<tr>
<th>No</th>
<th>Produksi</th>
<th>Masalah</th>
<th>Detail</th>
<th>Stop</th>
<th>Start</th>
<th>Durasi</th>
<th>Output</th>
<th>Afal</th>
</tr>

<?php for($i=1;$i<=4;$i++){ ?>

<tr>

<td><?= $i ?></td>

<td>
<select name="produksi<?= $i ?>" class="form-control">
<option>Kerajinan</option>
<option>Industri</option>
</select>
</td>

<td>

<select
name="masalah<?= $i ?>"
class="form-control">

<option value="">
-- Pilih --
</option>

<?php
mysqli_data_seek($qMasalah,0);
while($m=mysqli_fetch_assoc($qMasalah)){
?>
<option value="<?= $m['nama_masalah']; ?>">
<?= $m['nama_masalah']; ?>
</option>
<?php } ?>

</select>

</td>

<td>
<input type="text"
name="detail<?= $i ?>"
class="form-control">
</td>

<td>
<input type="time"
id="stop<?= $i ?>"
name="stop<?= $i ?>"
class="form-control">
</td>

<td>
<input type="time"
id="start<?= $i ?>"
name="start<?= $i ?>"
class="form-control">
</td>

<td>
<input type="number"
id="durasi<?= $i ?>"
name="durasi<?= $i ?>"
class="form-control"
readonly>
</td>

<td>
<input type="number"
step="0.01"
id="output<?= $i ?>"
name="output<?= $i ?>"
class="form-control">
</td>

<td>
<input type="number"
step="0.01"
id="afal<?= $i ?>"
name="afal<?= $i ?>"
class="form-control">
</td>

</tr>

<?php } ?>

</table>

<div class="row">

<div class="col-md-3">
<label>Total Output</label>
<input type="number" step="0.01"
id="total_output"
name="total_output"
class="form-control" readonly>
</div>

<div class="col-md-3">
<label>Total Afal</label>
<input type="number" step="0.01"
id="total_afal"
name="total_afal"
class="form-control" readonly>
</div>

<div class="col-md-3">
<label>% Afal</label>
<input type="number" step="0.01"
id="persen_afal"
name="persen_afal"
class="form-control" readonly>
</div>

</div>

<br>

<div class="row">

<div class="col-md-3">
<label>Total Downtime</label>
<input type="number"
id="total_downtime"
name="total_downtime"
class="form-control"
readonly>
</div>

<div class="col-md-3">
<label>Runtime Mesin</label>
<input type="number"
id="runtime_mesin"
name="runtime_mesin"
class="form-control"
readonly>
</div>

<div class="col-md-3">
<label>Kg/Jam</label>
<input type="number"
step="0.01"
id="kg_per_jam"
name="kg_per_jam"
class="form-control"
readonly>
</div>

</div>

<br>

<button
type="submit"
name="simpan"
class="btn btn-primary">

Simpan Data

</button>

</form>

</div>

</div>

<script>

function hitung(no){

let stop=document.getElementById('stop'+no).value;
let start=document.getElementById('start'+no).value;

if(stop && start){

let s=new Date("1970-01-01T"+stop+":00");
let e=new Date("1970-01-01T"+start+":00");

if(e<s){
e.setDate(e.getDate()+1);
}

let menit=(e-s)/60000;

document.getElementById('durasi'+no).value=
Math.round(menit);

hitungTotal();
}
}

function hitungTotal(){

let totalOutput=0;
let totalAfal=0;
let totalDowntime=0;

for(let i=1;i<=4;i++){

totalOutput +=
parseFloat(document.getElementById('output'+i).value)||0;

totalAfal +=
parseFloat(document.getElementById('afal'+i).value)||0;

totalDowntime +=
parseFloat(document.getElementById('durasi'+i).value)||0;

}

document.getElementById('total_output').value=
totalOutput.toFixed(2);

document.getElementById('total_afal').value=
totalAfal.toFixed(2);

document.getElementById('total_downtime').value=
totalDowntime;

let totalProduksi =
totalOutput + totalAfal;

if(totalProduksi > 0){

document.getElementById('persen_afal').value =
((totalAfal / totalProduksi) * 100).toFixed(2);

}else{

document.getElementById('persen_afal').value = 0;

}

let runtime=480-totalDowntime;

document.getElementById('runtime_mesin').value=
runtime;

if(runtime>0){

let kgjam=
totalOutput/(runtime/60);

document.getElementById('kg_per_jam').value=
kgjam.toFixed(2);

}
}

for(let i=1;i<=4;i++){

document.getElementById('stop'+i)
.addEventListener('change',function(){
hitung(i);
});

document.getElementById('start'+i)
.addEventListener('change',function(){
hitung(i);
});

document.getElementById('output'+i)
.addEventListener('keyup',hitungTotal);

document.getElementById('afal'+i)
.addEventListener('keyup',hitungTotal);

}

</script>

</body>
</html>