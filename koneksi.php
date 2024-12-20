<?php
// Konfigurasi database
$host = "localhost";        // Host database
$username = "root";         // Username database
$password = "";             // Password database (kosong jika default)
$database = "dbnota"; // Nama database

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Pesan jika koneksi berhasil
// echo "Koneksi berhasil";
?>
