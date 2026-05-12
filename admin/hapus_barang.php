<?php
session_start();
include "../login/config.php";
global $conn;

if(!isset($_SESSION['login']) || $_SESSION['login'] !== true){
    header("Location: ../login/login.php");
    exit;
}

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login/login.php");
    exit;
}

// Validasi ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header("Location: barang.php?error=ID tidak valid");
    exit;
}

$id = (int)$_GET['id'];

// Cek apakah barang ada
$cek = "SELECT id_barang, nama_barang FROM barang WHERE id_barang = $id";
$resultCek = mysqli_query($conn, $cek);

if(mysqli_num_rows($resultCek) === 0){
    header("Location: barang.php?error=Barang tidak ditemukan");
    exit;
}

// Hapus barang
$hapus = "DELETE FROM barang WHERE id_barang = $id";
if(mysqli_query($conn, $hapus)){
    header("Location: barang.php?success=Barang berhasil dihapus");
} else {
    header("Location: barang.php?error=Gagal menghapus barang: " . urlencode(mysqli_error($conn)));
}
exit;
?>
