<?php
include ('../../database/dbconnect.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data=json_decode(file_get_contents("php://input"),true);
$userId = $data["userId"];

$sql = "select * from userdetails where UserId = '$userId';";
// var_dump($sql);
$result = $conn->query($sql);

$user= $result->fetch_assoc();
if($user){
    if($user["Image"]){
        $user["image"]=base64_encode($user["Image"]);
    }
    else{
        $user["image"]=null;
    }

    if($user["Resume"]){
        $user["resume"]=base64_encode($user["Resume"]);
    }
    else{
        $user["resume"]=null;
    }

    unset($user["Image"]);
    unset($user["Resume"]);

    header('Content-Type: application/json');
    echo json_encode($user);
}
else{
    echo json_encode([]);
}

$conn->close();
