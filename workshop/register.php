<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet"href="register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <?php
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
     include('config.php');
       
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve form data
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $usertype = $_POST['usertype'];

        // Check if passwords match
        if ($password !== $confirm_password) {
            echo '<p class="error">Error: Passwords do not match.</p>';
            exit();
        }
        // Check if email already exists
        $check_email_sql = "SELECT * FROM user_table WHERE email = '$email'";
        $check_result = $conn->query($check_email_sql);
        if ($check_result->num_rows > 0) {
            echo '<p class="error">Error: Email already exists.</p>';
            header('Location:register.php');
            exit();
        }
        // Prepare SQL statement to insert data into database
        $sql = "INSERT INTO user_table (name, usertype, email, password) VALUES ('$username','$usertype','$email', '$password')";

        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
            header("Location:login.php");
            exit();
        } else {
            echo '<p class="error">Error: " . $sql . "<br>" . $conn->error</p>';
        }

        // Close database connection
        $conn->close();
    }
    ?>
<div class="content">
    <div class="text">Register form</div>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="field">
        <span class="fas fa-user-alt"></span>
        <input type="text" id="username" name="username" placeholder="Username" required><br><br>
     </div>
     <div class="field">
        <span class="fas fa-envelope"></span>
        <input type="email" id="email" name="email" placeholder="Email" required><br><br>
     </div>
     <div class="field">
        <span class="fas fa-lock"></span>
        <input type="password" id="password" name="password" placeholder="Password" required><br><br>
     </div>
     <div class="field">
        <span class="fas fa-lock"></span>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password " required><br><br>
     </div>
     <div class="field">
        <span class="fas fa-users"></span>
        <select id="usertype" name="usertype" required>
            <option value="">Select User Type</option>
            <option value="admin">Admin</option>
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>

        </select><br><br>
     </div>   
       <button>Register</button>
    </form>
</div>
</body>
</html>
