<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika tidak ada session pengguna, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Lanjutkan menampilkan halaman projects jika pengguna sudah login
include 'includes/db.php';
include 'header.php';
?>

<main>
    <h2>My Projects</h2>
    <?php
    // Kode untuk menampilkan proyek dari database
    $sql = "SELECT * FROM projects ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<h3>" . $row['title'] . "</h3>";
            echo "<p>" . $row['description'] . "</p>";
            echo "<img src='assets/images/" . $row['image'] . "' alt='" . $row['title'] . "' style='width:200px;'>";
            echo "<a href='edit_project.php?id=" . $row['id'] . "'>Edit</a> | ";
            echo "<a href='delete_project.php?id=" . $row['id'] . "'>Delete</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No projects available.</p>";
    }
    ?>
</main>

<?php include 'footer.php'; ?>