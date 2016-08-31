<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "ut4serverdb";
	$connect = new mysqli($server,$username,$password,$database) or die("Failed to connect to the server");
	$sql = "UPDATE games SET gameData = '$_POST[gData]' , gameHistory = CONCAT(gameHistory ,'$_POST[moveChar]') WHERE id='$_POST[gameID]'";
	$result = mysqli_query($connect,$sql);
	if (!$result){
		die ("The SQL command was not processed correctly");
	} else{
		echo "data sent";
	}
	mysqli_close($connect);
?>