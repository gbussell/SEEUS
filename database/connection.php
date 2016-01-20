<?php
#--Local Database Info--
$DB_NAME = 'seeusdb';
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
	
$con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 

#--Real Databse Info--
#$DB_NAME = 'a6995183_SEEUS';
#$DB_HOST = 'mysql7.000webhost.com';
#$DB_USER = 'a6995183_Admin';
#$DB_PASS = 'seeusdevelopment1';
?>