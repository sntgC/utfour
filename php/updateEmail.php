<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	$email = $_POST["emailIn"];
	$goodEmail = true;
	
	$sqlE="SELECT * FROM users WHERE email='$email'";
	$resultsE=$connection->query($sqlE);
	
	if(mysqli_num_rows($resultsE)==1){
		echo "Email is taken. ";
		$goodEmail = false;
	}
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		echo "Email is not valid. ";
		$goodEmail = false;
	}
	
	if(strlen($email) > 100){
		echo "Email is too long. ";
		$goodEmail = false;
	}
	else if(strlen($email) == 0){
		echo "Email is too short. ";
		$goodEmail = false;
	}
	
	if(!$goodEmail){
		$connection->close();
		exit();
	}
	
	$email = mysqli_real_escape_string($connection,$email);

	$sql = "UPDATE users SET email='$email' WHERE email='$_POST[currEmailIn]' AND userID='$_COOKIE[userID]'";
	$connection->query($sql);
	
	if($connection->affected_rows > 0){
		echo "Email address changed successfully";
	}
	else{
		echo "Email address change failed";
	}
	
	$connection->close();
	exit();
?>