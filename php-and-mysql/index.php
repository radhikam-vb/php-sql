<?php
$firstnameerr = $lastnameerr = $emailerr = $mobilenumbererr = $passworderr = $doberr = $confirmpassworderr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $_FILES["profile"] = "";

  // Connecting to the database
  include 'connection.php';

  //Validation of the new user info
  include 'validation.php';

  //Checking if email already exists or not
  if (mysqli_num_rows(mysqli_query($con, "SELECT *from `data`.`users` WHERE email = '$email'")) > 0)
    $emailerr = "*Email already in use";

  if (!$firstnameerr && !$lastnameerr && !$emailerr && !$mobilenumbererr && !$passworderr && !$confirmpassworderr && !$doberr) {

    //Password encryption
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO `data`.`users` (`firstName`, `lastName`, `email`, `mobileNo`, `password`, `dob`, `profile`) VALUES ('$firstname', '$lastname', '$email', '$mobilenumber', '$password', '$dob', NULL);";

    // Data entry to database
    if ($con->query($sql)) {
      function_alert("User Added Successfully");
    } else {
      function_alert("ERROR: $sql <br> $con->error");
    }
  }

  $con->close();
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
  <!-- Redirects to the login page  -->
  <a href="login.php">
    <button class="leftbtn">Sign In</button>
  </a>

  <!-- Form for new user registration -->
  <form class="form-container" action="index.php" method="post">
    <div class="first-field">
      <label for="firstname">First Name:</label>
      <input type="text" id="firstname" name="firstname">
      <p>
        <?php echo $firstnameerr; ?>
      </p>
      </div>
    <div class="last-field">
      <label for="lastname">Last Name:</label>
      <input type="text" id="lastname" name="lastname">
      <p><?php echo $lastnameerr; ?></p>

    </div>
   
    <div class="form-field">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email">
      <p>
        <?php echo $emailerr; ?>
      </p>
    </div>
    <div class="form-field">
      <label for="mobilenumber">Mobile Number:</label>
      <input type="tel" id="mobilenumber" name="mobilenumber">
      <p>
        <?php echo $mobilenumbererr; ?>
      </p>
    </div>
    <div class="form-field">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password">
      <p><?php echo $passworderr; ?></p>
    </div>
    <div class="form-field">
      <label for="confirmpassword">Confirm Password:</label>
      <input type="password" id="confirmpassword" name="confirmpassword">
      <p><?php echo $confirmpassworderr; ?></p>
    </div>
    <div class="form-field">
      <label for="dob">Date of Birth:</label>
      <input type="date" id="dob" name="dob">
      <p>
        <?php echo $doberr; ?>
      </p>
    </div>
    <input type="submit" value="Register">
  </form>

</body>

</html>