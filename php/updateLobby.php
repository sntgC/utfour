<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	$sql = "INSERT INTO lobby (userID)
	VALUES ('$_POST[id]')";

	if ($connection->query($sql)){
		echo "( ͡° ͜ʖ ͡°)";
	}else{
		echo "¯\_(ツ)_/¯";
	}
	
	$connection->close();
	exit();
?>