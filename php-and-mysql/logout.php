<?php
// Connects to the database
include 'connection.php';

// Sets the session status as false and redirects to the login page
unset($_SESSION['IS_LOGIN']);
header("location:login.php");
die();

?>