<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	$sql = "SELECT * FROM users WHERE id='$_GET[userID]'";
	$results = $connection->query($sql);
	
	$row = $results->fetch_assoc();
	echo $row["username"];
?>