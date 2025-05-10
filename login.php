<?php
session_start();
include "function.php"; // Koneksi database, misalnya variabelnya: $koneksi

// Jika sudah login, langsung arahkan sesuai level
if (isset($_SESSION["level"])) {
    if ($_SESSION["level"] === "Admin") {
        header("Location: admin.php");
        exit;
    } elseif ($_SESSION["level"] === "User") {
        header("Location: dashboard.php");
        exit;
    }
}

$error = "";

// Saat tombol login ditekan
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {
    $username = mysqli_real_escape_string($koneksi, $_POST["username"]);
    $password = $_POST["password"];

    $query = "SELECT * FROM data_loginn WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password hash
        if (password_verify($password, $user["password"])) {
            $_SESSION["username"] = $user["username"];
            $_SESSION["level"] = $user["level"];

            // Arahkan berdasarkan level
            if ($user["level"] === "Admin") {
                header("Location: admin.php");
                exit;
            } elseif ($user["level"] === "User") {
                header("Location: dashboard.php");
                exit;
            }
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
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
            <form class="login-form" action="login.php" method="POST">
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
