<?php
session_start();
include "../login/config.php";
global $conn;

if(!isset($_SESSION['login']) || $_SESSION['login'] !== true){
    header("Location: ../login/login.php");
    exit;
}

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login/login.php");
    exit;
}

$nama  = isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : 'Admin';
$error = '';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header("Location: barang.php");
    exit;
}

$id = (int)$_GET['id'];

$queryBarang = "SELECT * FROM barang WHERE id_barang = $id";
$resultBarang = mysqli_query($conn, $queryBarang);

if(mysqli_num_rows($resultBarang) === 0){
    header("Location: barang.php?error=Barang tidak ditemukan");
    exit;
}

$barang = mysqli_fetch_assoc($resultBarang);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nama_barang = trim(mysqli_real_escape_string($conn, $_POST['nama_barang']));
    $jenis       = trim(mysqli_real_escape_string($conn, $_POST['jenis']));
    $harga       = trim(mysqli_real_escape_string($conn, $_POST['harga']));
    $stok        = trim(mysqli_real_escape_string($conn, $_POST['stok']));

    if(empty($nama_barang) || empty($jenis) || empty($harga) || empty($stok)){
        $error = "Semua field wajib diisi!";
    } elseif(!is_numeric($harga) || $harga < 0){
        $error = "Harga harus berupa angka positif!";
    } elseif(!is_numeric($stok) || $stok < 0){
        $error = "Stok harus berupa angka positif!";
    } else {
        $update = "UPDATE barang SET nama_barang='$nama_barang', jenis='$jenis', harga='$harga', stok='$stok' WHERE id_barang=$id";
        if(mysqli_query($conn, $update)){
            header("Location: barang.php?success=Data barang berhasil diperbarui");
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
    <title>Edit Barang</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<div class="dashboard-wrapper">
    <aside class="sidebar">
        <div class="logo-section">
            <img src="../km.png" alt="Logo Karya Mandiri" class="logo-img">
            <h3>KARYA MANDIRI</h3>
        </div>
        <nav class="nav-menu">
            <a href="dashboard.php" class="nav-link"><span>🏠</span> Dashboard</a>
            <a href="barang.php" class="nav-link active"><span>🛍️</span> Barang</a>
            <a href="karyawan.php" class="nav-link"><span>🧑‍💼</span> Karyawan</a>
            <a href="laporan.php" class="nav-link"><span>📈</span> Laporan</a>
        </nav>
    </aside>

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
                <h2> Edit Barang</h2>
            </div>

            <div class="form-card">
                <h3>Form Edit Barang</h3>

                <?php if($error): ?>
                    <div class="alert-error"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label>ID Barang</label>
                        <input type="text" class="field-id" value="<?php echo $barang['id_barang']; ?>" readonly disabled>
                    </div>

                    <div class="form-group">
                        <label for="nama_barang">Nama Barang <span style="color:red">*</span></label>
                        <input type="text" id="nama_barang" name="nama_barang" placeholder="Masukkan nama barang"
                               value="<?php echo htmlspecialchars(isset($_POST['nama_barang']) ? $_POST['nama_barang'] : $barang['nama_barang']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="jenis">Jenis Bahan <span style="color:red">*</span></label>
                        <input type="text" id="jenis" name="jenis" placeholder="Masukan jenis bahan"
                               value="<?php echo htmlspecialchars(isset($_POST['jenis']) ? $_POST['jenis'] : $barang['jenis']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="harga">Harga <span style="color:red">*</span></label>
                        <div class="input-prefix">
                            <span>Rp</span>
                            <input type="number" id="harga" name="harga" placeholder="0" min="0"
                                   value="<?php echo isset($_POST['harga']) ? htmlspecialchars($_POST['harga']) : $barang['harga']; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="stok">Stok <span style="color:red">*</span></label>
                        <input type="number" id="stok" name="stok" placeholder="0" min="0"
                               value="<?php echo isset($_POST['stok']) ? htmlspecialchars($_POST['stok']) : $barang['stok']; ?>" required>
                        <span class="stok-info">
                            <?php
                            $stokLama = $barang['stok'];
                            if($stokLama > 20)      echo "Stok saat ini: $stokLama (Tersedia)";
                            elseif($stokLama > 5)   echo "Stok saat ini: $stokLama (Menipis)";
                            else                    echo "Stok saat ini: $stokLama (Kritis)";
                            ?>
                        </span>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Simpan Perubahan</button>
                        <a href="barang.php" class="btn-edit" style="text-decoration:none; display:inline-flex; align-items:center;">✖ Batal</a>
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
