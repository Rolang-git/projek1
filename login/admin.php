<?php
session_start();

if(!isset($_SESSION['login']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="dashboard">
    <h1>Dashboard Admin</h1>
    <p>Selamat datang, <?= $_SESSION['nama']; ?></p>
    <a href="../logout.php" class="logout">Logout</a>
</div>

</body>
</html>