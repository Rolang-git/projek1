<?php
session_start();
include "config.php";
global $conn;

// Cek apakah user sudah login, jika ya redirect ke dashboard
if(isset($_SESSION['login']) && $_SESSION['login'] === true){
    if($_SESSION['role'] == "admin"){
        header("Location: ../admin/dashboard.php");
        exit;
    } else if($_SESSION['role'] == "kasir"){
        header("Location: ../kasir/dashboard.php");
        exit;
    }
}

$error = "";

if(isset($_POST['login'])){
    // Validasi input tidak boleh kosong
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    if(empty($username) || empty($password)){
        $error = "Username dan Password tidak boleh kosong!";
    } else {
        // Gunakan prepared statement untuk keamanan lebih baik
        $username = mysqli_real_escape_string($conn, $username);
        $password = md5($password);

        $query = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password='$password'");
        $data = mysqli_fetch_assoc($query);

        if(mysqli_num_rows($query) > 0){
            // Set session variables
            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $data['id_user'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['role'] = $data['role'];

            // Redirect berdasarkan role
            if($data['role'] == "admin"){
                header("Location: ../admin/dashboard.php");
            } else if($data['role'] == "kasir"){
                header("Location: ../kasir/dashboard.php");
            }

            exit;
        } else {
            $error = "Username atau Password salah!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Penjualan Toko</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="login-container">
        <h2>Login</h2>
        <p>Karya Mandiri Pamanukan</p>

        <?php if(isset($error)) : ?>
            <div class="error"><?= $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required autofocus>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>