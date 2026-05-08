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

// Ambil data dari session untuk ditampilkan di dashboard
$nama = isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : 'Admin';
$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;

// Cek koneksi database
if(!$conn){
    die("Koneksi database gagal!");
}

// Ambil data laporan penjualan dari database
$query = "SELECT * FROM penjualan ORDER BY id_penjualan DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
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
                <a href="dashboard.php" class="nav-link">
                    <span>🏠</span> Dashboard
                </a>
                <a href="barang.php" class="nav-link">
                    <span>🛍️</span> Barang
                </a>
                <a href="karyawan.php" class="nav-link">
                    <span>🧑‍💼</span> Karyawan
                </a>
                <a href="laporan.php" class="nav-link active">
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
                <!-- Page Header -->
                <div class="welcome-card">
                    <h2>📈 Laporan Penjualan</h2>
                </div>

                <!-- Action Buttons -->
                <div class="action-bar">
                    <input type="text" class="search-box" placeholder="Cari laporan...">
                </div>

                <!-- Laporan Table -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id</th>
                                <th>Tanggal Penjualan</th>
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th>Ukuran</th>
                                <th>Total</th>
                                <th>Bayar</th>
                                <th>Nama Pelanggan</th>
                                <th>No Telpon</th>
                            </tr>
                        </thead>
                        <tbody>
<?php if(mysqli_num_rows($result) > 0): ?>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['tanggal_penjualan']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                                <td><?php echo htmlspecialchars($row['jenis']); ?></td>
                                <td><?php echo htmlspecialchars($row['ukuran']); ?></td>
                                <td><?php echo htmlspecialchars($row['total']); ?></td>
                                <td><?php echo htmlspecialchars($row['bayar']); ?></td>
                                <td><?php echo htmlspecialchars($row['kembalian']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                                <td><?php echo htmlspecialchars($row['no_telpon']); ?></td>
                            </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="10" style="text-align:center;">Data laporan belum tersedia</td>
    </tr>
<?php endif; ?>
</tbody>
                    </table>
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
