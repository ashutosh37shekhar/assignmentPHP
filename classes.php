<?php
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL root password
$database = "school_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for adding a new class
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_name = $_POST['class_name'];

    if (!empty($class_name)) {
        $stmt = $conn->prepare("INSERT INTO classes (name) VALUES (?)");
        $stmt->bind_param("s", $class_name);

        if ($stmt->execute()) {
            echo "Class added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Please enter a class name.";
    }
}

// Fetch all classes to display them
$class_query = "SELECT * FROM classes";
$class_result = $conn->query($class_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes</title>
</head>
<body>

<h2>Add a New Class</h2>
<form action="classes.php" method="POST">
    <label for="class_name">Class Name:</label>
    <input type="text" name="class_name" id="class_name" required>
    <button type="submit">Add Class</button>
</form>

<h2>Existing Classes</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Class Name</th>
        <th>Actions</th>
    </tr>
    <?php if ($class_result->num_rows > 0): ?>
        <?php while ($class = $class_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $class['class_id']; ?></td>
                <td><?php echo $class['name']; ?></td>
                <td>
                    <a href="edit_class.php?id=<?php echo $class['class_id']; ?>">Edit</a> |
                    <a href="delete_class.php?id=<?php echo $class['class_id']; ?>" onclick="return confirm('Are you sure you want to delete this class?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No classes found.</td>
        </tr>
    <?php endif; ?>
</table>

</body>
</html>

<?php
$conn->close();
?>
