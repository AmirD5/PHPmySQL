<?php

require "Database.php";

$db = new Database("localhost","root","150363","inmanagehw");

$userSql = "SELECT id,name,email FROM users WHERE isActive = 1";
$userResult = $db->conn->query($userSql);

$imageSql = "SELECT image_name,image_type,image_data FROM image_store LIMIT 1";
$imageResult = $db->conn->query($imageSql);
$imageRow = $imageResult->fetch_assoc();
$imageData = 'data:'. htmlspecialchars($imageRow['image_type']) . ';base64,' . base64_encode($imageRow['image_data']);

if($userResult->num_rows > 0)
{
    while($userRow = $userResult->fetch_assoc())
    {
        echo "<div class='user'>";
        echo "<h2>" . htmlspecialchars($userRow['name']) . " (" . htmlspecialchars($userRow['email']) . ")</h2>";

        echo "<img src='" . $imageData . "' alt='User Image' style='width: 100px; height: auto;' />";
        echo "</div>";

        $postsSql = "SELECT title, content, created_at FROM posts WHERE user_association = " . $userRow['id'] . " AND isActive = 1";
        $postsResult = $db->conn->query($postsSql);

        if ($postsResult->num_rows > 0)
        {
            echo "<div class='posts'>";
            while($postRow = $postsResult->fetch_assoc())
            {
                echo "<div class='post'>";
                echo "<h3>" . htmlspecialchars($postRow['title']) . "</h3>";
                echo "<p>" . htmlspecialchars($postRow['content']) . "</p>";
                echo "<p>Posted on: " . $postRow['created_at'] . "</p>";
                echo "</div>";
            }
            echo "</div>";
        }
        else
        {
            echo "<p>No posts found for this user.</p>";
        }
    }
    
}
else
{
    echo "No active users found.";
}

$db->closeConnection();


?>