<?php
session_start();
include 'koneksi.php';

/* =========================
   LOGIN SETTING
========================= */
$admin_user = "digital brs";
$admin_pass = "123456789";

/* =========================
   PROSES LOGIN
========================= */
if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if($user === $admin_user && $pass === $admin_pass){
        $_SESSION['admin_tpm'] = true;
        header("Location: admin_master.php");
        exit;
    }else{
        $error = "Username atau Password salah!";
    }
}

/* =========================
   LOGOUT
========================= */
if(isset($_GET['logout'])){
    session_destroy();
    header("Location: admin_master.php");
    exit;
}

/* =========================
   CEK SESSION (LOGIN PAGE)
========================= */
if(!isset($_SESSION['admin_tpm'])):
?>
<!DOCTYPE html>
<html>
<head>
<title>Login Admin TPM</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:Arial, Helvetica, sans-serif;
    background:linear-gradient(135deg,#1d4350,#a43931);
}
.login-box{
    background:white;
    padding:30px;
    border-radius:15px;
    width:320px;
    box-shadow:0 10px 25px rgba(0,0,0,0.4);
}
h2{text-align:center;margin-bottom:20px;}
input{
    width:100%;
    padding:12px;
    margin-bottom:12px;
    border-radius:8px;
    border:1px solid #ccc;
}
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#007bff;
    color:white;
    font-weight:bold;
}
.error{
    color:red;
    text-align:center;
    margin-bottom:10px;
}
.back-btn{
    display:block;
    margin-top:15px;
    text-align:center;
    text-decoration:none;
    padding:12px;
    border-radius:8px;
    background:linear-gradient(135deg,#ff416c,#ff4b2b);
    color:white;
    font-weight:bold;
}
</style>
</head>
<body>

<div class="login-box">
<h2>🔐 Login Admin</h2>

<?php if(isset($error)): ?>
<div class="error"><?= $error ?></div>
<?php endif; ?>

<form method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">LOGIN</button>
</form>

<a href="index.php" class="back-btn">⬅ Kembali ke Menu Utama</a>
</div>

</body>
</html>
<?php
exit;
endif;

/* =========================
   TAMBAH DATA
========================= */
if(isset($_POST['tambah_mesin'])){
    $nama = mysqli_real_escape_string($koneksi,$_POST['nama_mesin']);
    mysqli_query($koneksi,"INSERT INTO master_mesin (nama_mesin) VALUES ('$nama')");
}

if(isset($_POST['tambah_masalah'])){
    $nama = mysqli_real_escape_string($koneksi,$_POST['nama_permasalahan']);
    mysqli_query($koneksi,"INSERT INTO master_permasalahan (nama_permasalahan) VALUES ('$nama')");
}

/* =========================
   HAPUS DATA
========================= */
if(isset($_GET['hapus_mesin'])){
    mysqli_query($koneksi,"DELETE FROM master_mesin WHERE id='$_GET[hapus_mesin]'");
}
if(isset($_GET['hapus_masalah'])){
    mysqli_query($koneksi,"DELETE FROM master_permasalahan WHERE id='$_GET[hapus_masalah]'");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Master TPM</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{margin:0;font-family:Arial;background:#f4f6f9;}
.header{
    background:linear-gradient(135deg,#1d4350,#a43931);
    color:white;padding:25px;text-align:center;
}
.container{padding:20px;max-width:1000px;margin:auto;}
.card{
    background:white;border-radius:12px;padding:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.25);margin-bottom:25px;
}
form{display:flex;gap:10px;margin-bottom:15px;}
input[type=text]{flex:1;padding:10px;border-radius:6px;border:1px solid #ccc;}
button{padding:10px 18px;border:none;border-radius:6px;background:#007bff;color:white;}
table{width:100%;border-collapse:collapse;}
th,td{border:1px solid #ddd;padding:10px;text-align:center;}
.hapus{color:red;font-weight:bold;text-decoration:none;}
.top-bar{display:flex;justify-content:space-between;align-items:center;}
.logout{color:white;font-weight:bold;text-decoration:none;}
.back{display:inline-block;margin-top:15px;font-weight:bold;}
</style>
</head>

<body>

<div class="header">
<div class="top-bar">
<div>
<h2>⚙️ ADMIN MASTER TPM</h2>
<p>Kelola Master Mesin & Permasalahan</p>
</div>
<a href="?logout=1" class="logout">🚪 Logout</a>
</div>
</div>

<div class="container">

<div class="card">
<h3>🔧 Master Mesin</h3>
<form method="post">
    <input type="text" name="nama_mesin" placeholder="Nama Mesin" required>
    <button name="tambah_mesin">Tambah</button>
</form>
<table>
<tr><th>No</th><th>Mesin</th><th>Aksi</th></tr>
<?php
$no=1;
$q=mysqli_query($koneksi,"SELECT * FROM master_mesin ORDER BY nama_mesin");
while($m=mysqli_fetch_assoc($q)){
?>
<tr>
<td><?= $no++ ?></td>
<td><?= htmlspecialchars($m['nama_mesin']) ?></td>
<td><a class="hapus" href="?hapus_mesin=<?= $m['id'] ?>" onclick="return confirm('Hapus?')">Hapus</a></td>
</tr>
<?php } ?>
</table>
</div>

<div class="card">
<h3>🛠️ Master Permasalahan</h3>
<form method="post">
    <input type="text" name="nama_permasalahan" placeholder="Nama Permasalahan" required>
    <button name="tambah_masalah">Tambah</button>
</form>
<table>
<tr><th>No</th><th>Permasalahan</th><th>Aksi</th></tr>
<?php
$no=1;
$q=mysqli_query($koneksi,"SELECT * FROM master_permasalahan ORDER BY nama_permasalahan");
while($p=mysqli_fetch_assoc($q)){
?>
<tr>
<td><?= $no++ ?></td>
<td><?= htmlspecialchars($p['nama_permasalahan']) ?></td>
<td><a class="hapus" href="?hapus_masalah=<?= $p['id'] ?>" onclick="return confirm('Hapus?')">Hapus</a></td>
</tr>
<?php } ?>
</table>
</div>

<a href="index.php" class="back">⬅ Kembali ke Menu Utama</a>

</div>
</body>
</html>
