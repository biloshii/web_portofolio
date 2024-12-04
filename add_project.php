<?php
ob_start(); // Mulai output buffering
include 'includes/db.php';
include 'header.php';
?>

<main>
    <h2>Add New Project</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" required>
        
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        
        <label for="image">Image:</label>
        <input type="file" name="image" required>
        
        <button type="submit" name="submit">Add Project</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        // Escape input data
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $image = $_FILES['image']['name'];
        $target_dir = "assets/images/";
        $target_file = $target_dir . basename($image);

        // Validasi apakah folder target ada
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $sql = "INSERT INTO projects (title, description, image, created_at) 
                VALUES ('$title', '$description', '$image', NOW())";

        if ($conn->query($sql) === TRUE) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                header("Location: index.php"); // Redirect ke index.php
                exit();
            } else {
                echo "<p>Failed to upload image. Please check folder permissions.</p>";
            }
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }
    ?>
</main>

<?php
include 'footer.php';
ob_end_flush(); // Akhiri output buffering
?>
