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

// Ambil data dari session untuk ditampilkan di dashboard
$nama = isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : 'Admin';
$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;

// Cek koneksi database
if(!$conn){
    die("Koneksi database gagal!");
}

// Ambil data barang dari database
$query = "SELECT * FROM karyawan ORDER BY id_karyawan DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Karyawan</title>
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
                <a href="karyawan.php" class="nav-link active">
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
                <!-- Page Header -->
                <div class="welcome-card">
                    <h2>🧑‍💼 Manajemen Karyawan</h2>
                </div>

                <!-- Action Buttons -->
                <div class="action-bar">
                    <a href="tambah_karyawan.php" class="btn-primary">Tambah Karyawan</a>
                    <input type="text" class="search-box" placeholder="Cari karyawan...">
                </div>

                <!-- Barang Table -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Karyawan</th>
                                <th>No Telpon</th>
                                <th>Divisi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
<?php if(mysqli_num_rows($result) > 0): ?>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                <td><?php echo htmlspecialchars($row['posisi']); ?></td>
                                <td>
                                    <a href="edit_karyawan.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                                    <a href="hapus_karyawan.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');">Hapus</a>
                                </td>
                            </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="4" style="text-align:center;">Data karyawan belum tersedia</td>
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
