<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "ut4serverdb";
	
	$connect = new mysqli($server,$username,$password) or die("Failed to connect to the server");
	$createDB = "CREATE DATABASE IF NOT EXISTS ut4serverdb; ";
	$connect->query($createDB);
	
	mysqli_select_db($connect,$database) or die("Failed to connect to the database");
	
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
				userID varchar(7) CHARACTER SET utf8 NOT NULL,
				username varchar(20) CHARACTER SET utf8 DEFAULT NULL,
				password varchar(20) CHARACTER SET utf8 DEFAULT NULL,
				wins int NOT NULL DEFAULT 0,
				beekeeper boolean NOT NULL DEFAULT 0,
				PRIMARY KEY (userID)
				); ";
	$sql .="CREATE TABLE IF NOT EXISTS lobby ( 
				userID varchar(7) CHARACTER SET utf8 NOT NULL,
				PRIMARY KEY (userID)	
				); ";
				
	$result = mysqli_multi_query($connect,$sql);
	if (!$result){
		die ("The SQL command was not processed correctly");
	} else{
		echo "MySQL tables setup successfully";
	}
	mysqli_close($connect);
?>