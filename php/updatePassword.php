<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	if(strlen($_POST['newPasswordIn']) < 6){
		echo "New password is too short. ";
		$connection->close();
		exit();	
	}
	else if(strlen($_POST['newPasswordIn']) > 20){
		echo "New password is too long. ";
		$connection->close();
		exit();
	}
	
	$sql = "UPDATE users SET password='$_POST[newPasswordIn]' WHERE password='$_POST[currPasswordIn]' AND userID='$_COOKIE[userID]'";
	$connection->query($sql);
	
	if($connection->affected_rows > 0){
		echo "Password change successful";
	}
	else{
		echo "Password change failed";
	}
	
	$connection->close();
	exit();
?>