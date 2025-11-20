<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<style>
body{
    background: #d0ecff;
    font-family: Arial;
    padding: 25px;
}

.box{
    background: white;
    padding: 20px;
    border-radius: 10px;
}
</style>
</head>
<body>

<h2>Selamat Datang, <?= $_SESSION['login']; ?> 🎉</h2>

<div class="box">
    <p>Ini adalah halaman dashboard aplikasi kamu.</p>
    <a href="logout.php">Logout</a>
</div>

</body>
</html>
