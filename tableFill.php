<?php

require 'Database.php';

$db = new Database("localhost","root","150363","inmanagehw");
$users = fetchData("https://jsonplaceholder.typicode.com/users");
$posts = fetchData("https://jsonplaceholder.typicode.com/posts");

//fill the users table,if we have a duplicate user id it will skip it
foreach($users as $user)
{
    $checkStmt = $db->conn->prepare("SELECT id FROM users WHERE id = ?");
    $checkStmt->bind_param("i", $user["id"]);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    if($result->num_rows === 0)
    {
        $stmt = $db->conn->prepare("INSERT INTO users (id,name,email,isActive) VALUES(?,?,?,1)");
        $stmt->bind_param("iss", $user["id"],$user["name"],$user["email"]);
        if ($stmt->execute() === false) {
            die("execute() failed: " . $stmt->error);
        }
        $stmt->close();
    }
    else
    {
        echo "User with id {$user["id"]} already exists. Skipping insert.\n";
    }

}
echo "users were inserted <br>";


//fill the posts table,if we have a duplicate post id it will skip it
foreach($posts as $post)
{
    $checkStmt = $db->conn->prepare("SELECT id FROM posts WHERE id = ?");
    $checkStmt->bind_param("i", $post["id"]);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    if($result->num_rows === 0)
    {
        $stmt = $db->conn->prepare("INSERT INTO posts (id,user_association,title,content,isActive) VALUES(?,?,?,?,1)");
        $stmt->bind_param("iiss", $post["id"],$post["userId"],$post["title"],$post["body"]);
        if ($stmt->execute() === false) {
            die("execute() failed: " . $stmt->error);
        }
    
        $stmt->close();

    }
    else
    {
        echo "Post with id {$post["id"]} already exists. Skipping insert<br>";
    }
}

echo "posts were inserted <br>";


//fetching fucntion with cURL, returns a json of the data from the URL
function fetchData($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //had a problem with the SSL verification so I disabled it,its ok for local testing
    $output = curl_exec($curl);

    if(curl_errno($curl)) {
        echo 'cURL ERROR'. curl_error($curl);
    }
    curl_close($curl);
    echo "data fetched<br>";
    return json_decode($output, true); 
}


?>