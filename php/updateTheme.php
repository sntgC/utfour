<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");

	$sql = "SELECT theme FROM users WHERE userID='$_COOKIE[userID]'";
	$results = $connection->query($sql);
	$row = $results->fetch_assoc();

	$dbcolor = $row["theme"];
    $color = $_POST["colorSelector"];

	if($dbcolor == $color){
		echo "This color is already your theme color.";
		$connection->close();
		exit();
	}
	else{
		$sql = "UPDATE users SET theme='$color' WHERE userID='$_COOKIE[userID]'";
		$connection->query($sql);
		setcookie("theme", $color, time() + (86400*365), "/");
		echo "Theme color updated.";
	}

	$connection->close();
	exit();
?>