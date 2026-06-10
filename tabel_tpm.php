<?php
include 'koneksi.php';

/* ================================
   FILTER (ASLI - TIDAK DIUBAH)
================================ */
$where = [];

$tanggal = $_GET['tanggal'] ?? '';
$shift   = $_GET['shift'] ?? '';
$mesin   = $_GET['mesin'] ?? '';
$kategori= $_GET['kategori'] ?? '';

if($tanggal != '') $where[] = "tanggal = '$tanggal'";
if($shift != '')   $where[] = "shift = '$shift'";
if($mesin != '')   $where[] = "mesin LIKE '%$mesin%'";
if($kategori != '')$where[] = "kategori = '$kategori'";

$sql = "SELECT * FROM input_tpm";

if(count($where) > 0){
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY id DESC";

$data = mysqli_query($koneksi, $sql);

/* ================================
   AI EVALUASI TPM
================================ */

$week = mysqli_fetch_assoc(mysqli_query($koneksi,"
SELECT
COUNT(*) total,
COUNT(CASE WHEN kategori='Breakdown' THEN 1 END) breakdown
FROM input_tpm
WHERE tanggal >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)
"));

$month = mysqli_fetch_assoc(mysqli_query($koneksi,"
SELECT
COUNT(*) total,
COUNT(CASE WHEN kategori='Breakdown' THEN 1 END) breakdown
FROM input_tpm
WHERE tanggal >= DATE_SUB(CURDATE(),INTERVAL 30 DAY)
"));

$mesin_week = mysqli_fetch_assoc(mysqli_query($koneksi,"
SELECT mesin,COUNT(*) jml
FROM input_tpm
WHERE tanggal >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)
GROUP BY mesin
ORDER BY jml DESC
LIMIT 1
"));

$problem_week = mysqli_fetch_assoc(mysqli_query($koneksi,"
SELECT permasalahan,COUNT(*) jml
FROM input_tpm
WHERE tanggal >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)
GROUP BY permasalahan
ORDER BY jml DESC
LIMIT 1
"));

$mesin_month = mysqli_fetch_assoc(mysqli_query($koneksi,"
SELECT mesin,COUNT(*) jml
FROM input_tpm
WHERE tanggal >= DATE_SUB(CURDATE(),INTERVAL 30 DAY)
GROUP BY mesin
ORDER BY jml DESC
LIMIT 1
"));

$problem_month = mysqli_fetch_assoc(mysqli_query($koneksi,"
SELECT permasalahan,COUNT(*) jml
FROM input_tpm
WHERE tanggal >= DATE_SUB(CURDATE(),INTERVAL 30 DAY)
GROUP BY permasalahan
ORDER BY jml DESC
LIMIT 1
"));

/* ================================
   HAPUS (ASLI)
================================ */
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM input_tpm WHERE id='$id'");
    header("Location: tabel_tpm.php");
}

/* ================================
   HAPUS MASSAL (TAMBAHAN)
================================ */
if(isset($_GET['hapus_massal'])){
    $ids = $_GET['hapus_massal'];
    mysqli_query($koneksi, "DELETE FROM input_tpm WHERE id IN ($ids)");
    header("Location: tabel_tpm.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tabel TPM</title>

<style>
body{
margin:0;
font-family:Arial;
background:linear-gradient(135deg,#1f4037,#99f2c8);
min-height:100vh;
}

.sidebar{
position:fixed;
left:0;
top:0;
width:240px;
height:100%;
background:linear-gradient(180deg,#0f2027,#2c5364);
padding-top:20px;
box-shadow:3px 0 10px rgba(0,0,0,0.4);
overflow:auto;
}

.sidebar h2{
color:white;
text-align:center;
margin-bottom:30px;
font-size:20px;
}

.sidebar a{
display:block;
color:white;
padding:12px 20px;
text-decoration:none;
font-size:14px;
transition:0.3s;
}

.sidebar a:hover{
background:rgba(255,255,255,0.1);
padding-left:28px;
}

.main{
margin-left:240px;
padding:20px;
}

h2{
color:white;
text-align:center;
}

/* CARD */
.card{
background:white;
padding:20px;
border-radius:12px;
margin-bottom:15px;
box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

/* FILTER */
.filter-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
gap:15px;
align-items:end;
}

.filter-group{
display:flex;
flex-direction:column;
font-size:12px;
}

.filter-group label{
margin-bottom:5px;
font-weight:bold;
color:#555;
}

.filter-group input,
.filter-group select{
padding:8px;
border-radius:6px;
border:1px solid #ccc;
}

.reset-btn{
background:#e74c3c;
color:white;
padding:10px;
border-radius:6px;
text-align:center;
text-decoration:none;
font-size:13px;
}

/* TABLE */
.table-box{
overflow:auto;
}

table{
width:100%;
min-width:1300px;
border-collapse:collapse;
font-size:12px;
}

th,td{
padding:7px;
border:1px solid #ddd;
text-align:center;
white-space:nowrap;
}

th{
background:#2c5364;
color:white;
position:sticky;
top:0;
}

tr:nth-child(even){
background:#f9f9f9;
}

tr:hover{
background:#e8f5e9;
}

img{
width:60px;
border-radius:5px;
}

.btn{
padding:5px 10px;
border-radius:5px;
color:white;
text-decoration:none;
font-size:11px;
cursor:pointer;
}

.ai-box{
background:#fff;
padding:20px;
border-radius:12px;
margin-bottom:15px;
box-shadow:0 5px 15px rgba(0,0,0,.2);
}

.ai-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:15px;
}

.ai-card{
background:#eef7ff;
padding:15px;
border-radius:10px;
line-height:1.8;
}

.ai-title{
font-size:22px;
font-weight:bold;
color:#2c5364;
margin-bottom:15px;
}

.edit{background:#3498db;}
.hapus{background:#e74c3c;}
.export{background:#27ae60;}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
<h2>TPM SYSTEM</h2>
<a href="dashboard.php">🏠 Dashboard</a>
<a href="input_tpm_mesin.php">📝 Input TPM</a>
<a href="tabel_tpm.php">📋 Tabel TPM</a>
<a href="master_mesin.php" class="submenu">⚙ Master Mesin</a>
<a href="master_permasalahan.php" class="submenu">⚙ Master Permasalahan</a>
</div>

<div class="main">

<h2>DATA TPM MESIN</h2>

<div class="ai-box">

<div class="ai-title">
🤖 AI EVALUASI TPM EXTRUDER
</div>

<div class="ai-grid">

<div class="ai-card">

<h3>📅 Mingguan (7 Hari)</h3>

Total TPM :
<b><?= $week['total']; ?></b><br>

Breakdown :
<b><?= $week['breakdown']; ?></b><br>

Mesin Dominan :
<b><?= $mesin_week['mesin'] ?? '-'; ?></b><br>

Masalah Dominan :
<b><?= $problem_week['permasalahan'] ?? '-'; ?></b><br><br>

<b>🧠 Analisa AI</b><br>

Dalam 7 hari terakhir terjadi
<b><?= $week['total']; ?></b>
kejadian TPM.

Fokus perbaikan pada mesin
<b><?= $mesin_week['mesin'] ?? '-'; ?></b>

karena merupakan mesin dengan gangguan tertinggi.

</div>

<div class="ai-card">

<h3>📆 Bulanan (30 Hari)</h3>

Total TPM :
<b><?= $month['total']; ?></b><br>

Breakdown :
<b><?= $month['breakdown']; ?></b><br>

Mesin Dominan :
<b><?= $mesin_month['mesin'] ?? '-'; ?></b><br>

Masalah Dominan :
<b><?= $problem_month['permasalahan'] ?? '-'; ?></b><br><br>

<b>🧠 Analisa AI</b><br>

Dalam 30 hari terakhir terjadi
<b><?= $month['total']; ?></b>
kejadian TPM.

Masalah yang paling sering muncul adalah
<b><?= $problem_month['permasalahan'] ?? '-'; ?></b>.

Disarankan melakukan preventive maintenance
dan evaluasi akar masalah.

</div>

</div>

</div>

<!-- FILTER (ASLI) -->
<div class="card">
<form method="GET" id="filterForm">

<div class="filter-grid">

<div class="filter-group">
<label>Tanggal</label>
<input type="date" name="tanggal" value="<?= $tanggal ?>" onchange="autoSubmit()">
</div>

<div class="filter-group">
<label>Shift</label>
<select name="shift" onchange="autoSubmit()">
<option value="">Semua</option>
<option value="1" <?= $shift=='1'?'selected':'' ?>>Shift 1</option>
<option value="2" <?= $shift=='2'?'selected':'' ?>>Shift 2</option>
<option value="3" <?= $shift=='3'?'selected':'' ?>>Shift 3</option>
</select>
</div>

<div class="filter-group">
<label>Mesin</label>
<input type="text" name="mesin" value="<?= $mesin ?>" placeholder="Cari mesin..." onkeyup="autoSubmitDelay()">
</div>

<div class="filter-group">
<label>Kategori</label>
<select name="kategori" onchange="autoSubmit()">
<option value="">Semua</option>
<option value="Breakdown" <?= $kategori=='Breakdown'?'selected':'' ?>>Breakdown</option>
<option value="Kritis" <?= $kategori=='Kritis'?'selected':'' ?>>Kritis</option>
<option value="WO" <?= $kategori=='WO'?'selected':'' ?>>WO</option>
</select>
</div>

<div class="filter-group">
<label>&nbsp;</label>
<a href="tabel_tpm.php" class="reset-btn">Reset</a>
</div>

</div>

</form>
</div>

<!-- TAMBAHAN BUTTON -->
<div class="card">
<button onclick="hapusTerpilih()" class="btn hapus">🗑 Hapus Terpilih</button>
<a href="export_excel_tpm.php" class="btn export">⬇ Export Excel</a>
</div>

<!-- TABEL (ASLI + TAMBAHAN CHECKBOX) -->
<div class="card">
<div class="table-box">
<table>

<tr>
<th><input type="checkbox" onclick="toggleAll(this)"></th>
<th>No</th>
<th>Tanggal</th>
<th>Shift</th>
<th>Mesin</th>
<th>Kategori</th>
<th>Permasalahan</th>
<th>Detail</th>
<th>OFF</th>
<th>START</th>
<th>SELESAI</th>
<th>OFF→START</th>
<th>OFF→SELESAI</th>
<th>Perbaikan</th>
<th>Sparepart</th>
<th>Foto</th>
<th>Teknik</th>
<th>Produksi</th>
<th>Aksi</th>
</tr>

<?php
$no=1;
while($row = mysqli_fetch_assoc($data)){
$durasi1 = $row['durasi_off_start'] ?? "-";
$durasi2 = $row['durasi_off_selesai'] ?? "-";
?>

<tr>

<td><input type="checkbox" class="pilih" value="<?= $row['id']; ?>"></td>

<td><?= $no++; ?></td>
<td><?= $row['tanggal']; ?></td>
<td><?= $row['shift']; ?></td>
<td><?= $row['mesin']; ?></td>
<td><?= $row['kategori']; ?></td>
<td><?= $row['permasalahan']; ?></td>
<td><?= $row['permasalahan_detail']; ?></td>

<td><?= $row['jam_mesin_off']; ?></td>
<td><?= $row['jam_mesin_start']; ?></td>
<td><?= $row['jam_selesai_perbaikan']; ?></td>

<td><?= $durasi1; ?></td>
<td><?= $durasi2; ?></td>

<td><?= $row['perbaikan']; ?></td>
<td><?= $row['pergantian_sparepart']; ?></td>

<td>
<?php if($row['foto_sparepart']){ ?>
<img src="<?= $row['foto_sparepart']; ?>">
<?php } else { echo "-"; } ?>
</td>

<td><?= $row['pengecekan_teknik']; ?></td>
<td><?= $row['pengecekan_produksi']; ?></td>

<td>
<a href="edit_tpm.php?id=<?= $row['id']; ?>" class="btn edit">Edit</a>
<a href="tabel_tpm.php?hapus=<?= $row['id']; ?>" class="btn hapus" onclick="return confirm('Yakin hapus?')">Hapus</a>
</td>

</tr>

<?php } ?>

</table>
</div>
</div>

</div>

<!-- SCRIPT -->
<script>
function autoSubmit(){
document.getElementById("filterForm").submit();
}

let delay;
function autoSubmitDelay(){
clearTimeout(delay);
delay = setTimeout(()=>{
document.getElementById("filterForm").submit();
},400);
}

function toggleAll(source){
document.querySelectorAll('.pilih').forEach(cb => cb.checked = source.checked);
}

function hapusTerpilih(){
let selected=[];
document.querySelectorAll('.pilih:checked').forEach(cb=>{
selected.push(cb.value);
});

if(selected.length==0){
alert("Pilih data dulu!");
return;
}

let password = prompt("Masukkan password:");

if(password !== "admintpm"){
alert("Password salah!");
return;
}

if(confirm("Yakin hapus data terpilih?")){
window.location="tabel_tpm.php?hapus_massal="+selected.join(",");
}
}
</script>

</body>
</html>