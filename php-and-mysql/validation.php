<?php

// Validates the First Name field for numbers or empty
if (empty($_POST["firstname"])) {
    $firstnameerr = "* First Name is required";
} else {
    $firstname = $_POST['firstname'];
    if (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
        $firstnameerr = "*Only alphabets and white<br> space are allowed";
    }
}

// Validates the Last Name
if (empty($_POST["lastname"])) {
    $lastnameerr = "*Last Name is required";
} else {
    $lastname = $_POST['lastname'];
    if (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
        $lastnameerr = "*Only alphabets and white<br> space are allowed";
    }
}

// Validates the email
if (empty($_POST["email"])) {
    $emailerr = "*Email is required";
} else {
    $email = $_POST["email"];
}

// Validates the mobile number
if (empty($_POST["mobilenumber"])) {
    $mobilenumbererr = "*Mobile Number is required";
} else {
    $mobilenumber = $_POST["mobilenumber"];
    if (!preg_match('/^[0-9]{10}+$/', $mobilenumber)) {
        $mobilenumbererr = "*Only numeric value is allowed.";
    }

    if (strlen($mobilenumber) != 10) {
        $mobilenumbererr = "*Mobile Number must contain 10 digits.";
    }
}

// Validates the Password strength
if (!empty($_POST["password"])) {
    if ($_POST["password"] && $_POST["confirmpassword"] && $_POST["password"] == $_POST["confirmpassword"]) {
        $password = $_POST['password'];
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            $passworderr = '*Password should be at least 8 <br>characters in length and should <br>include at least one upper case<br> letter, one number, and one <br>special character.';
        }
    } else {
        $confirmpassworderr = "*Passwords do not match.";
    }
}

// Validates the DOB
if (empty($_POST["dob"])) {
    $doberr = "*Date of Birth is required";
} else {
    $dob = $_POST['dob'];
}

// Validates the Porfile picture extension
if ($_FILES["profile"] && $_FILES["profile"]["name"]) {
    $profile = $_FILES['profile'];
    
    $profilename = $profile['name'];
    $profileerror = $profile['error'];
    $profiletmp = $profile['tmp_name'];

    $profileext = explode('.', $profilename);
    $profilecheck = strtolower(end($profileext));

    $validext = array('png', 'jpg', 'jpeg');

    if (!in_array($profilecheck, $validext)) {
        $profileerr = "Image not valid";
    }
}else{
    $profilename = "";
}
?>