<?php
session_start();

// Redirect jika sudah login
if (isset($_SESSION["username"])) {
    header("Location: dashboard.php");
    exit();
}

// Koneksi database
$host = "localhost";
$user = "root";
$password = "";
$database = "wisata";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim(htmlspecialchars($_POST["username"]));
    $passwordInput = $_POST["password"];

    $stmt = $conn->prepare("SELECT id_user, username, password FROM data_login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($passwordInput, $user["password"])) {
            // Simpan session
            $_SESSION["username"] = $user["username"];
            $_SESSION["id_user"] = $user["id_user"];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Password salah.";
        }
    } else {
        $message = "Username tidak ditemukan.";
    }

    $stmt->close();
}

$conn->close();
?>
