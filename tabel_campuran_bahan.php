<?php
include "koneksi.php";

$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
$shift   = isset($_GET['shift']) ? $_GET['shift'] : '';

$where="WHERE 1=1";

if($tanggal!=''){
$where .= " AND tanggal='$tanggal'";
}

if($shift!=''){
$where .= " AND shift='$shift'";
}

$data=mysqli_query($koneksi,"SELECT * FROM campuran_bahan $where ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>

<title>Data Campuran Bahan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
font-family:arial;
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

table{
font-size:13px;
}

</style>

</head>

<body>

<div class="sidebar">

<h4 style="text-align:center">EXTRUDER</h4>

<a href="dashboard.php">Dashboard</a>
<a href="input_campur_bahan.php">Input Campuran Bahan</a>
<a href="tabel_campuran_bahan.php">Data Campuran Bahan</a>

</div>

<div class="content">

<h4>Data Campuran Bahan</h4>

<hr>

<form method="GET">

<div class="row">

<div class="col-md-3">
Tanggal
<input type="date" name="tanggal" class="form-control">
</div>

<div class="col-md-3">
Shift
<select name="shift" class="form-control">

<option value="">Semua Shift</option>
<option value="1">Shift 1</option>
<option value="2">Shift 2</option>
<option value="3">Shift 3</option>

</select>
</div>

<div class="col-md-3 mt-4">
<button class="btn btn-primary">Filter</button>
</div>

<div class="col-md-3 mt-4">
<a href="export_campuran_excel.php" class="btn btn-success">
Export Excel
</a>
</div>

</div>

</form>

<hr>

<form method="POST" action="hapus_campuran.php">

<button type="submit" class="btn btn-danger mb-3"
onclick="return confirm('Hapus data yang dipilih?')">
Hapus Dipilih
</button>

<table class="table table-bordered table-striped">

<tr class="table-dark">

<th>
<input type="checkbox" onclick="toggle(this)">
</th>

<th>No</th>
<th>Tanggal</th>
<th>Shift</th>
<th>Grup</th>
<th>Campuran PP</th>

<th>K1</th>
<th>B1</th>

<th>K2</th>
<th>B2</th>

<th>K3</th>
<th>B3</th>

<th>K4</th>
<th>B4</th>

<th>K5</th>
<th>B5</th>

<th>Stock Awal</th>
<th>Tambah</th>
<th>Total</th>

<th>Shift Pakai</th>
<th>Grup Pakai</th>

<th>Pakai</th>
<th>Stock Akhir</th>

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
<td><?php echo $d['grup_shift']; ?></td>

<td><?php echo $d['campuran_pp']; ?></td>

<td><?php echo $d['komposisi1']; ?></td>
<td><?php echo $d['berat1']; ?></td>

<td><?php echo $d['komposisi2']; ?></td>
<td><?php echo $d['berat2']; ?></td>

<td><?php echo $d['komposisi3']; ?></td>
<td><?php echo $d['berat3']; ?></td>

<td><?php echo $d['komposisi4']; ?></td>
<td><?php echo $d['berat4']; ?></td>

<td><?php echo $d['komposisi5']; ?></td>
<td><?php echo $d['berat5']; ?></td>

<td><?php echo $d['stock_awal']; ?></td>
<td><?php echo $d['tambah_stock']; ?></td>
<td><?php echo $d['jumlah_total']; ?></td>

<td><?php echo $d['shift_pemakaian']; ?></td>
<td><?php echo $d['grup_pemakaian']; ?></td>

<td><?php echo $d['pemakaian']; ?></td>

<td
<?php
if($d['stock_akhir']<0){
echo "style='background:red;color:white;'";
}
?>
>

<?php echo $d['stock_akhir']; ?>

</td>

<td>

<a href="edit_campuran.php?id=<?php echo $d['id']; ?>"
class="btn btn-warning btn-sm">Edit</a>

<a href="hapus_campuran.php?id=<?php echo $d['id']; ?>"
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

for(var i=0;i<checkboxes.length;i++)
checkboxes[i].checked = source.checked;

}

</script>

</body>
</html>