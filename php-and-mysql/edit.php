<?php
// Connecting to the database 
include 'connection.php';

//Checking for the session status i.e. true or false
include 'checksession.php';


$data = $firstnameerr = $lastnameerr = $emailerr = $mobilenumbererr = $passworderr = $doberr = $profileerr = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validating the data edited by the user
    include 'validation.php';

    if (!$firstnameerr && !$lastnameerr && !$emailerr && !$mobilenumbererr && !$passworderr && !$doberr && !$profileerr) {
        $newfirstname = $_POST["firstname"];
        $newlastname = $_POST["lastname"];
        $newemail = $_POST["email"];
        $newmobileNo = $_POST["mobilenumber"];
        $newdob = $_POST["dob"];
        $newprofile = "";

        // Storing the uploaded photo in the profiles folder
        if ($profilename) {
            $newprofile = "profiles/" . $profilename;
            move_uploaded_file($profiletmp, $newprofile);
        }

        // Updating the record in the database using the sno passed from the users page 
        $id = $_REQUEST["sno"];
        if ($newprofile) {
            $sql = "UPDATE `data`.`users` SET `firstName` = '$newfirstname', `lastName` = '$newlastname', `email` = '$newemail', `mobileNo` = '$newmobileNo', `dob` = '$newdob', `profile` = '$newprofile'  WHERE `users`.`sno` = $id;";
        } else {
            $sql = "UPDATE `data`.`users` SET `firstName` = '$newfirstname', `lastName` = '$newlastname', `email` = '$newemail', `mobileNo` = '$newmobileNo', `dob` = '$newdob'  WHERE `users`.`sno` = $id;";
        }

        if ($con->query($sql)) {
            function_alert("User Updated Successfully");
        } else {
            function_alert("ERROR: $sql <br> $con->error");
        }
    }
}

// Showing the existing data in the databse to the user
$sno = $_REQUEST["sno"];
$result = mysqli_query($con, "SELECT * FROM `data`.`users` WHERE `sno` = $sno");

$emparray = array();
while ($row = mysqli_fetch_assoc($result))
    $emparray[] = $row;

$data = json_decode(json_encode($emparray[0]));

$firstName = $data->firstName;
$lastName = $data->lastName;
$email = $data->email;
$mobileNo = $data->mobileNo;
$dob = $data->dob;
if ($data->profile)
    $profile = $data->profile;

$con->close();
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

    <!-- Redirects to the all users page -->
    <a href="user.php?action=none">
        <button class="leftbtn">All Users</button>
    </a>

    <!-- Form containing the user info  -->
    <form class="form-container" action="edit.php<?php echo "?sno=" . $sno; ?>" method="post"
        enctype="multipart/form-data">
        <?php
        if ($data->profile) {
            echo "<img style = 'width: 23vh;
                    height: 23vh;
                    border-radius: 90px;' 
                    src = $profile >";
        }
        ?>
        <div class="form-field">
            <label for="firstname" style="text-align: center">First Name</label>
            <input type="text" id="firstname" name="firstname" style="text-align: center; margin: auto" value=<?php echo "$firstName" ?>>
            <p>
                <?php echo $firstnameerr; ?>
            </p>
        </div>
        <div class="form-field">
            <label for="lastname" style="text-align: center">Last Name</label>
            <input type="text" id="lastname" name="lastname" style="text-align: center" value=<?php echo "$lastName" ?>>
            <p>
                <?php echo $lastnameerr; ?>
            </p>
        </div>
        <div class="form-field">
            <label for="email" style="text-align: center">Email</label>
            <input type="email" id="email" name="email" style="text-align: center" value=<?php echo "$email" ?>>
            <p>
                <?php echo $emailerr; ?>
            </p>
        </div>
        <div class="form-field">
            <label for="mobilenumber" style="text-align: center">Mobile Number</label>
            <input type="tel" id="mobilenumber" name="mobilenumber" style="text-align: center" value=<?php echo "$mobileNo" ?>>
            <p>
                <?php echo $mobilenumbererr; ?>
            </p>
        </div>
        <div class="form-field">
            <label for="dob" style="text-align: center">Date of Birth</label>
            <input type="date" id="dob" name="dob" style="text-align: center" value=<?php echo "$dob" ?>>
            <p>
                <?php echo $doberr; ?>
            </p>
        </div>
        <!-- Option to upload or change the profile picture -->
        <div class="form-field">
            <label for="profile" style="text-align: center">Edit Profile Picture</label>
            <input type="file" id="profile" name="profile">
            <p>
                <?php echo $profileerr; ?>
            </p>
        </div>
        <input type="submit" value="Update">

    </form>
</body>

</html>