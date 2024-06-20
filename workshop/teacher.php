<?php
// Connect to database
include("config.php");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['teacher_id']) && !isset($_POST['view_students'])) {
        // Step 1: Display teacher details
        $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);

        // Query to retrieve teacher details
        $query = "SELECT * FROM teacher WHERE teacher_id = '$teacher_id'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "Teacher ID: " . $row["teacher_id"] . "<br>";
                echo "Name: " . $row["t_name"] . "<br>";
                echo "Age: " . $row["age"] . "<br>";
            }

            // Display view button to access student details
            echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'>";
            echo "<input type='hidden' name='teacher_id' value='$teacher_id'>";
            echo "<input type='submit' name='view_students' value='View Students'>";
            echo "</form>";
        } else {
            echo "No teacher found with ID $teacher_id";
        }
    } elseif (isset($_POST['view_students'])) {
        // Step 2: Display students associated with the teacher
        $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);

        // Query to retrieve student details
        $query = "
            SELECT s.student_id, s.name 
            FROM student s 
            JOIN class c ON s.dept_id = c.dept_id 
            JOIN teacher t ON t.teacher_id = c.teacher_id 
            WHERE t.teacher_id = '$teacher_id'
        ";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Student ID</th><th>Name</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["student_id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No students found for teacher ID $teacher_id";
        }
    }
} else {
    // Display form to input teacher_id
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="teacher_id">Enter Teacher ID:</label>
        <input type="text" id="teacher_id" name="teacher_id">
        <input type="submit" value="Submit">
    </form>
    <?php
}

// Close connection
mysqli_close($conn);
?>
