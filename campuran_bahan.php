<?php
include "koneksi.php";

// Ambil filter
$tanggal     = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
$shift       = isset($_GET['shift']) ? $_GET['shift'] : '';
$grup        = isset($_GET['grup']) ? $_GET['grup'] : '';
$campuran_pp = isset($_GET['campuran_pp']) ? $_GET['campuran_pp'] : '';

// Query dinamis
$where = "WHERE 1=1";

if($tanggal != ''){
    $where .= " AND tanggal='$tanggal'";
}

if($shift != ''){
    $where .= " AND shift='$shift'";
}

if($grup != ''){
    $where .= " AND grup_shift='$grup'";
}

if($campuran_pp != ''){
    $where .= " AND campuran_pp LIKE '%$campuran_pp%'";
}

// Ambil data
$data = mysqli_query($koneksi, "SELECT * FROM campuran_bahan $where ORDER BY id DESC");
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

.container{
    margin-top:30px;
    max-width:1300px;
}

/* Center tabel */
.table-center{
    margin-left:auto;
    margin-right:auto;
}

.table-center th,
.table-center td{
    text-align:center;
    vertical-align:middle;
}
</style>

</head>

<body>

<div class="container">

<h4 class="text">Monitoring Campuran Bahan</h4>
<hr>

<!-- FORM FILTER -->
<form method="GET">

<div class="row">

<div class="col-md-3">
Tanggal
<input type="date" name="tanggal" class="form-control"
value="<?php echo $tanggal; ?>">
</div>

<div class="col-md-2">
Shift
<select name="shift" class="form-control">
<option value="">Semua</option>
<option value="1" <?php if($shift=='1') echo 'selected'; ?>>Shift 1</option>
<option value="2" <?php if($shift=='2') echo 'selected'; ?>>Shift 2</option>
<option value="3" <?php if($shift=='3') echo 'selected'; ?>>Shift 3</option>
</select>
</div>

<div class="col-md-2">
Grup
<input type="text" name="grup" class="form-control"
placeholder="Grup"
value="<?php echo $grup; ?>">
</div>

<div class="col-md-3">
Campuran PP
<input type="text" name="campuran_pp" class="form-control"
placeholder="Cari Campuran"
value="<?php echo $campuran_pp; ?>">
</div>

<div class="col-md-2 mt-4">
<button class="btn btn-primary w-100">Filter</button>
</div>

</div>

</form>

<hr>

<!-- TABEL -->
<div class="table-responsive">

<table class="table table-bordered table-striped table-center">

<tr class="table-dark">
<th>No</th>
<th>Tanggal</th>
<th>Shift</th>
<th>Grup</th>
<th>Campuran PP</th>
<th>Stock Awal</th>
<th>Tambah</th>
<th>Total</th>
<th>Shift Pakai</th>
<th>Grup Pakai</th>
<th>Pakai</th>
<th>Stock Akhir</th>
</tr>

<?php
$no = 1;

while($d = mysqli_fetch_array($data)){
?>

<tr>

<td><?php echo $no++; ?></td>
<td><?php echo $d['tanggal']; ?></td>
<td><?php echo $d['shift']; ?></td>
<td><?php echo $d['grup_shift']; ?></td>
<td><?php echo $d['campuran_pp']; ?></td>

<td><?php echo $d['stock_awal']; ?></td>
<td><?php echo $d['tambah_stock']; ?></td>
<td><?php echo $d['jumlah_total']; ?></td>

<td><?php echo $d['shift_pemakaian']; ?></td>
<td><?php echo $d['grup_pemakaian']; ?></td>
<td><?php echo $d['pemakaian']; ?></td>

<td
<?php
if($d['stock_akhir'] < 0){
    echo "style='background:red;color:white;'";
}
?>
>
<?php echo $d['stock_akhir']; ?>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>