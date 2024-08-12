<?php
include('db.php');
$id = $_GET['id'];

$query = "SELECT student.*, classes.name AS class_name FROM student 
          JOIN classes ON student.class_id = classes.class_id 
          WHERE student.id = $id";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>View Student</h1>
    <p><strong>Name:</strong> <?php echo $student['name']; ?></p>
    <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
    <p><strong>Address:</strong> <?php echo $student['address']; ?></p>
    <p><strong>Class:</strong> <?php echo $student['class_name']; ?></p>
    <p><strong>Created At:</strong> <?php echo $student['created_at']; ?></p>
    <p><strong>Image:</strong> <img src="uploads/<?php echo $student['image']; ?>" width="100"></p>
    <a href="index.php">Back to Student List</a>
</body>
</html>
