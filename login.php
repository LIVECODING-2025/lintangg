<?php
session_start();
require 'function.php';

if (isset($_POST["login"])) {
    $username = htmlspecialchars(trim($_POST["username"]));
    $password = htmlspecialchars(trim($_POST["password"]));

    // Menggunakan prepared statement untuk keamanan
    $stmt = $koneksi->prepare("SELECT * FROM data_login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Pastikan NIP dari database dan input bersih dari spasi
        $db_password = trim($row["password"]);

        // Perbandingan longgar untuk tipe data yang berbeda
        if ($db_password == $db_password) { // Gunakan == untuk menghindari masalah tipe data
            // Simpan data ke sesi
            $_SESSION["username"] = $row["username"];
            $_SESSION["level"] = $row["level"];

            // Redirect berdasarkan level
            if ($row["level"] === "admin") {
                header("Location: admin.php");
                exit;
            } elseif ($row["level"] === "user") {
                header("Location: dashboard.php");
                exit;
            } else {
                echo "<script>alert('Level pengguna tidak valid!');</script>";
            }
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!');</script>";
    }

    $stmt->close();
}
?>





<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login Piknik'in.Aja</title>
    <link rel="stylesheet" href="css user/style2.css" id="paragraf 2"/>
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
                    <input type="text" name="username" placeholder="Masukkan Username Anda" required>
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
