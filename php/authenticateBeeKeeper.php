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
	
	//This is added in order to get the username from a js file. It will not affect any previous functionality
	//Only runs if the file is called using POST, not include
	if($row['beekeeper']==='1'){
		echo 'Begin Tournament';
	}else{
		echo 'false';
	}
?>