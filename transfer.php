<?php
// Set konfigurasi koneksi ke database
$host = 'localhost';       // atau alamat server database Anda
$dbname = 'lpsi'; // Ganti dengan nama database Anda
$username = 'root';        // Ganti dengan username database Anda
$password = '';            // Ganti dengan password database Anda

try {
    // Membuat koneksi ke database menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set mode error PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Jika gagal koneksi
    die("Tidak bisa terhubung ke database: " . $e->getMessage());
}
?>
