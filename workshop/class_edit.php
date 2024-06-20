<?php
include("config.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle insert operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["insert"])) {
    $t_id = $_POST["t_id"];
    $d_id = $_POST["d_id"];
    $hours = $_POST["hours"];
    $insertQuery = "INSERT INTO class (teacher_id, dept_id, hours ) 
                    VALUES ('$t_id', '$d_id', $hours)";
    
    if ($conn->query($insertQuery) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . $conn->error;
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
    <title>Class Edit</title>
    <link rel="stylesheet"href="editall.css">
</head>
<body>
  <div class="container">
    <h2>Class Edit</h2>
    <div class="action-buttons">
        <button onclick="showForm('insertForm')">Insert</button>
    </div>
    <!-- Insert Form -->
    <form id="insertForm" class="active" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h3>Insert Row</h3>
        <label for="t_id">Teacher ID:</label>
        <input type="number" id="t_id" name="t_id" required>

        <label for="d_id">Department ID:</label>
        <input type="number" id="d_id" name="d_id" required>

        <label for="hours">Hours:</label>
        <input type="number" id="hours" name="hours" required>

        <button type="submit" name="insert">Insert</button>
    </form>


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
