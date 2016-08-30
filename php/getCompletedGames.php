<?php
    $server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");

    $userID = $_GET["userID"];

    $sql = "SELECT player1ID, player1Name, player2ID, player2Name, winnerID, lastPlayed, creationDate FROM games WHERE (player1ID='$userID' OR player2ID='$userID') AND winnerID IS NOT NULL";
    $results = $connection->query($sql);
    
    if(mysqli_num_rows($results) == 0){
        echo "No matches found";
        $connection->close();
        exit();
    }

    while($row = mysqli_fetch_array($results)){
        $player1 = $row["player1ID"];
        $player2 = $row["player2ID"];
        $player1Name = $row["player1Name"];
        $player2Name = $row["player2Name"];
        $winnerID = $row["winnerID"];

        $opponent = "";
        $opponentID = "";
        $me = "";
        if ($player1 == $userID){
            $opponent = $row["player2Name"];
            $opponentID = $row["player2ID"];
            $me = $row["player1Name"];
        }
        else if($player2 == $userID){
            $opponent = $row["player1Name"];
            $opponentID = $row["player1ID"];
            $me = $row["player2Name"];
        }

        $winner = "";
        if ($winnerID == $userID){
            $winner = $me;
        }
        else if($winnerID == $opponentID){
            $winner = $opponent;
        }

        $creationDate = $row["creationDate"];
        $endDate = $row["lastPlayed"];

        echo $opponent . " " . $winner . " " . substr($creationDate,0,10) . " " . substr($endDate,0,10) . " ";
    }

    $connection->close();
    exit();
?>