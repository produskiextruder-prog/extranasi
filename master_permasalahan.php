<?php
include 'koneksi.php';

/* TAMBAH DATA */
if(isset($_POST['simpan'])){
    $nama = $_POST['nama_permasalahan'];
    mysqli_query($koneksi,"INSERT INTO master_permasalahan (nama_permasalahan) VALUES ('$nama')");
    header("Location: master_permasalahan.php");
}

/* HAPUS DATA */
if(isset($_GET['hapus'])){
    mysqli_query($koneksi,"DELETE FROM master_permasalahan WHERE id='$_GET[hapus]'");
    header("Location: master_permasalahan.php");
}

/* AMBIL DATA */
$data = mysqli_query($koneksi,"SELECT * FROM master_permasalahan ORDER BY nama_permasalahan ASC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Master Permasalahan</title>

<style>
body{
margin:0;
font-family:Arial;
background:linear-gradient(135deg,#1f4037,#99f2c8);
}

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

.main{
margin-left:240px;
padding:20px;
}

.box{
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,0.3);
}

input{
padding:8px;
width:250px;
}

button{
padding:8px 15px;
background:green;
color:white;
border:none;
cursor:pointer;
}

table{
width:100%;
margin-top:20px;
border-collapse:collapse;
}

table th, td{
border:1px solid #ccc;
padding:8px;
text-align:left;
}

.hapus{
color:red;
text-decoration:none;
}
</style>
</head>

<body>

<div class="sidebar">
<h2>TPM SYSTEM</h2>
<a href="dashboard.php">🏠 Dashboard</a>
<a href="input_tpm_mesin.php">📝 Input TPM</a>
<a href="tabel_tpm.php">📋 Tabel TPM</a>
<a href="master_mesin.php" class="submenu">⚙ Master Mesin</a>
<a href="master_permasalahan.php" class="submenu">⚙ Master Permasalahan</a>
</div>

<div class="main">
<div class="box">

<h2>Master Permasalahan</h2>

<form method="post">
<input type="text" name="nama_permasalahan" placeholder="Nama Permasalahan" required>
<button name="simpan">Simpan</button>
</form>

<table>
<tr>
<th>No</th>
<th>Nama Permasalahan</th>
<th>Aksi</th>
</tr>

<?php $no=1; while($d=mysqli_fetch_assoc($data)){ ?>
<tr>
<td><?php echo $no++; ?></td>
<td><?php echo $d['nama_permasalahan']; ?></td>
<td>
<a href="?hapus=<?php echo $d['id']; ?>" class="hapus" onclick="return confirm('Hapus data?')">Hapus</a>
</td>
</tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>