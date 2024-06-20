<?php
include("config.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch table names from the database
$query = "SHOW TABLES";
$result = $conn->query($query);

// Check if tables are fetched successfully
if ($result) {
    $tables = $result->fetch_all();
} else {
    die("Error fetching tables: " . $conn->error);
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit.css">
    <title>Edit Tables</title>
    
</head>
<body>
    <h1>Edit Tables</h1>

    <div id="container">
        <div id="table-list">
            <h2>List of Tables:</h2>
            <ul>
                <?php
                    foreach ($tables as $table) {
                        $tableName = $table[0];
                        echo "<li><a class='table-link' onclick='loadTable(\"$tableName\")'>$tableName</a></li>";
                    }
                ?>
            </ul>
        </div>

        <div id="table-data">
            <h2>Table Data:</h2>
            <div id="table-content">
                <!-- Table data will be dynamically loaded here -->
            </div>
        </div>
    </div>

    <script>
        function loadTable(tableName) {
            // Use AJAX to fetch and display table data dynamically
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("table-content").innerHTML = this.responseText;

                    // Add "Edit" button dynamically
                    document.getElementById("table-content").innerHTML +=
                        "<div class='edit-button'>" +
                        "<a href='" + tableName + "_edit.php'>Edit</a>" +
                        "</div>";
                }
            };
            xhttp.open("GET", "table_data.php?table=" + tableName, true);
            xhttp.send();
        }
    </script>
</body>
</html>