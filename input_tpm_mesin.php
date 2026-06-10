<?php
include 'koneksi.php';

/* ================================
   AMBIL DATA MASTER
================================ */
$qMesin = mysqli_query($koneksi,"SELECT nama_mesin FROM master_mesin ORDER BY nama_mesin ASC");
$qMasalah = mysqli_query($koneksi,"SELECT nama_permasalahan FROM master_permasalahan ORDER BY nama_permasalahan ASC");
?>

<!DOCTYPE html>
<html>
<head>

<title>Input TPM Mesin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body{
margin:0;
font-family:Arial;
background:linear-gradient(135deg,#1f4037,#99f2c8);
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

.submenu{
padding-left:35px;
font-size:13px;
}

.main-content{
margin-left:240px;
padding:20px;
}

.title{
text-align:center;
color:white;
}

.container{
display:flex;
justify-content:center;
margin-top:20px;
}

.form-box{
background:white;
width:750px;
border-radius:10px;
padding:20px;
box-shadow:0 10px 25px rgba(0,0,0,0.3);
}

.form-group{
display:grid;
grid-template-columns:220px 1fr;
align-items:center;
margin-bottom:12px;
border-bottom:1px solid #eee;
padding-bottom:8px;
}

label{
font-weight:bold;
font-size:13px;
}

input,select,textarea{
width:100%;
padding:8px;
border:1px solid #ccc;
border-radius:6px;
font-size:13px;
}

textarea{
resize:vertical;
}

.btn-group{
display:flex;
justify-content:center;
gap:15px;
margin-top:20px;
}

.btn-save{
padding:12px 25px;
border:none;
border-radius:8px;
background:#1faa2a;
color:white;
font-size:15px;
font-weight:bold;
cursor:pointer;
}

.btn-back{
padding:12px 25px;
background:#e53935;
color:white;
text-decoration:none;
border-radius:8px;
font-size:15px;
font-weight:bold;
}

.preview-img{
margin-top:10px;
max-width:150px;
display:none;
border-radius:6px;
}
</style>

</head>

<body>

<div class="sidebar">
<h2>TPM SYSTEM</h2>
<a href="dashboard.php">🏠 Dashboard</a>
<a href="input_tpm_mesin.php">📝 Input TPM</a>
<a href="tabel_tpm.php">📋 Tabel TPM</a>
<a href="master_mesin.php" class="submenu">⚙ Master Mesin</a>
<a href="master_permasalahan.php" class="submenu">⚙ Master Permasalahan</a>
</div>

<div class="main-content">

<div class="title">
<h2>INPUT DATA TPM</h2>
<p>Form Breakdown & Perbaikan Mesin</p>
</div>

<div class="container">
<div class="form-box">

<form method="post" action="simpan_tpm.php" enctype="multipart/form-data">

<!-- TANGGAL -->
<div class="form-group">
<label>Tanggal</label>
<input type="date" name="tanggal" required>
</div>

<!-- SHIFT -->
<div class="form-group">
<label>Shift</label>
<select name="shift" required>
<option value="">-- Pilih --</option>
<option value="1">Shift 1</option>
<option value="2">Shift 2</option>
<option value="3">Shift 3</option>
</select>
</div>

<!-- MESIN -->
<div class="form-group">
<label>Mesin</label>
<select name="mesin" required>
<option value="">-- Pilih Mesin --</option>
<?php 
while($m = mysqli_fetch_assoc($qMesin)){
?>
<option value="<?php echo $m['nama_mesin']; ?>">
<?php echo $m['nama_mesin']; ?>
</option>
<?php } ?>
</select>
</div>

<!-- KATEGORI -->
<div class="form-group">
<label>Kategori</label>
<select name="kategori">
<option value="Breakdown">Breakdown</option>
<option value="Kritis">Kritis</option>
<option value="WO">WO</option>
</select>
</div>

<!-- SECTION -->
<div class="form-group">
<label>Section</label>
<select name="permasalahan">
<option value="">-- Pilih --</option>
<?php 
while($p = mysqli_fetch_assoc($qMasalah)){
?>
<option value="<?php echo $p['nama_permasalahan']; ?>">
<?php echo $p['nama_permasalahan']; ?>
</option>
<?php } ?>
</select>
</div>

<!-- DETAIL -->
<div class="form-group">
<label>Detail Permasalahan</label>
<textarea name="permasalahan_detail"></textarea>
</div>

<!-- JAM -->
<div class="form-group">
<label>Jam Mesin OFF</label>
<input type="datetime-local" name="jam_mesin_off" id="jam_off" onchange="hitungDurasi()">
</div>

<div class="form-group">
<label>Jam Mesin START</label>
<input type="datetime-local" name="jam_mesin_start" id="jam_start" onchange="hitungDurasi()">
</div>

<div class="form-group">
<label>Jam Selesai</label>
<input type="datetime-local" name="jam_selesai_perbaikan" id="jam_selesai" onchange="hitungDurasi()">
</div>

<!-- DURASI -->
<div class="form-group">
<label>Durasi OFF → START</label>
<input type="text" id="durasi_off_start" readonly>
</div>

<div class="form-group">
<label>Durasi OFF → SELESAI</label>
<input type="text" id="durasi_off_selesai" readonly>
</div>

<!-- PERBAIKAN -->
<div class="form-group">
<label>Perbaikan</label>
<textarea name="perbaikan"></textarea>
</div>

<!-- SPAREPART -->
<div class="form-group">
<label>Pergantian Sparepart</label>
<textarea name="pergantian_sparepart"></textarea>
</div>

<!-- FOTO -->
<div class="form-group">
<label>Foto Sparepart</label>
<input type="file" name="foto_sparepart" accept="image/*" onchange="previewFoto(event)">
<img id="preview" class="preview-img">
</div>

<!-- CEK -->
<div class="form-group">
<label>Pengecekan Teknik</label>
<select name="pengecekan_teknik">
<option value="OK">OK</option>
<option value="NO">NO</option>
</select>
</div>

<div class="form-group">
<label>Pengecekan Produksi</label>
<select name="pengecekan_produksi">
<option value="OK">OK</option>
<option value="NO">NO</option>
</select>
</div>

<div class="btn-group">
<button type="submit" class="btn-save">💾 SIMPAN</button>
<a href="dashboard.php" class="btn-back">⬅ Kembali</a>
</div>

</form>

</div>
</div>
</div>

<!-- SCRIPT -->
<script>

// PREVIEW FOTO
function previewFoto(event){
let reader = new FileReader();
reader.onload = function(){
let img = document.getElementById('preview');
img.src = reader.result;
img.style.display = 'block';
}
reader.readAsDataURL(event.target.files[0]);
}

// HITUNG DURASI
function hitungDurasi(){

let off = document.getElementById("jam_off").value;
let start = document.getElementById("jam_start").value;
let selesai = document.getElementById("jam_selesai").value;

// OFF → START
if(off && start){
    let t1 = new Date(off);
    let t2 = new Date(start);
    let diff = (t2 - t1) / 1000;

    if(diff >= 0){
        let jam = Math.floor(diff / 3600);
        let menit = Math.floor((diff % 3600) / 60);
        document.getElementById("durasi_off_start").value = jam + " jam " + menit + " menit";
    }
}

// OFF → SELESAI
if(off && selesai){
    let t1 = new Date(off);
    let t3 = new Date(selesai);
    let diff2 = (t3 - t1) / 1000;

    if(diff2 >= 0){
        let jam = Math.floor(diff2 / 3600);
        let menit = Math.floor((diff2 % 3600) / 60);
        document.getElementById("durasi_off_selesai").value = jam + " jam " + menit + " menit";
    }
}

}
</script>

</body>
</html>