<?php
include('db.php');
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];

    $target_dir = "uploads/";
    $image = $_FILES["image"]["name"] ? uniqid() . "." . strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION)) : $_POST['old_image'];
    $target_file = $target_dir . $image;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (!empty($name) && ($imageFileType == "jpg" || $imageFileType == "png" || empty($image))) {
        if (!empty($_FILES["image"]["name"])) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        }
        $query = "UPDATE student SET name='$name', email='$email', address='$address', class_id='$class_id', image='$image' WHERE id=$id";
        if (mysqli_query($conn, $query)) {
            header("Location: index.php");
            exit();
        }
    }
}

$query = "SELECT * FROM student WHERE id=$id";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

$class_query = "SELECT * FROM classes";
$class_result = mysqli_query($conn, $class_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Student</h1>
    <form action="edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $student['name']; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $student['email']; ?>"><br>

        <label for="address">Address:</label>
        <textarea name="address"><?php echo $student['address']; ?></textarea><br>

        <label for="class_id">Class:</
