<?php
require 'C:\wamp\www\seeus\database/connection.php';
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
</head>
<body>
<h1>Student Eyes and Ears for University Safety</h1>
<h2>Request an Escort</h2>
<div>
	<ul>
		<li><a href = "index.php">Home</a></li>
		<li><a href = "login.php">Login</a></li>
		<li><a href = "register.php">Register</a></li>
		<li><a href = "guest.php">Continue as guest</a></li>
	</ul>
</div>
<div>
	<form>
		EID:<br>
		E<input type="text" name="eid">
		<br>
        First Name:<br>
        <input type="text" name="firstName">
        <br>
        Last Name:<br>
        <input type="text" name="lastName">
        <br>
		Number in Party:<br>
		<input type="text" name="numberInParty">
		<br>
		Location:<br>
		<input type="text" name="location">
		<br>
		Destination:<br>
		<input type="text" name="destination">
		<br>
        Comments:<br>
		<input type="text" name="comments">
		<br>
		Phone Number:<br>
		<input type="text" name="phoneNumber">
		<br>
		Time Requested:<br>
		<input type="number" name="hour" min="1" max="12">:<input type="number" name="minute" min="00" max="59"> 
        <select name="am/pm" id="timeOfDay"><option value="pm"">PM</option><option value="am">AM</option></select> on <span id="dateRequested"></span>
		<br>
		<input type="submit" value="Submit">
	</form>
</div>
<script>
    
function getDateRequested() {
    
}
if (document.getElementById("timeOfDay").value == "am") {
    dayNotification = document.getElementById("dayRequested");
    dayNotification.innerHTML = "Hello";
}
</script>
</body>
</html>