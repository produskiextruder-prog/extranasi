<?php

date_default_timezone_set('Asia/Jakarta');

include 'koneksi.php';

/* ===================================================
   TPM MONITOR STYLE BANDARA
   DATA AKAN HILANG JIKA:
   TEKNIK = OK
   DAN
   PRODUKSI = OK
=================================================== */

$sql = mysqli_query($koneksi,"
SELECT *
FROM input_tpm
WHERE NOT (
    pengecekan_teknik='OK'
    AND pengecekan_produksi='OK'
)
ORDER BY 
FIELD(kategori,'Breakdown','Kritis','WO'),
id DESC
");

?>

<!DOCTYPE html>
<html>
<head>
<title>TPM MONITOR</title>

<meta http-equiv="refresh" content="15">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:Arial, Helvetica, sans-serif;
background:#000814;
color:white;
overflow:hidden;
}

/* =========================
   HEADER
========================= */

.header{
height:100px;
background:linear-gradient(90deg,#001d3d,#003566,#001d3d);
display:flex;
justify-content:space-between;
align-items:center;
padding:0 30px;
border-bottom:4px solid #00d9ff;
}

.title{
font-size:46px;
font-weight:bold;
letter-spacing:3px;
}

.clock-box{
text-align:right;
}

.clock{
font-size:42px;
font-weight:bold;
color:#00ffcc;
font-family:Consolas;
}

.date{
font-size:20px;
margin-top:5px;
}

/* =========================
   RUNNING TEXT
========================= */

.running{
height:45px;
background:#001233;
display:flex;
align-items:center;
border-bottom:2px solid #00d9ff;
overflow:hidden;
}

.running marquee{
font-size:24px;
font-weight:bold;
color:#00ff99;
}

/* =========================
   TABLE
========================= */

.monitor{
padding:10px;
height:calc(100vh - 190px);
overflow:auto;
}

table{
width:100%;
border-collapse:collapse;
table-layout:fixed;
}

/* HEADER TABLE */

th{
background:#003566;
color:white;
padding:16px 8px;
font-size:22px;
border:2px solid #001d3d;
text-transform:uppercase;
}

/* BODY TABLE */

td{
padding:14px 8px;
font-size:22px;
font-weight:bold;
border:2px solid #001d3d;
text-align:center;
vertical-align:middle;
word-wrap:break-word;
overflow-wrap:break-word;
white-space:normal;
line-height:1.5;
font-family:Consolas;
}

/* =========================
   KOLOM KHUSUS
========================= */

.permasalahan{
text-align:left;
padding-left:12px;
font-size:20px;
}

.detail{
text-align:left;
padding-left:12px;
font-size:18px;
line-height:1.6;
}

.durasi{
font-size:32px;
color:#ffff66;
font-weight:bold;
letter-spacing:2px;
}

/* =========================
   WARNA ROW
========================= */

.breakdown{
background:#a30000;
animation:blink 1s infinite;
}

.kritis{
background:#ff7b00;
}

.wo{
background:#0055aa;
}

/* =========================
   STATUS
========================= */

.ok{
color:#00ff99;
font-weight:bold;
}

.no{
color:#ffd6d6;
font-weight:bold;
}

/* =========================
   ANIMATION
========================= */

@keyframes blink{
0%{opacity:1;}
50%{opacity:0.7;}
100%{opacity:1;}
}

/* =========================
   FOOTER
========================= */

.footer{
position:fixed;
bottom:0;
width:100%;
height:40px;
background:#001d3d;
display:flex;
justify-content:center;
align-items:center;
font-size:16px;
letter-spacing:1px;
border-top:2px solid #00d9ff;
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width:1400px){

.title{
font-size:32px;
}

.clock{
font-size:28px;
}

.date{
font-size:15px;
}

.running marquee{
font-size:16px;
}

th{
font-size:14px;
padding:10px 4px;
}

td{
font-size:13px;
padding:10px 4px;
}

.permasalahan{
font-size:13px;
}

.detail{
font-size:12px;
}

.durasi{
font-size:18px;
}

}

</style>
</head>

<body>

<!-- HEADER -->
<div class="header">

<div class="title">
MONITOR TPM EXTRUDER 
</div>

<div class="clock-box">

<div class="clock" id="clock">
00:00:00
</div>

<div class="date" id="date">
-
</div>

</div>

</div>

<!-- RUNNING TEXT -->
<div class="running">

<marquee scrollamount="10">

🚨 MONITOR TPM MESIN EXTRUDER 🚨
Data otomatis hilang jika pengecekan teknik dan produksi sudah OK
🚨 Pantau kondisi mesin realtime 🚨

</marquee>

</div>

<!-- TABLE -->
<div class="monitor">

<table>

<tr>
<th width="4%">NO</th>
<th width="8%">TANGGAL</th>
<th width="6%">SHIFT</th>
<th width="10%">MESIN</th>
<th width="8%">KATEGORI</th>
<th width="14%">PERMASALAHAN</th>
<th width="18%">DETAIL</th>
<th width="7%">OFF</th>
<th width="7%">SELESAI</th>
<th width="8%">DURASI</th>
<th width="5%">TEKNIK</th>
<th width="5%">PROD</th>
</tr>

<?php
$no=1;

while($row=mysqli_fetch_assoc($sql)){

/* =========================
   WARNA BERDASARKAN KATEGORI
========================= */

$class = "breakdown";

if($row['kategori']=="Kritis"){
$class = "kritis";
}

if($row['kategori']=="WO"){
$class = "wo";
}

/* =========================
   HITUNG DURASI REALTIME
========================= */

$durasi = "-";

if(!empty($row['jam_mesin_off'])){

    $off = strtotime($row['jam_mesin_off']);

    if(
        !empty($row['jam_selesai_perbaikan']) &&
        $row['jam_selesai_perbaikan'] != '0000-00-00 00:00:00'
    ){

        $akhir = strtotime($row['jam_selesai_perbaikan']);

    }else{

        $akhir = time();

    }

    $selisih = $akhir - $off;

    if($selisih < 0){
        $selisih = 0;
    }

    /* TOTAL MENIT */
    $total_menit = floor($selisih / 60);

    $durasi = $total_menit . " MENIT";
}
?>

<tr class="<?= $class; ?>">

<td><?= $no++; ?></td>

<td>
<?= date('d-m-Y',strtotime($row['tanggal'])); ?>
</td>

<td>
SHIFT <?= $row['shift']; ?>
</td>

<td>
<?= strtoupper($row['mesin']); ?>
</td>

<td>
<?= strtoupper($row['kategori']); ?>
</td>

<td class="permasalahan">
<?= strtoupper($row['permasalahan']); ?>
</td>

<td class="detail">
<?= strtoupper($row['permasalahan_detail']); ?>
</td>

<td>
<?= date('H:i',strtotime($row['jam_mesin_off'])); ?>
</td>

<td>

<?php
if(
!empty($row['jam_selesai_perbaikan']) &&
$row['jam_selesai_perbaikan'] != '0000-00-00 00:00:00'
){
echo date('H:i',strtotime($row['jam_selesai_perbaikan']));
}else{
echo "-";
}
?>

</td>

<td class="durasi">
    <?= $durasi; ?>
</td>

<td>

<?php
if($row['pengecekan_teknik']=="OK"){
echo "<span class='ok'>OK</span>";
}else{
echo "<span class='no'>NO</span>";
}
?>

</td>

<td>

<?php
if($row['pengecekan_produksi']=="OK"){
echo "<span class='ok'>OK</span>";
}else{
echo "<span class='no'>NO</span>";
}
?>

</td>

</tr>

<?php } ?>

</table>

</div>

<!-- FOOTER -->
<div class="footer">
TPM MONITOR SYSTEM | AUTO REFRESH 15 DETIK
</div>

<!-- CLOCK -->
<script>

function updateClock(){

const now = new Date();

let jam = String(now.getHours()).padStart(2,'0');
let menit = String(now.getMinutes()).padStart(2,'0');
let detik = String(now.getSeconds()).padStart(2,'0');

document.getElementById("clock").innerHTML =
jam + ":" + menit + ":" + detik;

const bulan = [
"JANUARI","FEBRUARI","MARET","APRIL",
"MEI","JUNI","JULI","AGUSTUS",
"SEPTEMBER","OKTOBER","NOVEMBER","DESEMBER"
];

let tanggal =
now.getDate() + " " +
bulan[now.getMonth()] + " " +
now.getFullYear();

document.getElementById("date").innerHTML =
tanggal;

}

setInterval(updateClock,1000);

updateClock();

</script>

</body>
</html>