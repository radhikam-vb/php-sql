<?php
// Connecting to the database
include 'connection.php';

//Checking fot the session status i.e. true or false
include 'checksession.php';

if($_REQUEST['action'] == 'userdel'){
    function_alert("User has been deleted.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>

<body>
    <!-- Logging out from the page -->
    <a href="logout.php">
        <button class="leftbtn">Logout</button>
    </a>

    <h1>Registered Users</h1>
    <?php
    
    // Extracting required info from the database 
    $result = mysqli_query($con, "SELECT `sno`, `profile`, `firstName`,`email`, `dob` FROM `data`.`users`");
    $all_property = array();

    // Creating the table of the existing registered users
    echo '<table class="data-table">
                <tr class="data-heading">';
    while ($property = mysqli_fetch_field($result)) {
        echo '<td>' . strtoupper($property->name) . '</td>';
        $all_property[] = $property->name;
    }
    echo '</tr>';

    while ($row = mysqli_fetch_array($result)) {
        echo '<tr class="data">';
        foreach ($all_property as $item) {
            if ($item == 'email')
                    $email = $row[$item];
            if ($item == 'profile') {
                $pdel = $row[$item];
                echo "<td><img class='userprofile' src= ";
                if (!$row[$item]) {
                    echo "profiles/default.jpg";
                } else {
                    echo $row[$item];
                }
                echo "></td>";
            } else {
                echo '<td>' . $row[$item] . '</td>';
            }
            if ($item == 'sno') {
                $editlink = "edit.php?sno=$row[$item]";
                $deletelink = "delete.php?sno=$row[$item]";
            }
        }
        // Buttons for editing or deleting the record
        echo "<td><a href=$editlink><button class='mid'>Edit</button></a></td</tr>";
        echo "<td><a href=$deletelink&pdel=$pdel&email=$email><button class='delmid'>Delete</button></a></td</tr>";
    }
    echo "</table>";
    ?>
</body>

</html>