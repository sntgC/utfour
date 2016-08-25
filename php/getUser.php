<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	if(isset($_POST["twoPlayers"])){
		$array = json_decode($_POST["twoPlayers"]);
		$p1 = $array[0];
		$p2 = $array[1];

		$sql = "SELECT username, wins FROM users WHERE userID='$p1'";
		$results = $connection->query($sql);
		$row = $results->fetch_assoc();
		$username1 = $row["username"] . " (" . $row["wins"] . ")";

		$sql = "SELECT username, wins FROM users WHERE userID='$p2'";
		$results = $connection->query($sql);
		$row = $results->fetch_assoc();
		$username2 = $row["username"] . " (" . $row["wins"] . ")";

		$retArray = array($username1, $username2);
		echo json_encode($retArray);

		$connection->close();
		exit();
	}

	$cookie_value = $_COOKIE["userID"];
	
	$sql = "SELECT * FROM users WHERE userID='$cookie_value'";
	$results = $connection->query($sql);
	
	$row = $results->fetch_assoc();
	
	//This is added in order to get the username from a js file. It will not affect any previous functionality
	//Only runs if the file is called using POST, not include
	if(isset($_POST['jsCall'])){
		echo $row['username'];
		exit();
	}
	
	//Uses previously set variables to echo fixed content only
	if($emailOnly == "true"){
		echo $row["email"];
	}
	
	if($winsOnly == "true"){
		echo $row["wins"];
	}
	
	if($includeWins == "true"){
		echo $row["username"] . ' (' . $row["wins"] . ')';
	}
	else if($includeWins == "false"){
		echo $row["username"];
	}
?>