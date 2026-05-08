<?php
session_start();
include "../login/config.php";
global $conn;
// Cek apakah user sudah login 
if(!isset($_SESSION['login']) || $_SESSION['login'] !== true){
    header("Location: ../login/login.php");
    exit;
}

// Cek apakah role adalah kasir 
if(!isset($_SESSION['role']) || $_SESSION['role'] != "kasir"){
    header("Location: ../login/login.php");
    exit;
}

// Ambil data dari session untuk ditampilkan di dashboard
$nama = isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : 'Kasir';
$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;

// Cek koneksi database
if(!$conn){
    die("Koneksi database gagal!");
}

// Ambil data barang dari database
$query = "SELECT * FROM barang ORDER BY id_barang DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Barang - Sistem Penjualan Toko</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="logo-section">
                <h3>💳 Kasir </h3>
            </div>
            <nav class="nav-menu">
                <a href="dashboard.php" class="nav-link">
                    <span>🏠</span> Dashboard
                </a>
                <a href="barang.php" class="nav-link">
                    <span>🛍️</span> Barang
                </a>
                <a href="penjualan.php" class="nav-link active">
                    <span>🛒</span> Penjualan
                </a>

            </nav>
        </aside>

        <!-- Main Content --> 
        <main class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div class="header-left">
                    <h1>KARYA MANDIRI PAMANUKAN</h1>
                    <p>Selamat datang, <strong><?php echo htmlspecialchars($nama); ?></strong></p>
                </div>
                <div class="header-right">
                    <div class="user-profile">
                        <span class="user-name"><?php echo htmlspecialchars($nama); ?></span>
                        <a href="../login/logout.php" class="logout-btn">Logout</a>
                    </div>
                </div>
            </header>

            <!-- Content Section -->
            <section class="content-area">

            <!-- bagian penjualan -->
            <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Penjualan</title>
    <link rel="stylesheet" href="penjualan.css">
</head>
<body>

<div class="container">

    <!-- DATA PENJUALAN -->
    <div class="row">
        <div class="col">
            <p><label>Id Penjualan</label>: <input type="text"></p>
            <p><label>Tgl Penjualan</label>: <input type="date"></p>
        </div>

        <div class="col">
            <p><label>Nama Pelanggan</label>: <input type="text"></p>
            <p><label>No Telpon</label>: <input type="text"></p>
        </div>
    </div>


    <!-- INPUT BARANG -->
    <div class="row">
        <div class="col">
            <p>
                <label>ID Barang</label>: 
                <input type="text" style="width: 40%;">
                <button class="btn">Cari</button>
            </p>
            <p><label>Nama Barang</label>: <input type="text" style="width: 60%;"></p>
            <p>
                <label>Jenis</label>: 
                <input type="text" style="width: 60%;">
                
            </p>
            <p>
                <button class="btn">Tambah</button>
            </p>
        </div>

        <div class="col">
            <p><b>GRAND TOTAL :</b></p>
            <div class="grand-total"></div>
        </div>
    </div>


    <!-- TABEL -->
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Ukuran</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
        </tr>
        <tr>
            <td colspan="7" style="height:150px;"></td>
        </tr>
    </table>

    <!-- BUTTON -->
    <div class="footer">
        <button class="btn-selesai">Selesai</button>
    </div>

</div>

</body>
</html>





            </section>

            <!-- Footer -->
            <footer class="footer">
                <p>&copy; KARYA MANDIRI PAMANUKAN</p>
            </footer>
        </main>
    </div>
</body>
</html>
