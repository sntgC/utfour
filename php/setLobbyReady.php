<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "ut4serverdb";
	$connect = new mysqli($server,$username,$password,$database) or die("Failed to connect to the server");

	$sql = "UPDATE lobby SET isReady = $_POST[bool] WHERE userID='$_POST[userID]'";
	$result = mysqli_query($connect,$sql);

	$value = $_POST["bool"];
	if (!$result){
		die ("The SQL command was not processed correctly");
	} else{
		if($value == 1){
			echo "User is ready";
		}
		else if($value == 0){
			echo "User is not ready";
		}
	}

	mysqli_close($connect);
	exit();
?>