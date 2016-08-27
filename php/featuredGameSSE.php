<?php
    header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache');
    
    function sendMsg($id, $msg) {
		echo "id: $id" . PHP_EOL;
		echo "data: $msg" . PHP_EOL;
		echo PHP_EOL;
		ob_flush();
		flush();
	}

    function getFeaturedGame(){
        $connection = new mysqli("localhost","root","","ut4serverdb") or die("Failed to connect to the server");
        $sql = "SELECT id, player1Name, player2Name FROM games WHERE lastPlayed > DATE_SUB(NOW(), INTERVAL 3 MINUTE) AND winnerID IS NULL AND consent=1";
        $results = $connection->query($sql);

        $bestGame = "";
        $highestMatchRating = PHP_INT_MAX * -1;
        $lowestSkillGap = PHP_INT_MAX;
        while ($row = mysqli_fetch_array($results)){
            $player1 = $row["player1Name"];
            $player2 = $row["player2Name"];

            $sql = "SELECT wins FROM users WHERE username='$player1'";
            $winNumResults = $connection->query($sql);
            $winNumRow = $winNumResults->fetch_assoc();
            $player1Wins = $winNumRow["wins"];

            $sql = "SELECT wins FROM users WHERE username='$player2'";
            $winNumResults = $connection->query($sql);
            $winNumRow = $winNumResults->fetch_assoc();
            $player2Wins = $winNumRow["wins"];

            $matchRating = ($player1Wins + $player2Wins) / 2;
            $skillGap = abs($player1Wins - $player2Wins);

            if ($matchRating > $highestMatchRating && $skillGap < $lowestSkillGap){
                $highestMatchRating = $matchRating;
                $lowestSkillGap = $skillGap;
                $bestGame = $row["id"];
            }
        }

        return $bestGame;
    }

	$serverTime = time();
	sendMsg($serverTime, getFeaturedGame());
?>