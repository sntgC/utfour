<?php
    $server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");

    $player1 = $_POST["player1"];
    $player2 = $_POST["player2"];

    $sql = "SELECT theme FROM users WHERE userID='$player1'";
    $results = $connection->query($sql);
    $row = $results->fetch_assoc();
    $color1 = $row["theme"];

    $sql = "SELECT theme FROM users WHERE userID='$player2'";
    $results = $connection->query($sql);
    $row = $results->fetch_assoc();
    $color2 = $row["theme"];

    $return = array($color1,$color2);
    echo json_encode($return);

    $connection->close();
	exit();
?>