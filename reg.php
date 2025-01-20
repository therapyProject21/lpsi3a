<?php
// Include file koneksi
require 'transfer.php';

// Ambil data dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nomor = $_POST['nomor'];
    $password_lpsi = password_hash($_POST['password_lpsi'], PASSWORD_DEFAULT); // Hash password

    // Query untuk insert data
    $sql = "INSERT INTO Pengguna (Nama, Alamat, Nomor, Password_LPSI) VALUES (?, ?, ?, ?)";

    // Gunakan prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare($sql);

    // Eksekusi query dengan bind values
    $stmt->execute([$nama, $alamat, $nomor, $password_lpsi]);

    if ($stmt->rowCount() > 0) {
        // Redirect ke halaman login setelah registrasi berhasil
        header("Location: login.php");
        exit; // Pastikan skrip berhenti setelah redirect
    } else {
        echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4' role='alert'>
                <strong>Error!</strong> Terjadi kesalahan: " . $stmt->errorInfo() . "
              </div>";
    }

    // Tutup statement
    $stmt = null;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Form Registrasi</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Nama -->
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" placeholder="Tulis Nama Lengkap (tanpa Title)" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Alamat -->
            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <input type="text" name="alamat" id="alamat" placeholder="Tulis Kecamatan, Kota/Kabupaten"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Nomor -->
            <div class="mb-4">
                <label for="nomor" class="block text-sm font-medium text-gray-700">Nomor</label>
                <input type="text" name="nomor" id="nomor" placeholder="Tulis Nomor Telp/WA yang bisa dihubungi"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password_lpsi" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password_lpsi" id="password_lpsi" placeholder="Tulis Kata sandi Untuk Akun LPSI" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <input type="submit" value="Register" 
                       class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            </div>
        </form>
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">sudah punya akun? <a href="login.php" class="text-blue-500 hover:text-blue-600">Login di sini</a>.</p>
        </div>
    </div>
</body>
</html>