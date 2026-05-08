<?php
$conn = mysqli_connect("localhost", "root", "", "karya_mandiri");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>