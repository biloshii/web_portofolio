<?php
session_start();
include 'includes/db.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi username dan password di database
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Pengguna ditemukan, simpan informasi ke sesi
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        // Arahkan ke halaman projects
        header("Location: projects.php");
        exit();
    } else {
        // Jika username atau password salah
        echo "Invalid username or password!";
    }
}
?>