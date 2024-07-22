<?php
session_start();
if(!isset($_SESSION['login']))
{
    header('location:../login.php');
    exit;
}
$conn = mysqli_connect("localhost","root","","recruitment_portal");
if($conn->connect_error){
    die ("connection failed" . $conn->connect_error);
}

$type = $_POST['type'];
$sno = $_POST['sno'];

//updated notification_send to zero
if($type === 'softlock'){
    $sql = "UPDATE softlock_data SET notification_send = 0 WHERE sno='$sno'";
}elseif($type === 'confirm'){
    $sql = "UPDATE confirm_data SET notification_send = 0 WHERE sno='$sno'";
}

if($conn->query($sql)===TRUE){
    echo "notification removed successfully";
}else{
    echo "Error updating record: ". $conn->error;
}
$conn->close();
?>