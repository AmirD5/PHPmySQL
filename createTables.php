<?php

$host = "localhost";
$user = "root";
$password = "150363";
$dbname = "inmanagehw";

$conn = new mysqli($host,$user,$password,$dbname);
if($conn->connect_error)
{
    die("Connection error" .$conn->connect_error);
}

$sql = "CREATE TABLE users(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    isActive TINYINT(1) NOT NULL DEFAULT 1
    )
";

createTable($sql,$conn);

$sql = "CREATE TABLE posts(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_association INT(6) UNSIGNED NOT NULL,
    title VARCHAR(50) NOT NULL,
    content VARCHAR(1000) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    isActive TINYINT(1) NOT NULL DEFAULT 1
)";

createTable($sql,$conn);

$sql = "CREATE TABLE image_store (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_name VARCHAR(255) NOT NULL,
    image_type VARCHAR(50) NOT NULL,
    image_data LONGBLOB NOT NULL
)";

createTable($sql,$conn);


function createTable($sql,$conn)
{
    if($conn->query($sql) === TRUE)
    {
        echo "Table created!" ."<br>";
    }
else
{
    echo "Error creating table:" .$conn->error ."<br>";
}
}


$conn->close();

?>