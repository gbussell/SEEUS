<?php  
    require 'database/connection.php';
    $logInError = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $result = $con->query("select Password, EID from users where Email = '".$_POST['email']."' LIMIT 1");
        $row = mysqli_fetch_assoc($result);
        if ($result->num_rows == 0 | $_POST['password'] != $row['Password'])
            $logInError = "Incorrect email and/or password";
        else {
            session_start();
            $_SESSION['eid'] = $row['EID'];
            header('Location: index.php');
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
<h2>Login</h2>
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
		<input type="text" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email'];?>">
		<br>
		Password:<br>
		<input type="password" name="password" value="<?php if (isset($_POST['password'])) echo $_POST['password']?>">
		<br>
		<input type="submit" value="logIn">
        <br> <span class=error><?php echo $logInError?></span>
	</form>
</div>

</body>
</html>