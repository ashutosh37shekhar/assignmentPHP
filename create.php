<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];

    $target_dir = "uploads/";
    $target_file = $target_dir . uniqid() . "." . strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (!empty($name) && ($imageFileType == "jpg" || $imageFileType == "png")) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $query = "INSERT INTO student (name, email, address, class_id, image) 
                      VALUES ('$name', '$email', '$address', '$class_id', '" . basename($target_file) . "')";
            if (mysqli_query($conn, $query)) {
                header("Location: index.php");
                exit();
            }
        }
    }
}

$class_query = "SELECT * FROM classes";
$class_result = mysqli_query($conn, $class_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Create Student</h1>
    <form action="create.php" method="POST" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" name="name" required>

    <label for="email">Email:</label>
    <input type="email" name="email">

    <label for="address">Address:</label>
    <textarea name="address"></textarea>

    <label for="class_id">Class:</label>
    <select name="class_id" required>
        <option value="">Select a class</option>
        <?php
        // Fetch classes from the database to populate the dropdown
        $class_query = "SELECT * FROM classes";
        $class_result = mysqli_query($conn, $class_query);
        while ($class = mysqli_fetch_assoc($class_result)) {
            echo '<option value="' . $class['class_id'] . '">' . $class['name'] . '</option>';
        }
        ?>
    </select>

    <label for="image">Upload Image:</label>
    <input type="file" name="image" accept=".jpg, .jpeg, .png">

    <button type="submit">Create Student</button>
    </form>
</body>
</html>
