<?php
session_start();

if(!isset($_SESSION['login']) || $_SESSION['role'] != "kasir"){
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Kasir</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="dashboard">
    <h1>Dashboard Kasir</h1>
    <p>Selamat datang, <?= $_SESSION['nama']; ?></p>
    <a href="../logout.php" class="logout">Logout</a>
</div>

</body>
</html>