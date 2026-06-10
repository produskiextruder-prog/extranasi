<?php
include "koneksi.php";

$id = $_GET['id'];
$data = mysqli_query($koneksi,"SELECT * FROM campuran_bahan WHERE id='$id'");
$d = mysqli_fetch_array($data);

if(isset($_POST['update']))
{
    $tanggal = $_POST['tanggal'];
    $shift = $_POST['shift'];
    $grup_shift = $_POST['grup_shift'];
    $campuran_pp = $_POST['campuran_pp'];

    $komposisi1 = $_POST['komposisi1'];
    $berat1 = $_POST['berat1'];
    $komposisi2 = $_POST['komposisi2'];
    $berat2 = $_POST['berat2'];
    $komposisi3 = $_POST['komposisi3'];
    $berat3 = $_POST['berat3'];
    $komposisi4 = $_POST['komposisi4'];
    $berat4 = $_POST['berat4'];
    $komposisi5 = $_POST['komposisi5'];
    $berat5 = $_POST['berat5'];

    $stock_awal = $_POST['stock_awal'];
    $tambah_stock = $_POST['tambah_stock'];
    $pemakaian = $_POST['pemakaian'];
    $shift_pemakaian = $_POST['shift_pemakaian'];
    $grup_pemakaian = $_POST['grup_pemakaian'];

    // HITUNG OTOMATIS
    $jumlah_total = $stock_awal + $tambah_stock;
    $stock_akhir = $jumlah_total - $pemakaian;

    mysqli_query($koneksi,"UPDATE campuran_bahan SET
        tanggal='$tanggal',
        shift='$shift',
        grup_shift='$grup_shift',
        campuran_pp='$campuran_pp',
        komposisi1='$komposisi1', berat1='$berat1',
        komposisi2='$komposisi2', berat2='$berat2',
        komposisi3='$komposisi3', berat3='$berat3',
        komposisi4='$komposisi4', berat4='$berat4',
        komposisi5='$komposisi5', berat5='$berat5',
        stock_awal='$stock_awal',
        tambah_stock='$tambah_stock',
        jumlah_total='$jumlah_total',
        shift_pemakaian='$shift_pemakaian',
        grup_pemakaian='$grup_pemakaian',
        pemakaian='$pemakaian',
        stock_akhir='$stock_akhir'
        WHERE id='$id'");

    echo "<script>
    alert('Data berhasil diupdate');
    window.location='tabel_campuran_bahan.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Campuran Bahan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family:arial; background:#f4f6f9; }
.sidebar { position:fixed; width:220px; height:100%; background:#1f2d3d; color:white; padding-top:20px; }
.sidebar a { display:block; color:white; padding:12px; text-decoration:none; }
.sidebar a:hover { background:#007bff; }
.content { margin-left:240px; padding:30px; }
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
<div class="card p-4">
<h4>Edit Campuran Bahan</h4>

<form method="POST">
<div class="row">
<div class="col-md-3">
Tanggal
<input type="date" name="tanggal" class="form-control" value="<?php echo $d['tanggal']; ?>">
</div>
<div class="col-md-2">
Shift
<select name="shift" class="form-control">
<option <?php if($d['shift']=="1") echo "selected"; ?>>1</option>
<option <?php if($d['shift']=="2") echo "selected"; ?>>2</option>
<option <?php if($d['shift']=="3") echo "selected"; ?>>3</option>
</select>
</div>
<div class="col-md-2">
Grup Shift
<select name="grup_shift" class="form-control">
<option <?php if($d['grup_shift']=="A") echo "selected"; ?>>A</option>
<option <?php if($d['grup_shift']=="B") echo "selected"; ?>>B</option>
<option <?php if($d['grup_shift']=="C") echo "selected"; ?>>C</option>
</select>
</div>
<div class="col-md-3">
Campuran PP
<input type="text" name="campuran_pp" class="form-control" value="<?php echo $d['campuran_pp']; ?>">
</div>
</div>

<hr>
<h5>Komposisi Campuran</h5>
<table class="table table-bordered">
<tr>
<th>No</th>
<th>Komposisi</th>
<th>Berat</th>
</tr>
<?php for($i=1;$i<=5;$i++): ?>
<tr>
<td><?php echo $i; ?></td>
<td><input type="text" name="komposisi<?php echo $i; ?>" class="form-control" value="<?php echo $d['komposisi'.$i]; ?>"></td>
<td><input type="number" name="berat<?php echo $i; ?>" class="form-control" value="<?php echo $d['berat'.$i]; ?>"></td>
</tr>
<?php endfor; ?>
</table>

<hr>
<h5>Stock Bahan</h5>
<div class="row">
<div class="col-md-3">
Stock Awal
<input type="number" id="stock_awal" name="stock_awal" class="form-control" value="<?php echo $d['stock_awal']; ?>">
</div>
<div class="col-md-3">
Tambah Stock
<input type="number" id="tambah_stock" name="tambah_stock" class="form-control" value="<?php echo $d['tambah_stock']; ?>">
</div>
<div class="col-md-3">
Jumlah Total
<input type="number" id="jumlah_total" name="jumlah_total" class="form-control" value="<?php echo $d['jumlah_total']; ?>" readonly>
</div>
</div>

<br>
<div class="row">
<div class="col-md-3">
Pemakaian
<input type="number" id="pemakaian" name="pemakaian" class="form-control" value="<?php echo $d['pemakaian']; ?>">
</div>
<div class="col-md-3">
Stock Akhir
<input type="number" id="stock_akhir" name="stock_akhir" class="form-control" value="<?php echo $d['stock_akhir']; ?>" readonly>
</div>
</div>

<br>
<div class="row">
<div class="col-md-3">
Shift Pemakaian
<input type="text" name="shift_pemakaian" class="form-control" value="<?php echo $d['shift_pemakaian']; ?>">
</div>
<div class="col-md-3">
Grup Pemakaian
<input type="text" name="grup_pemakaian" class="form-control" value="<?php echo $d['grup_pemakaian']; ?>">
</div>
</div>

<br>
<button type="submit" name="update" class="btn btn-success">Update Data</button>
</form>
</div>
</div>

<script>
function hitungStock() {
    let stock_awal = parseFloat(document.getElementById('stock_awal').value) || 0;
    let tambah_stock = parseFloat(document.getElementById('tambah_stock').value) || 0;
    let pemakaian = parseFloat(document.getElementById('pemakaian').value) || 0;

    let jumlah_total = stock_awal + tambah_stock;
    let stock_akhir = jumlah_total - pemakaian;

    document.getElementById('jumlah_total').value = jumlah_total;
    document.getElementById('stock_akhir').value = stock_akhir;
}

// jalankan setiap input berubah
document.querySelectorAll('#stock_awal, #tambah_stock, #pemakaian').forEach(input => {
    input.addEventListener('input', hitungStock);
});

// hitung saat page load
window.onload = hitungStock;
</script>

</body>
</html>