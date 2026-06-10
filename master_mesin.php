<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

/* =========================
   TAMBAH DATA
========================= */
if(isset($_POST['simpan'])){
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_mesin']);

    if($nama != ""){
        $insert = mysqli_query($koneksi,"INSERT INTO master_mesin (nama_mesin) VALUES ('$nama')");

        if(!$insert){
            die("Gagal simpan: " . mysqli_error($koneksi));
        }

        header("Location: master_mesin.php");
        exit;
    }
}

/* =========================
   HAPUS DATA
========================= */
if(isset($_GET['hapus'])){
    $id = intval($_GET['hapus']);

    $delete = mysqli_query($koneksi,"DELETE FROM master_mesin WHERE id='$id'");

    if(!$delete){
        die("Gagal hapus: " . mysqli_error($koneksi));
    }

    header("Location: master_mesin.php");
    exit;
}

/* =========================
   AMBIL DATA
========================= */
$data = mysqli_query($koneksi,"SELECT * FROM master_mesin ORDER BY nama_mesin ASC");

if(!$data){
    die("Query Error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Master Mesin</title>

<style>
body{
margin:0;
font-family:Arial;
background:linear-gradient(135deg,#1f4037,#99f2c8);
}

/* SIDEBAR */
.sidebar{
position:fixed;
left:0;
top:0;
width:240px;
height:100%;
background:linear-gradient(180deg,#0f2027,#2c5364);
padding-top:20px;
box-shadow:3px 0 10px rgba(0,0,0,0.4);
overflow:auto;
}

.sidebar h2{
color:white;
text-align:center;
margin-bottom:30px;
font-size:20px;
}

.sidebar a{
display:block;
color:white;
padding:12px 20px;
text-decoration:none;
font-size:14px;
transition:0.3s;
}

.sidebar a:hover{
background:rgba(255,255,255,0.1);
padding-left:28px;
}

.sidebar a:hover{
background:#1f4037;
}

/* CONTENT */
.main{
margin-left:240px;
padding:20px;
}

/* BOX */
.box{
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,0.3);
}

/* FORM */
input{
padding:10px;
width:250px;
border-radius:6px;
border:1px solid #ccc;
}

button{
padding:10px 20px;
background:#1faa2a;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
}

button:hover{
background:#178f22;
}

/* TABLE */
table{
width:100%;
margin-top:20px;
border-collapse:collapse;
}

table th, td{
border:1px solid #ccc;
padding:10px;
text-align:left;
}

th{
background:#f0f0f0;
}

.hapus{
color:red;
text-decoration:none;
font-weight:bold;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
<h2>TPM SYSTEM</h2>
<a href="dashboard.php">🏠 Dashboard</a>
<a href="input_tpm_mesin.php">📝 Input TPM</a>
<a href="tabel_tpm.php">📋 Tabel TPM</a>
<a href="master_mesin.php">⚙ Master Mesin</a>
<a href="master_permasalahan.php">⚙ Master Permasalahan</a>
</div>

<!-- CONTENT -->
<div class="main">
<div class="box">

<h2>Master Mesin</h2>

<!-- FORM INPUT -->
<form method="post">
<input type="text" name="nama_mesin" placeholder="Masukkan Nama Mesin" required>
<button type="submit" name="simpan">Simpan</button>
</form>

<!-- TABEL -->
<table>
<tr>
<th width="50">No</th>
<th>Nama Mesin</th>
<th width="100">Aksi</th>
</tr>

<?php 
if(mysqli_num_rows($data) > 0){
    $no = 1;
    while($d = mysqli_fetch_assoc($data)){
?>

<tr>
<td><?php echo $no++; ?></td>
<td><?php echo htmlspecialchars($d['nama_mesin']); ?></td>
<td>
<a href="?hapus=<?php echo $d['id']; ?>" 
class="hapus" 
onclick="return confirm('Yakin hapus data ini?')">
Hapus
</a>
</td>
</tr>

<?php 
    }
} else {
?>
<tr>
<td colspan="3" style="text-align:center;">Data belum ada</td>
</tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>