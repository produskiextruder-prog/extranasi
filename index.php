<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

if($_SESSION['departemen']!="EXTRUDER"){
    header("Location: login.php");
    exit;
}
include "koneksi.php";
?>

<!DOCTYPE html>
<html>
<head>

<title>Dashboard Monitoring Extruder</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
font-family:arial;
}

.top-kontak{
background:#0d1b2a;
color:white;
font-size:12px;
padding:4px 15px;
text-align:right;
}

.top-kontak a{
color:white;
text-decoration:none;
margin-left:10px;
}

.top-kontak a:hover{
text-decoration:underline;
}

/* NAVBAR */
.navbar{
background:#0d1b2a;
}

.navbar a{
color:white !important;
}

/* SLIDER */
.carousel-item{
height:420px;
background-size:cover;
background-position:center;
}

.overlay{
background:rgba(0,0,0,0.5);
height:100%;
display:flex;
align-items:center;
color:white;
}

/* MENU INPUT */
.menu-box{
padding:35px;
text-align:center;
color:white;
}

.menu1{background:#ff6b00;}
.menu2{background:#0d1b2a;}

.menu-box:hover{
opacity:0.9;
cursor:pointer;
}

.logout-btn{
background:#dc3545;
padding:5px 15px;
border-radius:20px;
text-decoration:none;
color:white !important;
font-weight:bold;
}

</style>

</head>

<body>

<!-- KONTAK -->
<div class="top-kontak">
<a href="logout.php"
class="logout-btn"
onclick="return confirm('Yakin ingin logout?')">
🚪 Logout
</a>
<a href="mailto:aboerisman2@gmail.com">📧 aboerisman2@gmail.com</a> |
<a href="https://wa.me/6287778142668" target="_blank">📱 087778142668</a>

</div>

<!-- NAVBAR -->
</li>
<nav class="navbar navbar-expand-lg navbar-dark">

<div class="container-fluid">

<a class="navbar-brand d-flex align-items-center">
<img src="assets/img/logo_LJP.jpg" style="height:40px;margin-right:10px;">
<b>EXTRUDER SYSTEM</b>
</a>

<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="menu">

<ul class="navbar-nav ms-auto">

<li class="nav-item">
<a class="nav-link" href="dashboard.php">Dashboard</a>
</li>

<li class="nav-item">
<a class="nav-link" href="campuran_bahan.php">Monitoring Campuran Bahan</a>
</li>

<li class="nav-item">
<a class="nav-link" href="downtime_mesin.php">Monitoring Downtime</a>
</li>

<li class="nav-item">
<a class="nav-link" href="shutdown_mesin.php">Monitoring Shutdown</a>
</li>

<!-- TAMBAHAN TPM -->
<li class="nav-item">
<a class="nav-link" href="tpm_mesin.php">Monitoring TPM</a>
</li>

</ul>

</div>

</div>

</nav>

<!-- SLIDER -->
<div id="slider" class="carousel slide" data-bs-ride="carousel">

<div class="carousel-inner">

<div class="carousel-item active" style="background-image:url('assets/img/pabrik.jpg')">
<div class="overlay">
<div class="container">
<h1>Monitoring Produksi Extruder</h1>
<p>Sistem monitoring produksi dan penggunaan material</p>
</div>
</div>
</div>

<div class="carousel-item" style="background-image:url('assets/img/gkm.jpg')">
<div class="overlay">
<div class="container">
<h1>Monitoring Downtime Mesin</h1>
<p>Data downtime mesin extruder</p>
</div>
</div>
</div>

<div class="carousel-item" style="background-image:url('assets/img/foto.jpg')">
<div class="overlay">
<div class="container">
<h1>Monitoring Shutdown Mesin</h1>
<p>History shutdown mesin produksi</p>
</div>
</div>
</div>

</div>

<button class="carousel-control-prev" type="button" data-bs-target="#slider" data-bs-slide="prev">
<span class="carousel-control-prev-icon"></span>
</button>

<button class="carousel-control-next" type="button" data-bs-target="#slider" data-bs-slide="next">
<span class="carousel-control-next-icon"></span>
</button>

</div>

<!-- MENU INPUT -->
<div class="container-fluid">
<div class="row">

<div class="col-md-3 menu-box menu1">
<h4>Input Campuran Bahan</h4>
<p>Input material produksi</p>
<a href="input_campur_bahan.php" class="btn btn-light btn-sm">Input Data</a>
</div>

<div class="col-md-3 menu-box menu2">
<h4>Input Downtime Mesin</h4>
<p>Input downtime mesin</p>
<a href="input_downtime.php" class="btn btn-light btn-sm">Input Data</a>
</div>

<div class="col-md-3 menu-box menu1">
<h4>Input Shutdown Mesin</h4>
<p>Input shutdown mesin</p>
<a href="input_shutdown.php" class="btn btn-light btn-sm">Input Data</a>
</div>

<!-- TAMBAHAN TPM -->
<div class="col-md-3 menu-box menu2">
<h4>Input TPM Extruder</h4>
<p>Input preventive maintenance</p>
<a href="input_tpm_mesin.php" class="btn btn-light btn-sm">Input Data</a>
</div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
