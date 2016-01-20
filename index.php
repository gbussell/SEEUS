<?php  
    //require 'localhost/seeus/database/connection.php';
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Welcome to SEEUS</title>
</head>
<body>
<h1>Student Eyes and Ears for University Safety</h1>
<h2>Home</h2>
<div>
    <?php
        include 'menu.php';
    ?>
</div>
<div>
    <?php 
    if (!isset($_SESSION['eid'])) {
        echo "<p>Welcome guest</p>";
    }
    elseif ($_SESSION['eid'] == 1 | $_SESSION['eid'] == 2) {
        echo "Welcome supervisor";
    }
    else {
        echo "Welcome user";
    }

    session_unset();
    session_destroy(); 
    ?>
</div>
</body>
</html>