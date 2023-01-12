<?php

// Starting of a session
session_start();

// Connects to the database
$server = "localhost";
$username = "root";
$pass = "";

function function_alert($message)
{
    echo "<script>alert('$message');</script>";
}

$con = mysqli_connect($server, $username, $pass);
if (!$con) {
    die("Connection failure due to" . mysqli_connect_error());
}
?>