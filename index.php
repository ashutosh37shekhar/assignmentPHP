<?php include('db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Student List</h1>
    <a href="create.php">Add New Student</a>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Class</th>
                <th>Created At</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT student.*, classes.name AS class_name FROM student 
                      JOIN classes ON student.class_id = classes.class_id";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['class_name'] . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "<td><img src='uploads/" . $row['image'] . "' width='50'></td>";
                echo "<td>
                        <a href='view.php?id=" . $row['id'] . "'>View</a> | 
                        <a href='edit.php?id=" . $row['id'] . "'>Edit</a> | 
                        <a href='delete.php?id=" . $row['id'] . "'>Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
