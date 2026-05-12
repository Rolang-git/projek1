<?php
session_start();
include "../login/config.php";
global $conn;

// Cek apakah user sudah login
if(!isset($_SESSION['login']) || $_SESSION['login'] !== true){
    header("Location: ../login/login.php");
    exit;
}

// Cek apakah role adalah admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login/login.php");
    exit;
}

// Validasi ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header("Location: karyawan.php?error=ID tidak valid");
    exit;
}

$id = (int)$_GET['id'];

// Cek apakah karyawan ada di database
$cek = "SELECT id_karyawan, nama_karyawan FROM karyawan WHERE id_karyawan = $id";
$resultCek = mysqli_query($conn, $cek);

if(mysqli_num_rows($resultCek) === 0){
    header("Location: karyawan.php?error=Karyawan tidak ditemukan");
    exit;
}

// Hapus data karyawan
$hapus = "DELETE FROM karyawan WHERE id_karyawan = $id";
if(mysqli_query($conn, $hapus)){
    header("Location: karyawan.php?success=Karyawan berhasil dihapus");
} else {
    header("Location: karyawan.php?error=Gagal menghapus karyawan: " . urlencode(mysqli_error($conn)));
}
exit;
?>
    