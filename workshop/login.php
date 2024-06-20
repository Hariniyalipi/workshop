<?php

include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate user input (you can add more validation as needed)
    if (empty($email) || empty($password)) {
        echo '<p class="error">Please enter both email and password.</p>';
    } else {
        // Query to check if the user exists and the password is correct
        $sql = "SELECT * FROM user_table WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User exists, check user type
            $user = $result->fetch_assoc();
            if ($user['usertype'] == 'student') {
                // Redirect to user page (replace with your user page URL)
               
                header("Location: student.php");
                exit();
            } elseif ($user['usertype'] == 'admin') {
                // Redirect to admin page (replace with your admin page URL)
                
                header("Location: edit.php");
                exit();
            } 
            elseif ($user['usertype'] == 'teacher') {
                // Redirect to admin page (replace with your admin page URL)
                
                header("Location: teacher.php");
                exit();
            } 
            else {
                // Invalid user type
                echo '<p class="error">Invalid user type.</p>';
            }
        } else {
            // User doesn't exist or incorrect password
            echo '<p class="error">Incorrect email or password. Please try again.</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div class="content">
 <div class="text">Login Form</div>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="field">
      <span class="fa fa-user"></span>
      <input type="text" name="email"placeholder="Email Id" required>
   
    </div>
    <div class="field">
      <span class="fa fa-lock"></span>
      <input type="password" placeholder="Password"name="password"><br><br><br>
   
    </div>
        <button>Log in</button> 
        </form>
       
      
    
</div>
</body>
</html>