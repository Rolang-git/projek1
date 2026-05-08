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

// Ambil data barang untuk konfirmasi tampilan
$query  = "SELECT * FROM barang WHERE id_barang='$id'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0){
    echo "<script>alert('Data barang tidak ditemukan!'); window.location='barang.php';</script>";
    exit;
}

$barang = mysqli_fetch_assoc($result);

// Proses hapus setelah konfirmasi
if(isset($_POST['hapus'])){
    $del = "DELETE FROM barang WHERE id_barang='$id'";

    if(mysqli_query($conn, $del)){
        echo "<script>
                alert('Data barang berhasil dihapus!');
                window.location='barang.php';
              </script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Barang</title>
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

        /* Detail barang yang akan dihapus */
        .detail-box {
            background: #fafaf9;
            border: 0.5px solid #e8e5de;
            border-radius: 8px;
            padding: 1rem 1.1rem;
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .detail-key {
            font-size: 12px;
            color: #aaa;
        }

        .detail-val {
            font-size: 13px;
            font-weight: 500;
            color: #111;
        }

        /* Pesan konfirmasi */
        .confirm-msg {
            font-size: 13px;
            color: #555;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .confirm-msg strong {
            color: #111;
        }

        /* Tombol */
        .form-actions {
            display: flex;
            gap: 8px;
        }

        .btn-hapus {
            flex: 1;
            padding: 9px;
            font-size: 13px;
            font-weight: 500;
            background: #c0392b;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-hapus:hover {
            background: #a93226;
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
    <p class="card-title">Hapus barang</p>

    <!-- Detail barang yang akan dihapus -->
    <div class="detail-box">
        <div class="detail-row">
            <span class="detail-key">Nama barang</span>
            <span class="detail-val"><?= htmlspecialchars($barang['nama_barang']) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-key">Jenis</span>
            <span class="detail-val"><?= htmlspecialchars($barang['jenis']) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-key">Harga</span>
            <span class="detail-val">Rp <?= number_format($barang['harga'], 0, ',', '.') ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-key">Stok</span>
            <span class="detail-val"><?= $barang['stok'] ?> unit</span>
        </div>
    </div>

    <p class="confirm-msg">
        Apakah kamu yakin ingin menghapus <strong><?= htmlspecialchars($barang['nama_barang']) ?></strong>?
        Tindakan ini tidak dapat dibatalkan.
    </p>

    <form method="POST">
        <div class="form-actions">
            <button type="submit" name="hapus" class="btn-hapus">Ya, hapus</button>
            <a href="barang.php" class="btn-kembali">Batal</a>
        </div>
    </form>
</div>

</body>
</html>
