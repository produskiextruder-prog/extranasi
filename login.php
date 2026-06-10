<?php
session_start();

if(isset($_POST['login'])){

    $username   = $_POST['username'];
    $password   = $_POST['password'];
    $departemen = $_POST['departemen'];

    // USER EXTRUDER
    if(
        $username=="extruder" &&
        $password=="123456" &&
        $departemen=="EXTRUDER"
    ){

        $_SESSION['login']=true;
        $_SESSION['user']=$username;
        $_SESSION['departemen']="EXTRUDER";

        header("Location: dashboard.php");
        exit;
    }

    // USER STRAPPING
    if(
        $username=="strapping" &&
        $password=="123456" &&
        $departemen=="STRAPPING"
    ){

        $_SESSION['login']=true;
        $_SESSION['user']=$username;
        $_SESSION['departemen']="STRAPPING";

        header("Location: dashboard_strapping.php");
        exit;
    }

    $error = "Username, Password atau Departemen salah!";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Monitoring System</title>

<style>

body{
margin:0;
font-family:Arial;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
}

.login-box{
width:420px;
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 0 20px rgba(0,0,0,0.3);
}

h2{
text-align:center;
margin-bottom:20px;
}

input,select{
width:100%;
padding:10px;
margin-bottom:12px;
border:1px solid #ccc;
border-radius:6px;
box-sizing:border-box;
}

button{
width:100%;
padding:12px;
background:#0d6efd;
border:none;
color:white;
font-size:16px;
border-radius:6px;
cursor:pointer;
}

button:hover{
background:#0b5ed7;
}

.error{
color:red;
text-align:center;
margin-bottom:10px;
}

.logo{
text-align:center;
font-size:50px;
margin-bottom:10px;
}

</style>
</head>

<body>

<div class="login-box">

<div class="logo">🏭</div>

<h2>MONITORING SYSTEM EXTRANASI</h2>

<?php
if(isset($error)){
    echo "<div class='error'>$error</div>";
}
?>

<form method="post">

<input type="text"
name="username"
placeholder="Username"
required>

<input type="password"
name="password"
placeholder="Password"
required>

<select name="departemen" required>
<option value="">Pilih Departemen</option>
<option value="EXTRUDER">EXTRUDER</option>
<option value="STRAPPING">STRAPPING</option>
</select>

<button type="submit" name="login">
LOGIN
</button>

</form>

</div>

</body>
</html>
