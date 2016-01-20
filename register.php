<?php
require 'database/connection.php';
$emailError = $passwordError = $firstNameError = $lastNameError = $eidError = $phoneNumberError = "";
function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //Error checking to validate data entered by user
        
    //Email error check
    if (empty($_POST['email']))
        $emailError = "A email is required.";
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        $emailError = "Invalid email";
	elseif ($con->query("SELECT Email from users WHERE Email = '".$_POST['email']."' LIMIT 1")->num_rows == 1) 
        $emailError = "This email is already registered.";
    else {
        $emailError = "";
        $email = testInput($_POST['email']);
    }
    
    //Password error check
    if ($_POST['password'] != $_POST['passwordConfirm'])
            $passwordError = "The passwords you entered do not match.";
    elseif (empty($_POST['password']))
            $passwordError = "A password is required.";
    elseif (strlen($_POST['password']) < 5 | strlen($_POST['password']) > 30)
            $passwordError = "Your password must be 5-30 characters long.";
    elseif (!ctype_alnum($_POST['password']))
            $passwordError = "Your password must only contain numbers and letters."; 
    else {
            $passwordError = "";
            $password = testInput($_POST['password']);
    }
    
    //First name error check
    if (empty($_POST['firstName']))
        $firstNameError = "Your first name is required";
    elseif ((!preg_match("#^[a-zA-Z ]+$#", $_POST['firstName']) | strlen($_POST['firstName']) < 2))
        $firstNameError = "Invalid first name";
    else {
        $firstNameError = "";
        $firstName = testInput($_POST['firstName']);
    }
       
    //Last name error check
    if (empty($_POST['lastName']))
        $lastNameError = "Your last name is required";
    elseif ((!preg_match("#^[a-zA-Z ]+$#", $_POST['lastName']) | strlen($_POST['lastName']) < 2))
        $lastNameError = "Invalid last name";
    else {
        $lastNameError = "";
        $lastName = testInput($_POST['lastName']);
    }
    
    //EID error check
    if (empty($_POST['eid']))
        $eidError = "Your EID is required";
    elseif (strlen($_POST['eid']) != 8 | !(is_numeric($_POST['eid'])))
        $eidError = "Invalid EID";
    elseif ($con->query("SELECT EID from users WHERE EID = '".$_POST['eid']."' LIMIT 1")->num_rows == 1) 
        $eidError = "This EID is already registered.";
    else {
        $eidError = "";
        $eid = testInput($_POST['eid']);
    }
    
    //Phone number error check
    if (!is_numeric($_POST['phoneNumber']) & !empty($_POST['phoneNumber']) | !empty($_POST['phoneNumber']) & strlen($_POST['phoneNumber']) != 10)
        $phoneNumberError = "Invalid phone number";
    else {
        $phoneNumberError = "";
        $phoneNumber = testInput($_POST['phoneNumber']);
        }

    //If errors are clear, send data to the database
    if ($emailError == "" & $passwordError == "" & $firstNameError == "" & $lastNameError == "" & $eidError == "" & $phoneNumberError == "") {
        date_default_timezone_set("America/Detroit");
        $timeStamp = date("Y-m-d H:i:s");
        $sql = "INSERT INTO users (EID, email, Password, FirstName, LastName, PhoneNumber, DateTimeCreated) 
        VALUES ('".$eid."', '".$email."', '".$password."', '".$firstName."', '".$lastName."', '".$phoneNumber."', '".$timeStamp."')";
        $con->query($sql);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Welcome to SEEUS</title>
<style>
    .error {
        color: red;
    }
</style>    
</head>
<body>
<h1>Student Eyes and Ears for University Safety</h1>
<h2>Register</h2>
<div>
	<ul>
		<li><a href = "index.php">Home</a></li>
		<li><a href = "login.php">Login</a></li>
		<li><a href = "register.php">Register</a></li>
		<li><a href = "guest.php">Continue as guest</a></li>
	</ul>
</div>
<div>
	<form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		Email:<br>
		<input type="text" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email'];?>"><span class=error>*<?php echo $emailError?></span>
		<br> 
		Password:<br>
		<input type="password" name="password" value="<?php if (isset($_POST['password'])) echo $_POST['password']?>"><span class=error>*<?php echo $passwordError?></span>
		<br>
		Confirm Password:<br>
		<input type="password" name="passwordConfirm" value="<?php if (isset($_POST['passwordConfirm'])) echo $_POST['passwordConfirm']?>"><span class=error>*</span>
		<br>
		First Name:<br>
		<input type="text" name="firstName" value="<?php if (isset($_POST['firstName'])) echo $_POST['firstName']?>"><span class=error>*<?php echo $firstNameError?></span>
		<br>
		Last Name:<br>
		<input type="text" name="lastName" value="<?php if (isset($_POST['lastName'])) echo $_POST['lastName']?>"><span class=error>*<?php echo $lastNameError?></span>
		<br>
		EID:<br>
		E<input type="text" name="eid" value="<?php if (isset($_POST['eid'])) echo $_POST['eid']?>"><span class=error>*<?php echo $eidError?></span>
		<br>
		Phone Number: <br>
		<input type="text" name="phoneNumber" value="<?php if (isset($_POST['phoneNumber'])) echo $_POST['phoneNumber']?>"><span class=error> <?php echo $phoneNumberError?></span>
		<br>
		<input type="submit" value="Register">
	</form>
</div> 
</body>
</html>