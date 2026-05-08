<?php
session_start();
include "../login/config.php";

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

// Ambil data dari session
$nama = isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : 'Admin';
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
    <title>Dashboard Admin</title>
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
                    <span>🛍️</span> Barang
                </a>
                <a href="karyawan.php" class="nav-link">
                    <span>🧑‍💼</span> Karyawan
                </a>
                <a href="laporan.php" class="nav-link">
                    <span>📈</span> Laporan
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
                    <h2>👋 Selamat Datang di Dashboard Admin</h2>
                    <p>Kelola seluruh aspek toko Anda dari sini. Gunakan menu di samping untuk navigasi.</p>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">📦</div>
                        <div class="stat-info">
                            <h3>Barang</h3>
                            <p class="stat-number">150</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">💰</div>
                        <div class="stat-info">
                            <h3>Penjualan Hari Ini</h3>
                            <p class="stat-number">Rp 5.2 Juta</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">👥</div>
                        <div class="stat-info">
                            <h3>Pelanggan</h3>
                            <p class="stat-number">425</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">📊</div>
                        <div class="stat-info">
                            <h3>Total Transaksi</h3>
                            <p class="stat-number">1,240</p>
                        </div>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="features-section">
                    <h2>Fitur Utama</h2>
                    <div class="features-grid">
                        <div class="feature-card">
                            <div class="feature-title">📦 Manajemen Barang</div>
                            <p>Tambah, ubah, atau hapus Barang di toko Anda</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-title">💼 Manajemen Pengguna</div>
                            <p>Kelola akun admin dan kasir</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-title">📈 Laporan Penjualan</div>
                            <p>Lihat statistik dan laporan penjualan harian</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-title">📊 Analytics</div>
                            <p>Analisis performa toko secara mendalam</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="footer">
                <p>&copy; 2026 Sistem Penjualan Toko. All rights reserved.</p>
            </footer>
        </main>
    </div>
</body>
</html>
