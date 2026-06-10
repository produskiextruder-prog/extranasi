<?php
include "koneksi.php";

if(isset($_POST['simpan'])){

    $tanggal  = $_POST['tanggal'];
    $shift    = $_POST['shift'];
    $penyebab = $_POST['penyebab'];
    $stop     = $_POST['stop_mesin'];
    $start    = $_POST['start_mesin'];

    // Hitung durasi
    $time_stop  = strtotime($stop);
    $time_start = strtotime($start);

    $durasi = ($time_start - $time_stop) / 60;

    if($durasi < 0){
        $durasi = 0;
    }

    mysqli_query($koneksi, "
        INSERT INTO shutdown_mesin
        (tanggal, shift, penyebab, stop_mesin, start_mesin, durasi)
        VALUES
        ('$tanggal', '$shift', '$penyebab', '$stop', '$start', '$durasi')
    ");

    echo "<script>alert('Data berhasil disimpan');window.location='input_shutdown.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Input Shutdown Mesin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    font-family:arial;
    background:#f4f6f9;
}

/* SIDEBAR */
.sidebar{
    position:fixed;
    width:220px;
    height:100%;
    background:#1f2d3d;
    color:white;
    padding-top:20px;
}

.sidebar h4{
    text-align:center;
    margin-bottom:20px;
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

/* CONTENT */
.content{
    margin-left:240px;
    padding:30px;
}

.card{
    max-width:700px;
}

</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

<h4>EXTRUDER</h4>

<a href="dashboard.php">Dashboard</a>
<a href="input_shutdown.php">Input Shutdown Mesin</a>
<a href="tabel_shutdown.php">Tabel Shutdown Mesin</a>

</div>

<!-- CONTENT -->
<div class="content">

<div class="card shadow">

<div class="card-header bg-danger text-white">
<h4 class="mb-0">Input Shutdown Mesin</h4>
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>Tanggal</label>
<input type="date" name="tanggal" class="form-control" required>
</div>

<div class="mb-3">
<label>Shift</label>
<select name="shift" class="form-control" required>
<option value="">-- Pilih Shift --</option>
<option value="1">Shift 1</option>
<option value="2">Shift 2</option>
<option value="3">Shift 3</option>
</select>
</div>

<div class="mb-3">
<label>Penyebab Shutdown</label>
<input type="text" name="penyebab" class="form-control" required>
</div>

<div class="mb-3">
<label>Stop Mesin</label>
<input type="datetime-local" name="stop_mesin" class="form-control" required>
</div>

<div class="mb-3">
<label>Start Mesin</label>
<input type="datetime-local" name="start_mesin" class="form-control" required>
</div>

<div class="mb-3">
<label>Durasi (menit)</label>
<input type="text" id="durasi" class="form-control" readonly>
</div>

<button type="submit" name="simpan" class="btn btn-danger">
Simpan
</button>

<a href="dashboard.php" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

</div>

</div>

<script>
const stopInput  = document.querySelector('[name="stop_mesin"]');
const startInput = document.querySelector('[name="start_mesin"]');
const durasiBox  = document.getElementById('durasi');

function hitungDurasi(){
    if(stopInput.value && startInput.value){

        let stop  = new Date(stopInput.value);
        let start = new Date(startInput.value);

        let selisih = (start - stop) / 1000 / 60;

        if(selisih >= 0){
            durasiBox.value = selisih + " menit";
        }else{
            durasiBox.value = "Waktu tidak valid";
        }
    }
}

stopInput.addEventListener('change', hitungDurasi);
startInput.addEventListener('change', hitungDurasi);
</script>

</body>
</html>