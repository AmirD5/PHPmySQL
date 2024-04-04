<?php
$host = "localhost";
$user = "root";
$password = "150363";
$dbname = "inmanagehw";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get all table names in the database
$sql = "SHOW TABLES";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output each table name
    while($row = $result->fetch_array()) {
        $table = $row[0];
        echo "<h2>$table</h2>";

        // Query to get all records from the current table
        $tableQuery = "SELECT * FROM $table";
        $tableResult = $conn->query($tableQuery);

        if ($tableResult->num_rows > 0) {
            echo "<table border='1'><tr>";

            // Fetch table field names
            while ($fieldinfo = $tableResult->fetch_field()) {
                echo "<th>{$fieldinfo->name}</th>";
            }

            echo "</tr>";

            // Fetch table records
            while($tableRow = $tableResult->fetch_assoc()) {
                echo "<tr>";
                foreach($tableRow as $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
    }
} else {
    echo "0 tables found";
}

$conn->close();
?>
