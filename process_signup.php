<?php
// Menyertakan file koneksi database
include 'includes/db.php';

// Mengecek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data yang dikirimkan dari form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Mengenkripsi password menggunakan fungsi bcrypt (lebih aman)
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
    // Mengecek apakah username atau email sudah ada di database
    $checkQuery = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $checkResult = $conn->query($checkQuery);
    
    if ($checkResult->num_rows > 0) {
        // Jika username atau email sudah ada
        echo "Username atau email sudah terdaftar. Silakan coba yang lain.";
    } else {
        // Query untuk menyimpan data pengguna ke database
        $insertQuery = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        
        if ($conn->query($insertQuery) === TRUE) {
            // Jika berhasil, arahkan ke halaman login
            echo "Akun berhasil dibuat! Silakan <a href='login.php'>login</a>.";
        } else {
            // Jika terjadi error
            echo "Terjadi kesalahan: " . $conn->error;
        }
    }
}
?>