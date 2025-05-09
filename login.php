<?php 
session_start();
include "function.php"; // koneksi ke DB

// Jika sudah login, redirect ke halaman masing-masing
if (isset($_SESSION["level"])) {
    if ($_SESSION["level"] === "Admin") {
        header("Location: admin.php");
        exit;
    } else if ($_SESSION["level"] === "User") {
        header("Location: dashboard.php");
        exit;
    }
}

// Inisialisasi variabel error
$error = "";

// Proses login hanya jika tombol submit ditekan
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hindari SQL injection (gunakan prepared statement jika memungkinkan)
    $username = mysqli_real_escape_string($koneksi, $username);

    $result = mysqli_query($koneksi, "SELECT * FROM data_login WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $row["username"];
            $_SESSION["level"] = $row["level"];

            // Redirect berdasarkan level
            if ($row["level"] === "Admin") {
                header("Location: admin.php");
                exit;
            } else if ($row["level"] === "User") {
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Level tidak dikenali!";
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
        <?php if ($error): ?>
            <script>alert("<?= $error ?>");</script>
        <?php endif; ?>
            <form class="login-form" action="login.php" method="POST">
                <h2>Login</h2>
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" name="username" id="username" placeholder="Masuk'kan Username Anda" require>
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" id="password" placeholder="Masuk'kan Password Anda" require>
                </div>
                <a href="registrasi.php" class="no-account">Belum Punya Akun?</a>
                <button type="submit" name="login" class="btn-login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
