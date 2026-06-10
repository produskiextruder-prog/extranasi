<?php
include "koneksi.php";

$id = $_GET['id'];
$data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM shutdown_mesin WHERE id='$id'"));

if(isset($_POST['update'])){

$tanggal  = $_POST['tanggal'];
$shift    = $_POST['shift'];
$penyebab = $_POST['penyebab'];
$stop     = $_POST['stop_mesin'];
$start    = $_POST['start_mesin'];

// Hitung durasi
$durasi = (strtotime($start) - strtotime($stop)) / 60;

if($durasi < 0){
    $durasi = 0;
}

mysqli_query($koneksi,"UPDATE shutdown_mesin SET
tanggal='$tanggal',
shift='$shift',
penyebab='$penyebab',
stop_mesin='$stop',
start_mesin='$start',
durasi='$durasi'
WHERE id='$id'");

echo "<script>alert('Data berhasil diupdate');window.location='tabel_shutdown.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Shutdown Mesin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    font-family:arial;
    background:#f4f6f9;
}

/* CENTER FORM */
.wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.card{
    width:500px;
}
</style>

</head>

<body>

<div class="wrapper">

<div class="card shadow">

<div class="card-header bg-warning text-center">
<h4 class="mb-0">Edit Data Shutdown</h4>
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>Tanggal</label>
<input type="date" name="tanggal" class="form-control"
value="<?php echo $data['tanggal']; ?>" required>
</div>

<div class="mb-3">
<label>Shift</label>
<select name="shift" class="form-control" required>
<option value="1" <?php if($data['shift']==1) echo 'selected'; ?>>Shift 1</option>
<option value="2" <?php if($data['shift']==2) echo 'selected'; ?>>Shift 2</option>
<option value="3" <?php if($data['shift']==3) echo 'selected'; ?>>Shift 3</option>
</select>
</div>

<div class="mb-3">
<label>Penyebab Shutdown</label>
<input type="text" name="penyebab" class="form-control"
value="<?php echo $data['penyebab']; ?>" required>
</div>

<div class="mb-3">
<label>Stop Mesin</label>
<input type="datetime-local" name="stop_mesin" class="form-control"
value="<?php echo date('Y-m-d\TH:i', strtotime($data['stop_mesin'])); ?>" required>
</div>

<div class="mb-3">
<label>Start Mesin</label>
<input type="datetime-local" name="start_mesin" class="form-control"
value="<?php echo date('Y-m-d\TH:i', strtotime($data['start_mesin'])); ?>" required>
</div>

<div class="mb-3">
<label>Durasi (menit)</label>
<input type="text" id="durasi" class="form-control" readonly>
</div>

<div class="d-flex justify-content-between">
<button type="submit" name="update" class="btn btn-warning">
Update
</button>

<a href="tabel_shutdown.php" class="btn btn-secondary">
Kembali
</a>
</div>

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

// Hitung saat pertama load
window.onload = hitungDurasi;

stopInput.addEventListener('change', hitungDurasi);
startInput.addEventListener('change', hitungDurasi);
</script>

</body>
</html>