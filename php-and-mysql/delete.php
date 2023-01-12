<?php
// Connecting to the database
include 'connection.php';

//Checking for the session status i.e. true or false
include 'checksession.php';

$delsno = $_REQUEST['sno'];
$pdel = $_REQUEST['pdel'];
$email = $_REQUEST['email'];

// Deleting the record from the database
$sql = "DELETE FROM `data`.`users` WHERE `sno` = $delsno";
if (!$con->query($sql)) {
    function_alert("ERROR: $sql <br> $con->error");
}

// Deleting the profile picture stored in the profile folder
if (file_exists($pdel)) {
    unlink($pdel);
}

// mySQL query to reset the primary key after deleting a record
$sql1 = "ALTER TABLE `data`. `users` AUTO_INCREMENT = $delsno";

if (!$con->query($sql1)) {
    function_alert("ERROR: $sql <br> $con->error");
}

if($email == $_SESSION['USER']){
    header("location:logout.php");
      die();
}

// Redirects to the user page
header("location:user.php?action=userdel");
die();

?>