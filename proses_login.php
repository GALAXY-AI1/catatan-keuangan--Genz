<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = MD5($_POST['password']);

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) === 1){
    $_SESSION['login'] = $username;
    header("Location: index.php");
} else {
    echo "<script>
        alert('Username atau password salah!');
        window.location='login.php';
    </script>";
}
?>
