<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	$sql = "INSERT INTO users (username, password)
	VALUES ('$_POST[usernameIn]','$_POST[passwordIn]')";

	if ($connection->query($sql)===TRUE){
		header("Location: ../login.html");
	}else{
		header("Location: ../register.html");
	}
	
	$connection->close();
	exit();
?>