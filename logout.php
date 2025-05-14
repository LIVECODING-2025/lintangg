<?php
session_start();
session_unset(); // Hapus semua data sesi
session_destroy(); // Hancurkan sesi

// Redirect ke halaman login
header("Location: login.php");
exit;
?>
