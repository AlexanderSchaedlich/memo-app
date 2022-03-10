<?php  
    $dbHost = "localhost";
    $dbUser = "web90_2";
    $dbPassword = "49PWZfpbSOygQjF8";
    $dbName = "web90_db2";
    $dbPort = "3306";

	// establish a connection with the database
	$dbConnection = new mysqli($dbHost, $dbUser, $dbPassword, $dbName, $dbPort);
	
	if ($dbConnection->connect_error) {
	    die("Connection failed: " . $dbConnection->connect_error);
	}
?>