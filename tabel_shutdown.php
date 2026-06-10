<?php
include "koneksi.php";

// FILTER
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
$shift   = isset($_GET['shift']) ? $_GET['shift'] : '';

$where = "WHERE 1=1";

if($tanggal != ''){
    $where .= " AND tanggal='$tanggal'";
}

if($shift != ''){
    $where .= " AND shift='$shift'";
}

// AMBIL DATA
$data = mysqli_query($koneksi, "SELECT * FROM shutdown_mesin $where ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>

<title>Tabel Shutdown Mesin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{ font-family:arial; background:#f4f6f9; }

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

.table td, .table th{
    text-align:center;
    vertical-align:middle;
}
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
<h4 style="text-align:center">EXTRUDER</h4>
<a href="dashboard.php">Dashboard</a>
<a href="input_shutdown.php">Input Shutdown Mesin</a>
<a href="tabel_shutdown.php">Tabel Shutdown Mesin</a>
</div>

<!-- CONTENT -->
<div class="content">

<h4>Data Shutdown Mesin</h4>
<hr>

<!-- FILTER -->
<form method="GET">

<div class="row">

<div class="col-md-3">
Tanggal
<input type="date" name="tanggal" class="form-control"
value="<?php echo $tanggal; ?>">
</div>

<div class="col-md-3">
Shift
<select name="shift" class="form-control">
<option value="">Semua</option>
<option value="1" <?php if($shift=='1') echo 'selected'; ?>>Shift 1</option>
<option value="2" <?php if($shift=='2') echo 'selected'; ?>>Shift 2</option>
<option value="3" <?php if($shift=='3') echo 'selected'; ?>>Shift 3</option>
</select>
</div>

<div class="col-md-3 mt-4">
<button class="btn btn-primary">Filter</button>
</div>

<div class="col-md-3 mt-4">
<a href="export_shutdown.php?tanggal=<?php echo $tanggal; ?>&shift=<?php echo $shift; ?>" 
class="btn btn-success w-100">
Export Excel
</a>
</div>

</div>

</form>

<hr>

<!-- FORM HAPUS BANYAK -->
<form method="POST" action="hapus_shutdown.php">

<button type="submit" class="btn btn-danger mb-3"
onclick="return confirm('Hapus data yang dipilih?')">
Hapus Dipilih
</button>

<table class="table table-bordered table-striped">

<tr class="table-dark">
<th><input type="checkbox" onclick="toggle(this)"></th>
<th>No</th>
<th>Tanggal</th>
<th>Shift</th>
<th>Penyebab</th>
<th>Stop</th>
<th>Start</th>
<th>Durasi (menit)</th>
<th>Aksi</th>
</tr>

<?php
$no=1;
while($d=mysqli_fetch_array($data)){
?>

<tr>

<td>
<input type="checkbox" name="hapus[]" value="<?php echo $d['id']; ?>">
</td>

<td><?php echo $no++; ?></td>
<td><?php echo $d['tanggal']; ?></td>
<td><?php echo $d['shift']; ?></td>
<td><?php echo $d['penyebab']; ?></td>
<td><?php echo $d['stop_mesin']; ?></td>
<td><?php echo $d['start_mesin']; ?></td>
<td><?php echo $d['durasi']; ?></td>

<td>

<a href="edit_shutdown.php?id=<?php echo $d['id']; ?>"
class="btn btn-warning btn-sm">Edit</a>

<a href="hapus_shutdown.php?id=<?php echo $d['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Hapus data?')">
Hapus
</a>

</td>

</tr>

<?php } ?>

</table>

</form>

</div>

<script>
function toggle(source) {
    checkboxes = document.getElementsByName('hapus[]');
    for(var i=0;i<checkboxes.length;i++){
        checkboxes[i].checked = source.checked;
    }
}
</script>

</body>
</html>