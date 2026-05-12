<?php
session_start();
include "../login/config.php";
global $conn;

if(!isset($_SESSION['login']) || $_SESSION['role'] != "admin"){
    header("Location: ../login/login.php");
    exit;
}

// Ambil ID barang dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id == 0){
    echo "<script>alert('ID barang tidak valid!'); window.location='barang.php';</script>";
    exit;
}

// Proses simpan perubahan
if(isset($_POST['update'])){
    $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $jenis       = mysqli_real_escape_string($conn, $_POST['jenis']);
    $harga       = intval($_POST['harga']);
    $stok        = intval($_POST['stok']);

    $query = "UPDATE barang 
              SET nama_barang='$nama_barang', harga='$harga', stok='$stok', jenis='$jenis' 
              WHERE id_barang='$id'";

    if(mysqli_query($conn, $query)){
        echo "<script>
                alert('Data barang berhasil diperbarui!');
                window.location='barang.php';
              </script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($conn) . "');</script>";
    }
}

// Ambil data barang berdasarkan ID
$query  = "SELECT * FROM barang WHERE id_barang='$id'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0){
    echo "<script>alert('Data barang tidak ditemukan!'); window.location='barang.php';</script>";
    exit;
}

$barang = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f5f3;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .card {
            background: #fff;
            border: 0.5px solid #e0ddd6;
            border-radius: 12px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
        }

        .card-title {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #aaa;
            margin-bottom: 1.75rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        label {
            font-size: 12px;
            color: #888;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px 10px;
            font-size: 14px;
            color: #111;
            background: #fff;
            border: 0.5px solid #ddd;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.15s;
            appearance: textfield;
            -moz-appearance: textfield;
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
        }

        input:focus {
            border-color: #888;
        }

        input::placeholder {
            color: #ccc;
        }

        .form-actions {
            display: flex;
            gap: 8px;
        }

        .btn-update {
            flex: 1;
            padding: 9px;
            font-size: 13px;
            font-weight: 500;
            background: #111;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-update:hover {
            background: #333;
        }

        .btn-kembali {
            padding: 9px 16px;
            font-size: 13px;
            color: #777;
            background: transparent;
            border: 0.5px solid #ddd;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: border-color 0.15s, color 0.15s;
        }

        .btn-kembali:hover {
            border-color: #aaa;
            color: #444;
        }
    </style>
</head>
<body>

<div class="card">
    <p class="card-title">Edit barang</p>

    <form method="POST">
        <div class="form-group">
            <div class="field">
                <label for="nama_barang">Nama barang</label>
                <input type="text" id="nama_barang" name="nama_barang"
                       value="<?= htmlspecialchars($barang['nama_barang']) ?>"
                       placeholder="Masukkan nama barang" required>
            </div>
            <div class="field">
                <label for="jenis">Jenis</label>
                <input type="text" id="jenis" name="jenis"
                       value="<?= htmlspecialchars($barang['jenis']) ?>"
                       placeholder="Masukkan jenis" required>
            </div>
            <div class="form-row">
                <div class="field">
                    <label for="harga">Harga</label>
                    <input type="number" id="harga" name="harga"
                           value="<?= $barang['harga'] ?>"
                           placeholder="0" min="0" required>
                </div>
                <div class="field">
                    <label for="stok">Stok</label>
                    <input type="number" id="stok" name="stok"
                           value="<?= $barang['stok'] ?>"
                           placeholder="0" min="0" required>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" name="update" class="btn-update">Simpan perubahan</button>
            <a href="barang.php" class="btn-kembali">Kembali</a>
        </div>
    </form>
</div>

</body>
</html>
