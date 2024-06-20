<?php
// Connect to database
include("config.php");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Check if student_id is set
if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    // Query to retrieve student details
    $query = "SELECT * FROM student WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "ID: " . $row["student_id"] . "<br>";
            echo "Name: " . $row["name"] . "<br>";
            echo "Dept ID: " . $row["dept_id"] . "<br>";
        }
    } else {
        echo "No student found with ID $student_id";
    }
} else {
    // Display form if student_id is not set
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="student_id">Enter Student ID:</label>
        <input type="text" id="student_id" name="student_id">
        <input type="submit" value="Submit">
    </form>
    <?php
}

// Close connection
mysqli_close($conn);
?>
