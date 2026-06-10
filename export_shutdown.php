<?php
include "koneksi.php";

// Header Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_shutdown_mesin.xls");

// Ambil filter
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
$shift   = isset($_GET['shift']) ? $_GET['shift'] : '';

$where = "WHERE 1=1";

if($tanggal != ''){
    $where .= " AND tanggal='$tanggal'";
}

if($shift != ''){
    $where .= " AND shift='$shift'";
}

// Query
$data = mysqli_query($koneksi, "SELECT * FROM shutdown_mesin $where ORDER BY id DESC");

// Output tabel
echo "<table border='1'>";

echo "
<tr>
<th>No</th>
<th>Tanggal</th>
<th>Shift</th>
<th>Penyebab</th>
<th>Stop</th>
<th>Start</th>
<th>Durasi (menit)</th>
</tr>
";

$no = 1;

while($d = mysqli_fetch_array($data)){

echo "<tr>
<td>".$no++."</td>
<td>".$d['tanggal']."</td>
<td>".$d['shift']."</td>
<td>".$d['penyebab']."</td>
<td>".$d['stop_mesin']."</td>
<td>".$d['start_mesin']."</td>
<td>".$d['durasi']."</td>
</tr>";

}

echo "</table>";
exit;
?>