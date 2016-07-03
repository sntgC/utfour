<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	$cookie_value = $_COOKIE["userID"];
	
	$sql = "SELECT * FROM users WHERE userID='$cookie_value'";
	$results = $connection->query($sql);
	
	$row = $results->fetch_assoc();
	echo $row["username"] . '(' . $row["wins"] . ')';
?>