<?php
session_start();

// Destroy semua session data
session_unset();
session_destroy();

// Hapus session cookie
if(ini_get("session.use_cookies")){
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Redirect ke login
header("Location: login.php");
exit;
?>