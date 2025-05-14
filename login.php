<?php 
require 'function.php'; 

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login Wisata Jawa Timur</title>
    <link rel="stylesheet" href="style2.css" id="paragraf 2"/>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="login-container">
        <div class="left-panel">
            <div class="welcome-text">
                <h1><span>Selamat</span>Datang</h1>
                <p>Selamat Menjelajahi Wisata Alam Yang Ada Di JawaTimur</p>
            </div>
        </div>
        <div class="right-panel">
            <form class="login-form" action="proses_login.php" method="POST">
                <h2>Login</h2>
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" name="username" id="username" placeholder="Masukkan Username Anda" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan Password Anda" required>
                </div>
                <a href="registrasi.php" class="no-account">Belum Punya Akun?</a>
                <button type="submit" name="login" class="btn-login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
