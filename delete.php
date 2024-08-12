<?php
include('db.php');
$id = $_GET['id'];

// Fetch the student's image file path
$query = "SELECT image FROM student WHERE id=$id";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

if ($student) {
    $image_path = "uploads/" . $student['image'];

    // Delete the student record from the database
    $delete_query = "DELETE FROM student WHERE id=$id";
    if (mysqli_query($conn, $delete_query)) {
        // If the student is successfully deleted, also delete the image file
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        header("Location: index.php");
        exit();
    }
}
?>
