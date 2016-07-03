<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "ut4serverdb";
	$connect = new mysqli($server,$username,$password,$database) or die("Failed to connect to the server");
	
	$sql = "";
	$sql .="CREATE TABLE IF NOT EXISTS tournaments (
				id varchar(8) CHARACTER SET utf8 NOT NULL,
				data varchar(1024) CHARACTER SET utf8 NOT NULL
				); ";
	$sql .="CREATE TABLE IF NOT EXISTS games (
				id varchar(8) CHARACTER SET utf8 DEFAULT NULL,
				player1ID varchar(8) CHARACTER SET utf8 DEFAULT NULL,
				player2ID varchar(8) CHARACTER SET utf8 DEFAULT NULL,
				winnerID varchar(8) CHARACTER SET utf8 DEFAULT NULL,
				gameData varchar(1024) CHARACTER SET utf8 DEFAULT NULL
				); ";
	$sql .="CREATE TABLE IF NOT EXISTS users (
				id int NOT NULL AUTO_INCREMENT,
				userID varchar(7) CHARACTER SET utf8 DEFAULT NULL,
				username varchar(20) CHARACTER SET utf8 DEFAULT NULL,
				password varchar(20) CHARACTER SET utf8 DEFAULT NULL,
				wins int NOT NULL DEFAULT 0,
				beekeeper boolean NOT NULL DEFAULT 0,
				PRIMARY KEY (id)
				); ";
				
	$result = mysqli_multi_query($connect,$sql);
	if (!$result){
		die ("The SQL command was not processed correctly");
	} else{
		//Redirects to the page where the form was added. This can be avoided using AJAX
		echo "MySQL tables setup successfully";
	}
	mysqli_close($connect);
?>