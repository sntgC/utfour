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
		unset($_COOKIE["userID"]);
		setcookie("userID","",time() - (86400*366),"/");
		unset($_COOKIE["sessionID"]);
		setcookie("sessionID","",time() - (86400*366), "/");
	}
	
	$connection->close();
	exit();
?>