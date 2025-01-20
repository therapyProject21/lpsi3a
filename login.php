<?php
// Include file koneksi
require 'transfer.php';

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomor = $_POST['nomor'];
    $password_lpsi = $_POST['password_lpsi'];

    // Query untuk mencari pengguna berdasarkan nomor
    $sql = "SELECT ID, Nama, Password_LPSI FROM Pengguna WHERE Nomor = :nomor";
    $stmt = $conn->prepare($sql);

    // Bind parameter :nomor menggunakan bindParam()
    $stmt->bindParam(':nomor', $nomor, PDO::PARAM_STR);

    // Eksekusi query
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verifikasi password
        if (password_verify($password_lpsi, $row['Password_LPSI'])) {
            // Login berhasil
            session_start();
            $_SESSION['user_id'] = $row['ID'];
            $_SESSION['user_nama'] = $row['Nama'];
            echo "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4' role='alert'>
                    <strong>Sukses!</strong> Login berhasil. Redirecting...
                  </div>";
            // Redirect ke halaman lain setelah 2 detik
            header("Refresh: 2; URL=index.php"); // Ganti dengan halaman tujuan
        } else {
            // Password salah
            echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4' role='alert'>
                    <strong>Error!</strong> Nomor atau password salah.
                  </div>";
        }
    } else {
        // Nomor tidak ditemukan
        echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4' role='alert'>
                <strong>Error!</strong> Nomor atau password salah.
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
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Nomor -->
            <div class="mb-4">
                <label for="nomor" class="block text-sm font-medium text-gray-700">Nomor</label>
                <input type="text" name="nomor" id="nomor" placeholder="Masukkan nomor anda" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password_lpsi" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password_lpsi" id="password_lpsi" placeholder="Masukkan kata sandi LPSI anda" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <input type="submit" value="Login" 
                       class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            </div>
        </form>
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Belum punya akun? <a href="reg.php" class="text-blue-500 hover:text-blue-600">Daftar di sini</a>.</p>
        </div>
    </div>
</body>
</html>