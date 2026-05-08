<?php
session_start();
include "../login/config.php";
global $conn;

// Cek login & role
if(!isset($_SESSION['login']) || $_SESSION['role'] != "admin"){
    header("Location: ../login/login.php");
    exit;
}

// Jika tombol simpan ditekan
if(isset($_POST['simpan'])){

    $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $jenis_bahan = mysqli_real_escape_string($conn, $_POST['jenis_bahan']);
    $harga = intval($_POST['harga']);
    $stok = intval($_POST['stok']);

    $query = "INSERT INTO barang (nama_barang, jenis_bahan, harga, stok) 
              VALUES ('$nama_barang', '$jenis_bahan', '$harga', '$stok')";

    if(mysqli_query($conn, $query)){
        echo "<script>
                alert('Data barang berhasil ditambahkan!');
                window.location='barang.php';
              </script>";
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="form-container">
    <h2>Tambah Barang</h2>

    <form method="POST">
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" required>

        <label>Jenis Bahan</label>
        <input type="text" name="jenis_bahan" required>

        <label>Harga</label>
        <input type="number" name="harga" required>

        <label>Stok</label>
        <input type="number" name="stok" required>

        <button type="submit" name="simpan" class="btn-primary">
            Simpan
        </button>

        <a href="barang.php" class="btn-delete">Kembali</a>
    </form>
</div>

</body>
</html>