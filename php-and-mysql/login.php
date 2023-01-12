<?php
$err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Connecting to the database
  include 'connection.php';

  $email = $_POST['email'];
  $password = $_POST['password'];

  //Protection from SQL injection
  $email = stripcslashes($email);
  $password = stripcslashes($password);
  $email = mysqli_real_escape_string($con, $email);
  $password = mysqli_real_escape_string($con, $password);

  //Extracting the encrypted password from database for the registered email
  $sql = "SELECT `password` from `data`.`users` WHERE email = '$email'";
  $result = mysqli_query($con, $sql);

  $count = mysqli_num_rows($result);

  if ($count > 0) {
    $row = mysqli_fetch_assoc($result);

    //Checking if the password is valid or not
    $verify = password_verify($password, $row['password']);

    if ($verify) {
      //Setting session login as true
      $_SESSION['IS_LOGIN'] = true;
      $_SESSION["USER"] = $email;

      //Redirecting to the users page
      header("location:user.php?action=none");
      die();
    } else {
      $err = "Wrong password";
    }
  } else {
    $err = "Wrong email";
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
  <!-- Redirects to the Registration page -->
  <a href="index.php">
    <button class="leftbtn">Register</button>
  </a>

  <!-- Form for loging in -->
  <form class="form-container" action="login.php" method="post">
    <div class="form-field">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email">
    </div>
    <div class="form-field">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password">
    </div>
    <p>
      <?php echo $err; ?>
    </p>
    <input type="submit" value="Signin">
  </form>

</body>

</html>