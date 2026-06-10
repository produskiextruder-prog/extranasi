<?php
include "koneksi.php";

// WAJIB: tidak boleh ada spasi sebelum ini
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_campuran_bahan.xls");

// Ambil filter (biar sama dengan tabel)
$tanggal     = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
$shift       = isset($_GET['shift']) ? $_GET['shift'] : '';
$grup        = isset($_GET['grup']) ? $_GET['grup'] : '';
$campuran_pp = isset($_GET['campuran_pp']) ? $_GET['campuran_pp'] : '';

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

// Query
$data = mysqli_query($koneksi, "SELECT * FROM campuran_bahan $where ORDER BY id DESC");

// Output tabel
echo "<table border='1'>";

echo "
<tr>
<th>No</th>
<th>Tanggal</th>
<th>Shift</th>
<th>Grup Shift</th>
<th>Campuran PP</th>

<th>Komposisi 1</th>
<th>Berat 1</th>

<th>Komposisi 2</th>
<th>Berat 2</th>

<th>Komposisi 3</th>
<th>Berat 3</th>

<th>Komposisi 4</th>
<th>Berat 4</th>

<th>Komposisi 5</th>
<th>Berat 5</th>

<th>Stock Awal</th>
<th>Tambah Stock</th>
<th>Total Stock</th>

<th>Shift Pemakaian</th>
<th>Grup Pemakaian</th>

<th>Pemakaian</th>
<th>Stock Akhir</th>
</tr>
";

$no = 1;

while($d = mysqli_fetch_array($data)){

echo "<tr>
<td>".$no++."</td>
<td>".$d['tanggal']."</td>
<td>".$d['shift']."</td>
<td>".$d['grup_shift']."</td>
<td>".$d['campuran_pp']."</td>

<td>".$d['komposisi1']."</td>
<td>".$d['berat1']."</td>

<td>".$d['komposisi2']."</td>
<td>".$d['berat2']."</td>

<td>".$d['komposisi3']."</td>
<td>".$d['berat3']."</td>

<td>".$d['komposisi4']."</td>
<td>".$d['berat4']."</td>

<td>".$d['komposisi5']."</td>
<td>".$d['berat5']."</td>

<td>".$d['stock_awal']."</td>
<td>".$d['tambah_stock']."</td>
<td>".$d['jumlah_total']."</td>

<td>".$d['shift_pemakaian']."</td>
<td>".$d['grup_pemakaian']."</td>

<td>".$d['pemakaian']."</td>
<td>".$d['stock_akhir']."</td>
</tr>";

}

echo "</table>";
exit;
?>