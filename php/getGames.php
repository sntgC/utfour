<?php
    $server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");

    $username = $_GET["username"];

    if($username == ""){
        echo "Username input empty";
        $connection->close();
        exit();
    }

    $sql = "SELECT userID FROM users WHERE username='$username'";
    $results = $connection->query($sql);

    if(mysqli_num_rows($results) == 0){
        echo "User not found";
        $connection->close();
        exit();
    }

    $row = $results->fetch_assoc();
    $userID = $row["userID"];

    $sql = "SELECT id, player1ID, player2ID FROM games WHERE (player1ID='$userID' OR player2ID='$userID') AND winnerID IS NULL";
    $results = $connection->query($sql);

    if(mysqli_num_rows($results) == 0){
        echo "No games found";
        $connection->close();
        exit();
    }
    
    while($row = mysqli_fetch_array($results)){
        echo $row["id"] . " ";
        if($userID == $row["player1ID"]){
            $sql = "SELECT username FROM users WHERE userID='$row[player2ID]'";
            $results2 = $connection->query($sql);
            $list = $results2->fetch_assoc();
            $username = $list["username"];
            echo $username . " ";
        }
        else if($userID == $row["player2ID"]){
            $sql = "SELECT username FROM users WHERE userID='$row[player1ID]'";
            $results2 = $connection->query($sql);
            $list = $results2->fetch_assoc();
            $username = $list["username"];
            echo $username . " ";
        }
    }

    $connection->close();
    exit(); 
?>