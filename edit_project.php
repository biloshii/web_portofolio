<?php
// Mulai output buffering untuk menangani header setelah output HTML
ob_start(); // Menambahkan output buffering

include 'includes/db.php'; 
include 'header.php'; 
?>

<main>
    <h2>Edit Project</h2>
    <?php
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $sql = "SELECT * FROM projects WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "<p>Project not found.</p>";
            exit;
        }
    }

    if (isset($_POST['update'])) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);

        $sql = "UPDATE projects SET title='$title', description='$description' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            ob_end_clean(); // Bersihkan buffer sebelum redirect
            header("Location: index.php");
            exit;
        } else {
            echo "<p>Error updating project: " . $conn->error . "</p>";
        }
    }
    ?>

    <form action="" method="POST">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($row['title'], ENT_QUOTES); ?>" required>
        
        <label for="description">Description:</label>
        <textarea name="description" required><?= htmlspecialchars($row['description'], ENT_QUOTES); ?></textarea>
        
        <button type="submit" name="update">Update Project</button>
    </form>
</main>

<?php
include 'footer.php'; 
?>
