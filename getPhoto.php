<?php

require "Database.php";

$db = new Database("localhost","root","150363","inmanagehw");

$imangeURL = "https://cdn2.vectorstock.com/i/1000x1000/23/81/default-avatar-profile-icon-vector-18942381.jpg";
$savePath = "C:/wamp/www/phplessons/PHPmySQL/avatar.jpg";
$imageData = file_get_contents($imangeURL);
$imageType = 'image/jpeg';
$escapedImageData = mysqli_real_escape_string($db->conn, $imageData);

$sql = "INSERT INTO image_store(image_name,image_type,image_data) VALUES ('default-avatar','$imageType','$escapedImageData')";

if($db->conn->query($sql))
{
    echo "Image stored in database";
}
else
{
    echo "Error:" .$sql. "<br>" .$db->conn->error;
}

$db->closeConnection();
?>