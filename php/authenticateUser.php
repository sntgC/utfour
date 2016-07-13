<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	$cookie_value = $_COOKIE["sessionID"];
	
	$userID = $_COOKIE["userID"];
	$sql = "SELECT sessionID FROM users WHERE userID='$userID'";
	$results = $connection->query($sql);
	$row = $results->fetch_assoc();
	
	$db_value = $row["sessionID"];
	
	if ($db_value != $cookie_value){
		include 'logoutUser.php';
	}
	
	$connection->close();
	exit();
?>