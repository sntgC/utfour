<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	$sql = "UPDATE users SET password='$_POST[newPasswordIn]' WHERE password='$_POST[currPasswordIn]'";
	$connection->query($sql);
	
	if($connection->affected_rows > 0){
		header("Location: ../lobby");
	}
	else{
		header("Location: ../changePassword");
	}
	
	$connection->close();
	exit();
?>