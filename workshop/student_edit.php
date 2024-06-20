<?php
include("config.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle insert operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["insert"])) {
    $s_id = $_POST["s_id"];
    $name = $_POST["name"];
    $d_id = $_POST["d_id"];
    

    $insertQuery = "INSERT INTO student (student_id, name, dept_id) 
                    VALUES ('$s_id', '$name', '$d_id')";
    
    if ($conn->query($insertQuery) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . $conn->error;
    }
}

// Handle delete operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $s_idToDelete = $_POST["s_idToDelete"];

    $deleteQuery = "DELETE FROM student WHERE s_id = '$s_idToDelete'";
    
    if ($conn->query($deleteQuery) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editall.css">
    <title>Student Edit</title>
</head>
<body>
<div class="container">
    <h2>Student Edit</h2>
    <div class="action-buttons">
        <button onclick="showForm('insertForm')">Insert</button>
        <button onclick="showForm('deleteForm')">Delete</button>
    </div>

    <!-- Insert Form -->
    <form id="insertForm" class="active" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h3>Insert Row</h3>
        <label for="s_id">Student ID:</label>
        <input type="number" id="s_id" name="s_id" required>

        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>

        <label for="d_id">Department ID:</label>
        <input type="number" id="d_id" name="d_id" required>

        
        <button type="submit" name="insert">Insert</button>
    </form>

    <!-- Delete Form -->
    <form id="deleteForm" class="active"method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h3>Delete Row</h3>
        <label for="s_idToDelete">Student ID to Delete:</label>
        <input type="text" id="s_idToDelete" name="s_idToDelete" required>

        <button type="submit" name="delete">Delete</button>
    </form>
    </div>

    <script>
        function showForm(formId) {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                if (form.id === formId) {
                    form.classList.add('active');
                } else {
                    form.classList.remove('active');
                }
            });
        }
    </script>
</body>
</html>
