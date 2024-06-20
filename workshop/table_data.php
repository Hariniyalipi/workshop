<?php
// table_data.php
include("config.php");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['table'])) {
    $tableName = $_GET['table'];

    // Database connection details (similar to edit.php)
  
    // Check the connection
   
    // Fetch data from the selected table
    $query = "SELECT * FROM $tableName";
    $result = $conn->query($query);

    // Check if data is fetched successfully
    if ($result) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        die("Error fetching data: " . $conn->error);
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle the case when the 'table' parameter is not set
    die("Table name not provided.");
}
?>

<!-- Display table data -->
<table border="1">
    <thead>
        <tr>
            <!-- Adjust column headers based on your table structure -->
            <?php foreach (array_keys($rows[0]) as $column) : ?>
                <th><?php echo $column; ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $row) : ?>
            <tr>
                <?php foreach ($row as $value) : ?>
                    <td><?php echo $value; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>