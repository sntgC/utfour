<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	/* $¢ Change this to POST when you figure out how to do it with ajax */
	$sql = "INSERT INTO tournaments (id, data) VALUES ('$_POST[tourID]','$_POST[tourData]')";

	if ($connection->query($sql)===TRUE){
		echo "Data succesfully inputted";
	}else{
		echo "Something seems to have gone wrong";
	}
	
	$connection->close();
	exit();
?>