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

// TOTAL
$total_shutdown = 0;
$total_durasi = 0;

$q = mysqli_query($koneksi,"SELECT * FROM shutdown_mesin $where");

while($d=mysqli_fetch_array($q)){
    $total_shutdown++;
    $total_durasi += $d['durasi'];
}

// GRAFIK DURASI PER HARI
$g1 = mysqli_query($koneksi,"
SELECT tanggal, SUM(durasi) as total
FROM shutdown_mesin $where
GROUP BY tanggal ORDER BY tanggal
");

$tgl = [];
$durasi = [];

while($r=mysqli_fetch_array($g1)){
    $tgl[] = $r['tanggal'];
    $durasi[] = $r['total'];
}

// PARETO DURASI
$g2 = mysqli_query($koneksi,"
SELECT penyebab, SUM(durasi) as total
FROM shutdown_mesin $where
GROUP BY penyebab
ORDER BY total DESC
");

$penyebab1 = [];
$total1 = [];

while($r=mysqli_fetch_array($g2)){
    $penyebab1[] = $r['penyebab'];
    $total1[] = $r['total'];
}

// PARETO FREKUENSI
$g3 = mysqli_query($koneksi,"
SELECT penyebab, COUNT(*) as jumlah
FROM shutdown_mesin $where
GROUP BY penyebab
ORDER BY jumlah DESC
");

$penyebab2 = [];
$jumlah2 = [];

while($r=mysqli_fetch_array($g3)){
    $penyebab2[] = $r['penyebab'];
    $jumlah2[] = $r['jumlah'];
}

// DATA TABEL
$data = mysqli_query($koneksi,"SELECT * FROM shutdown_mesin $where ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>

<title>Monitoring Shutdown Mesin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body{
    background:#f4f6f9;
    font-family:arial;
}

.container{
    margin-top:30px;
    max-width:1300px;
}

.table th, .table td{
    text-align:center;
    vertical-align:middle;
}
</style>

</head>

<body>

<div class="container">

<h3 class="text-center">Monitoring Shutdown Mesin</h3>
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

</div>
</form>

<hr>

<!-- TABEL -->
<div class="card">
<div class="card-header">Data Shutdown Mesin</div>
<div class="card-body table-responsive">

<table class="table table-bordered table-striped">

<tr class="table-dark">
<th>No</th>
<th>Tanggal</th>
<th>Shift</th>
<th>Penyebab</th>
<th>Stop</th>
<th>Start</th>
<th>Durasi (menit)</th>
</tr>

<?php $no=1; while($d=mysqli_fetch_array($data)){ ?>
<tr>
<td><?php echo $no++; ?></td>
<td><?php echo $d['tanggal']; ?></td>
<td><?php echo $d['shift']; ?></td>
<td><?php echo $d['penyebab']; ?></td>
<td><?php echo $d['stop_mesin']; ?></td>
<td><?php echo $d['start_mesin']; ?></td>
<td><?php echo $d['durasi']; ?></td>
</tr>
<?php } ?>

</table>

</div>
</div>

<!-- SUMMARY -->
<div class="row mt-3">

<div class="col-md-6">
<div class="card bg-danger text-white">
<div class="card-body text-center">
<h5>Total Shutdown</h5>
<h2><?php echo $total_shutdown; ?></h2>
</div>
</div>
</div>

<div class="col-md-6">
<div class="card bg-primary text-white">
<div class="card-body text-center">
<h5>Total Durasi (Menit)</h5>
<h2><?php echo $total_durasi; ?></h2>
</div>
</div>
</div>

</div>

<!-- GRAFIK -->
<div class="card mt-4">
<div class="card-header">Durasi Shutdown per Hari</div>
<div class="card-body">
<canvas id="g1"></canvas>
</div>
</div>

<div class="card mt-4">
<div class="card-header">Pareto Durasi Shutdown</div>
<div class="card-body">
<canvas id="g2"></canvas>
</div>
</div>

<div class="card mt-4">
<div class="card-header">Pareto Frekuensi Shutdown</div>
<div class="card-body">
<canvas id="g3"></canvas>
</div>
</div>

</div>

<script>

// STYLE UMUM
const optionsUmum = {
    responsive: true,
    plugins: {
        legend: {
            labels: {
                font: { size: 14, weight: 'bold' }
            }
        },
        tooltip: {
            callbacks: {
                label: function(context){
                    return context.dataset.label + ": " + context.raw + " menit";
                }
            }
        }
    },
    scales: {
        x: {
            ticks: { font: { size: 12 } },
            grid: { display: false }
        },
        y: {
            ticks: { font: { size: 12 } },
            grid: { color: "#ddd" }
        }
    }
};

// GRAFIK 1
new Chart(document.getElementById("g1"),{
    type:'bar',
    data:{
        labels:<?php echo json_encode($tgl); ?>,
        datasets:[{
            label:'Durasi',
            data:<?php echo json_encode($durasi); ?>,
            backgroundColor:'rgba(0,123,255,0.9)',
            borderColor:'#003f7f',
            borderWidth:2
        }]
    },
    options: optionsUmum
});

// GRAFIK 2
new Chart(document.getElementById("g2"),{
    type:'bar',
    data:{
        labels:<?php echo json_encode($penyebab1); ?>,
        datasets:[{
            label:'Durasi',
            data:<?php echo json_encode($total1); ?>,
            backgroundColor:'rgba(220,53,69,0.9)',
            borderColor:'#7a0c1c',
            borderWidth:2
        }]
    },
    options: optionsUmum
});

// GRAFIK 3
new Chart(document.getElementById("g3"),{
    type:'bar',
    data:{
        labels:<?php echo json_encode($penyebab2); ?>,
        datasets:[{
            label:'Frekuensi',
            data:<?php echo json_encode($jumlah2); ?>,
            backgroundColor:'rgba(40,167,69,0.9)',
            borderColor:'#145c2b',
            borderWidth:2
        }]
    },
    options: optionsUmum
});

</script>

</body>
</html>