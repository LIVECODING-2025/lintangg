<?php
session_start();
session_destroy();  // Hapus semua sesi

// Hapus semua cookie sesi juga
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

header('Location: login.php');  // Redirect ke halaman login
exit();
?>