```php
<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$qData = mysqli_query($koneksi,"SELECT * FROM input_tpm WHERE id='$id'");
$row = mysqli_fetch_assoc($qData);

if(!$row){
    die("Data tidak ditemukan!");
}

$qMesin = mysqli_query($koneksi,"SELECT nama_mesin FROM master_mesin ORDER BY nama_mesin ASC");
$qMasalah = mysqli_query($koneksi,"SELECT nama_permasalahan FROM master_permasalahan ORDER BY nama_permasalahan ASC");

/* =========================
   UPDATE DATA
========================= */
if(isset($_POST['update'])){

    $tanggal = $_POST['tanggal'];
    $shift = $_POST['shift'];
    $mesin = $_POST['mesin'];
    $kategori = $_POST['kategori'];
    $permasalahan = $_POST['permasalahan'];
    $permasalahan_detail = $_POST['permasalahan_detail'];

    $jam_mesin_off = $_POST['jam_mesin_off'];
    $jam_mesin_start = $_POST['jam_mesin_start'];
    $jam_selesai_perbaikan = $_POST['jam_selesai_perbaikan'];

    $perbaikan = $_POST['perbaikan'];
    $pergantian_sparepart = $_POST['pergantian_sparepart'];

    $pengecekan_teknik = $_POST['pengecekan_teknik'];
    $pengecekan_produksi = $_POST['pengecekan_produksi'];

    /* HITUNG DURASI */
    $durasi_off_start = '';
    $durasi_off_selesai = '';

    if(!empty($jam_mesin_off) && !empty($jam_mesin_start)){
        $diff = strtotime($jam_mesin_start) - strtotime($jam_mesin_off);

        if($diff >= 0){
            $jam = floor($diff / 3600);
            $menit = floor(($diff % 3600) / 60);
            $durasi_off_start = $jam." jam ".$menit." menit";
        }
    }

    if(!empty($jam_mesin_off) && !empty($jam_selesai_perbaikan)){
        $diff2 = strtotime($jam_selesai_perbaikan) - strtotime($jam_mesin_off);

        if($diff2 >= 0){
            $jam2 = floor($diff2 / 3600);
            $menit2 = floor(($diff2 % 3600) / 60);
            $durasi_off_selesai = $jam2." jam ".$menit2." menit";
        }
    }

    /* FOTO */
    $foto = $row['foto_sparepart'];

    if(!empty($_FILES['foto_sparepart']['name'])){

        $folder = "uploads/";
        if(!is_dir($folder)){
            mkdir($folder,0777,true);
        }

        $namaFile = time().'_'.$_FILES['foto_sparepart']['name'];
        $target = $folder.$namaFile;

        if(move_uploaded_file($_FILES['foto_sparepart']['tmp_name'],$target)){
            $foto = $target;
        }
    }

    mysqli_query($koneksi,"
    UPDATE input_tpm SET

    tanggal='$tanggal',
    shift='$shift',
    mesin='$mesin',
    kategori='$kategori',
    permasalahan='$permasalahan',
    permasalahan_detail='$permasalahan_detail',

    jam_mesin_off='$jam_mesin_off',
    jam_mesin_start='$jam_mesin_start',
    jam_selesai_perbaikan='$jam_selesai_perbaikan',

    durasi_off_start='$durasi_off_start',
    durasi_off_selesai='$durasi_off_selesai',

    perbaikan='$perbaikan',
    pergantian_sparepart='$pergantian_sparepart',
    foto_sparepart='$foto',

    pengecekan_teknik='$pengecekan_teknik',
    pengecekan_produksi='$pengecekan_produksi'

    WHERE id='$id'
    ");

    echo "<script>
    alert('Data berhasil diupdate');
    window.location='tabel_tpm.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit TPM</title>

<style>
body{
margin:0;
font-family:Arial;
background:linear-gradient(135deg,#1f4037,#99f2c8);
}

.container{
max-width:900px;
margin:20px auto;
background:#fff;
padding:25px;
border-radius:12px;
box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

h2{
text-align:center;
}

.form-group{
display:grid;
grid-template-columns:220px 1fr;
gap:10px;
margin-bottom:10px;
}

input,select,textarea{
padding:8px;
border:1px solid #ccc;
border-radius:5px;
width:100%;
}

img{
max-width:150px;
border-radius:8px;
}

.btn{
padding:10px 20px;
border:none;
border-radius:5px;
cursor:pointer;
color:white;
}

.save{
background:#27ae60;
}

.back{
background:#e74c3c;
text-decoration:none;
padding:10px 20px;
}
</style>
</head>

<body>

<div class="container">

<h2>EDIT DATA TPM</h2>

<form method="post" enctype="multipart/form-data">

<div class="form-group">
<label>Tanggal</label>
<input type="date" name="tanggal" value="<?= $row['tanggal']; ?>">
</div>

<div class="form-group">
<label>Shift</label>
<select name="shift">
<option value="1" <?= $row['shift']=='1'?'selected':'' ?>>Shift 1</option>
<option value="2" <?= $row['shift']=='2'?'selected':'' ?>>Shift 2</option>
<option value="3" <?= $row['shift']=='3'?'selected':'' ?>>Shift 3</option>
</select>
</div>

<div class="form-group">
<label>Mesin</label>
<select name="mesin">
<?php while($m=mysqli_fetch_assoc($qMesin)){ ?>
<option value="<?= $m['nama_mesin']; ?>"
<?= $row['mesin']==$m['nama_mesin']?'selected':'' ?>>
<?= $m['nama_mesin']; ?>
</option>
<?php } ?>
</select>
</div>

<div class="form-group">
<label>Kategori</label>
<select name="kategori">
<option value="Breakdown" <?= $row['kategori']=='Breakdown'?'selected':'' ?>>Breakdown</option>
<option value="Kritis" <?= $row['kategori']=='Kritis'?'selected':'' ?>>Kritis</option>
<option value="WO" <?= $row['kategori']=='WO'?'selected':'' ?>>WO</option>
</select>
</div>

<div class="form-group">
<label>Section</label>
<select name="permasalahan">
<?php while($p=mysqli_fetch_assoc($qMasalah)){ ?>
<option value="<?= $p['nama_permasalahan']; ?>"
<?= $row['permasalahan']==$p['nama_permasalahan']?'selected':'' ?>>
<?= $p['nama_permasalahan']; ?>
</option>
<?php } ?>
</select>
</div>

<div class="form-group">
<label>Detail Permasalahan</label>
<textarea name="permasalahan_detail"><?= $row['permasalahan_detail']; ?></textarea>
</div>

<div class="form-group">
<label>Jam Mesin OFF</label>
<input type="datetime-local" name="jam_mesin_off"
value="<?= str_replace(' ','T',$row['jam_mesin_off']); ?>">
</div>

<div class="form-group">
<label>Jam Mesin START</label>
<input type="datetime-local" name="jam_mesin_start"
value="<?= str_replace(' ','T',$row['jam_mesin_start']); ?>">
</div>

<div class="form-group">
<label>Jam Selesai Perbaikan</label>
<input type="datetime-local" name="jam_selesai_perbaikan"
value="<?= str_replace(' ','T',$row['jam_selesai_perbaikan']); ?>">
</div>

<div class="form-group">
<label>Perbaikan</label>
<textarea name="perbaikan"><?= $row['perbaikan']; ?></textarea>
</div>

<div class="form-group">
<label>Pergantian Sparepart</label>
<textarea name="pergantian_sparepart"><?= $row['pergantian_sparepart']; ?></textarea>
</div>

<div class="form-group">
<label>Foto Lama</label>
<div>
<?php if($row['foto_sparepart']){ ?>
<img src="<?= $row['foto_sparepart']; ?>">
<?php } ?>
</div>
</div>

<div class="form-group">
<label>Ganti Foto</label>
<input type="file" name="foto_sparepart">
</div>

<div class="form-group">
<label>Pengecekan Teknik</label>
<select name="pengecekan_teknik">
<option value="OK" <?= $row['pengecekan_teknik']=='OK'?'selected':'' ?>>OK</option>
<option value="NO" <?= $row['pengecekan_teknik']=='NO'?'selected':'' ?>>NO</option>
</select>
</div>

<div class="form-group">
<label>Pengecekan Produksi</label>
<select name="pengecekan_produksi">
<option value="OK" <?= $row['pengecekan_produksi']=='OK'?'selected':'' ?>>OK</option>
<option value="NO" <?= $row['pengecekan_produksi']=='NO'?'selected':'' ?>>NO</option>
</select>
</div>

<br>

<button type="submit" name="update" class="btn save">
💾 UPDATE DATA
</button>

<a href="tabel_tpm.php" class="back">
⬅ Kembali
</a>

</form>

</div>

</body>
</html>
```
