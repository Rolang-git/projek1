<?php
session_start();
include "../login/config.php";

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

// Ambil data dari session
$nama = isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : 'Kasir';
$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;

// Cek koneksi database
if(!$conn){
    die("Koneksi database gagal!");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="logo-section">
                <img src="../km.png" alt="Logo Karya Mandiri" class="logo-img">
                <h3>KARYA MANDIRI</h3>
            </div>
            <nav class="nav-menu">
                <a href="dashboard.php" class="nav-link active">
                    <span>🏠</span> Dashboard
                </a>
                <a href="barang.php" class="nav-link">
                    <span>🛍️</span>Barang
                </a>
                <a href="penjualan.php" class="nav-link">
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
                <!-- Welcome Card -->
                <div class="welcome-card">
                    <h2>👋 Selamat Datang di Dashboard Kasir</h2>
                   
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">🛒</div>
                        <div class="stat-info">
                            <h3>Transaksi Hari Ini</h3>
                            <p class="stat-number">45</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">💵</div>
                        <div class="stat-info">
                            <h3>Total Penjualan</h3>
                            <p class="stat-number">Rp 5.2 Juta</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">✅</div>
                        <div class="stat-info">
                            <h3>Transaksi Sukses</h3>
                            <p class="stat-number">43</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">📊</div>
                        <div class="stat-info">
                            <h3>Rata-rata Transaksi</h3>
                            <p class="stat-number">Rp 120.930</p>
                        </div>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="features-section">
                    <h2>Fitur Utama</h2>
                    <div class="features-grid">
                        <div class="feature-card">
                            <div class="feature-title">🛒 Kelola Penjualan</div>
                            <p>Proses transaksi penjualan dengan cepat dan akurat</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-title">📦 Cek Stok Barang</div>
                            <p>Pantau ketersediaan stok barang di toko</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-title">📊 Laporan Harian</div>
                            <p>Lihat ringkasan penjualan harian Anda</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-title">💳 Metode Pembayaran</div>
                            <p>Terima berbagai metode pembayaran pelanggan</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="footer">
                <p>&copy; KARYA MANDIRI PAMANUKAN</p>
            </footer>
        </main>
    </div>
</body>
</html>
