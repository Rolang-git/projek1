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

$nama     = isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : 'Admin';
$error    = '';
$success  = '';

// Proses form submit
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nama_karyawan = trim(mysqli_real_escape_string($conn, $_POST['nama']));
    $no_telpon     = trim(mysqli_real_escape_string($conn, $_POST['no_telepon']));
    $divisi        = trim(mysqli_real_escape_string($conn, $_POST['divisi']));
    $alamat        = trim(mysqli_real_escape_string($conn, $_POST['alamat']));

    if(empty($nama_karyawan) || empty($divisi)){
        $error = "Nama karyawan dan divisi wajib diisi!";
    } else {
        $insert = "INSERT INTO karyawan (nama_karyawan, no_telepon, divisi, alamat) VALUES ('$nama_karyawan', '$no_telpon', '$divisi', '$alamat')";
        if(mysqli_query($conn, $insert)){
            header("Location: karyawan.php?success=Karyawan berhasil ditambahkan");
            exit;
        } else {
            $error = "Gagal menambahkan karyawan: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Karyawan</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
        .form-card {
            background: #fff;
            border-radius: 12px;
            padding: 32px 36px;
            max-width: 520px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        .form-card h3 {
            margin: 0 0 24px;
            font-size: 1.2rem;
            color: #333;
        }
        .form-group {
            margin-bottom: 18px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .form-group label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #555;
        }
        .form-group input,
        .form-group select {
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: border-color 0.2s;
            outline: none;
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: #4f8ef7;
        }
        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }
        .alert-error {
            background: #fdecea;
            color: #c0392b;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 10px 16px;
            margin-bottom: 18px;
            font-size: 0.9rem;
        }
    </style>
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
            <a href="dashboard.php" class="nav-link"><span>🏠</span> Dashboard</a>
            <a href="barang.php" class="nav-link"><span>🛍️</span> Barang</a>
            <a href="karyawan.php" class="nav-link active"><span>🧑‍💼</span> Karyawan</a>
            <a href="laporan.php" class="nav-link"><span>📈</span> Laporan</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="top-header">
            <div class="header-left">
                <h1>KARYA MANDIRI PAMANUKAN</h1>
                <p>Selamat datang, <strong><?php echo $nama; ?></strong></p>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <span class="user-name"><?php echo $nama; ?></span>
                    <a href="../login/logout.php" class="logout-btn">Logout</a>
                </div>
            </div>
        </header>

        <section class="content-area">
            <div class="welcome-card">
                <h2>Tambah Karyawan</h2>
            </div>

            <div class="form-card">
                <h3>Form Tambah Karyawan</h3>

                <?php if($error): ?>
                    <div class="alert-error"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nama">Nama Karyawan <span style="color:red">*</span></label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama karyawan"
                               value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="no_telpon">No. Telepon <span style="color:red">*</span></label>
                        <input type="text" id="no_telpon" name="no_telpon" placeholder="Masukan No.Telepon"
                               value="<?php echo isset($_POST['no_telpon']) ? htmlspecialchars($_POST['no_telpon']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="divisi">Divisi <span style="color:red">*</span></label>
                        <input type="text" id="divisi" name="divisi" placeholder="Masukkan nama divisi"
                               value="<?php echo isset($_POST['divisi']) ? htmlspecialchars($_POST['divisi']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat">Alamat <span style="color:red">*</span></label>
                        <input type="text" id="alamat" name="alamat" placeholder="Masukkan alamat"
                               value="<?php echo isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : ''; ?>" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Simpan</button>
                        <a href="karyawan.php" class="btn-edit" style="text-decoration:none; display:inline-flex; align-items:center;">✖ Batal</a>
                    </div>
                </form>
            </div>
        </section>

        <footer class="footer">
            <p>&copy; 2026 Sistem Penjualan Toko. All rights reserved.</p>
        </footer>
    </main>
</div>
</body>
</html>
