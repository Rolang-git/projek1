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

$nama    = isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : 'Admin';
$error   = '';

// Ambil ID dari URL
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header("Location: karyawan.php");
    exit;
}

$id = (int)$_GET['id'];

// Ambil data karyawan yang akan diedit
$queryKaryawan = "SELECT * FROM karyawan WHERE id_karyawan = $id";
$resultKaryawan = mysqli_query($conn, $queryKaryawan);

if(mysqli_num_rows($resultKaryawan) === 0){
    header("Location: karyawan.php?error=Karyawan tidak ditemukan");
    exit;
}

$karyawan = mysqli_fetch_assoc($resultKaryawan);

// Proses form submit
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nama_karyawan = trim(mysqli_real_escape_string($conn, $_POST['nama']));
    $no_telepon     = trim(mysqli_real_escape_string($conn, $_POST['no_telepon']));
    $divisi        = trim(mysqli_real_escape_string($conn, $_POST['divisi']));
    $alamat        = trim(mysqli_real_escape_string($conn, $_POST['alamat']));

    if(empty($nama_karyawan) || empty($divisi)){
        $error = "Nama karyawan dan divisi wajib diisi!";
    } else {
        $update = "UPDATE karyawan SET nama_karyawan='$nama_karyawan', no_telepon='$no_telepon', divisi='$divisi', alamat='$alamat' WHERE id_karyawan=$id";
        if(mysqli_query($conn, $update)){
            header("Location: karyawan.php?success=Data karyawan berhasil diperbarui");
            exit;
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Karyawan</title>
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
                <h2>Edit Karyawan</h2>
            </div>

            <div class="form-card">
                <h3>Form Edit Karyawan</h3>

                <?php if($error): ?>
                    <div class="alert-error"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label>ID Karyawan</label>
                        <input type="text" class="field-id" value="<?php echo $karyawan['id_karyawan']; ?>" readonly disabled>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama Karyawan <span style="color:red">*</span></label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama karyawan"
                               value="<?php echo htmlspecialchars(isset($_POST['nama_karyawan']) ? $_POST['nama_karyawan'] : $karyawan['nama_karyawan']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="no_telepon">No. Telepon<span style="color:red">*</span></label>
                        <input type="text" id="no_telepon" name="no_telepon" placeholder="Masukan No.Telepon"
                               value="<?php echo htmlspecialchars(isset($_POST['no_telepon']) ? $_POST['no_telepon'] : $karyawan['no_telepon']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="divisi">Divisi <span style="color:red">*</span></label>
                        <input type="text" id="divisi" name="divisi" placeholder="Masukkan nama divisi"
                               value="<?php echo htmlspecialchars(isset($_POST['divisi']) ? $_POST['divisi'] : $karyawan['divisi']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat <span style="color:red">*</span></label>
                        <input type="text" id="alamat" name="alamat" placeholder="Masukkan alamat"
                               value="<?php echo htmlspecialchars(isset($_POST['alamat']) ? $_POST['alamat'] : $karyawan['alamat']); ?>" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Simpan Perubahan</button>
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
