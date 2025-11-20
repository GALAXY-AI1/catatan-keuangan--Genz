<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Aplikasi</title>
<style>
body{
    font-family: Arial;
    background: #bfe4ff;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-box{
    background: white;
    padding: 25px;
    width: 300px;
    border-radius: 15px;
    box-shadow: 0 0 10px #7cc4ff;
}

h2{
    text-align: center;
    color: #007BFF;
}

input{
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 8px;
    border: 1px solid #5bbdff;
}

button{
    width: 100%;
    padding: 10px;
    background: #007BFF;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}
button:hover{
    background: #0056c7;
}

/* teks berdenyut hewan */
@keyframes pulse {
    0% { transform: scale(1); color: #007BFF; }
    50% { transform: scale(1.3); color: #ff4081; }
    100% { transform: scale(1); color: #007BFF; }
}
.animal-pulse{
    animation: pulse 1.8s infinite;
    text-align: center;
    font-size: 20px;
}

</style>
</head>
<body>

<div class="login-box">
    <h2>Login</h2>
    <div class="animal-pulse">🐶🐱🐼</div>

    <form action="proses_login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Masuk</button>
    </form>
</div>

</body>
</html>
