<?php
include 'koneksi.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=DATA_TPM_LENGKAP.xls");

/* ================================
   AMBIL DATA
================================ */
$data = mysqli_query($koneksi, "SELECT * FROM input_tpm ORDER BY id DESC");

/* ================================
   HEADER TABEL
================================ */
echo "<table border='1'>";
echo "<tr>
<th>No</th>
<th>Tanggal</th>
<th>Shift</th>
<th>Mesin</th>
<th>Kategori</th>
<th>Permasalahan</th>
<th>Detail</th>
<th>Jam OFF</th>
<th>Jam START</th>
<th>Jam SELESAI</th>
<th>Durasi OFF → START (Menit)</th>
<th>Durasi OFF → SELESAI (Menit)</th>
<th>Perbaikan</th>
<th>Pergantian Sparepart</th>
<th>Foto</th>
<th>Pengecekan Teknik</th>
<th>Pengecekan Produksi</th>
<th>Waktu Input</th>
</tr>";

/* ================================
   ISI DATA
================================ */
$no = 1;
while($row = mysqli_fetch_assoc($data)){

$durasi1 = $row['durasi_off_start'] ?? "-";
$durasi2 = $row['durasi_off_selesai'] ?? "-";

echo "<tr>
<td>{$no}</td>
<td>{$row['tanggal']}</td>
<td>{$row['shift']}</td>
<td>{$row['mesin']}</td>
<td>{$row['kategori']}</td>
<td>{$row['permasalahan']}</td>
<td>{$row['permasalahan_detail']}</td>
<td>{$row['jam_mesin_off']}</td>
<td>{$row['jam_mesin_start']}</td>
<td>{$row['jam_selesai_perbaikan']}</td>
<td>{$durasi1}</td>
<td>{$durasi2}</td>
<td>{$row['perbaikan']}</td>
<td>{$row['pergantian_sparepart']}</td>
<td>{$row['foto_sparepart']}</td>
<td>{$row['pengecekan_teknik']}</td>
<td>{$row['pengecekan_produksi']}</td>
<td>{$row['created_at']}</td>
</tr>";

$no++;
}

echo "</table>";
?>