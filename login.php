<?php
session_start();
require 'function.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim(htmlspecialchars($_POST["username"]));
    $passwordInput = $_POST["password"];

    $stmt = $koneksi->prepare("SELECT id_user, username, password, level FROM data_login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($passwordInput, $user["password"])) {
            $_SESSION["id_user"] = $user["id_user"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["level"] = $user["level"];

            // Arahkan berdasarkan role
            if ($user["level"] == "admin") {
                header("Location: admin.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        } else {
            $message = "Password salah!";
        }
    } else {
        $message = "Username tidak ditemukan!";
    }

    $stmt->close();
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
                    <input type="text" name="username" placeholder="Masukkan Username Anda" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password Anda" required>
                </div>
                <a href="registrasi.php" class="no-account">Belum Punya Akun?</a>
                <button type="submit" name="login" class="btn-login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
