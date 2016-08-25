<?php
	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache'); // recommended to prevent caching of event data.
	
	function sendMsg($id, $msg) {
		echo "id: $id" . PHP_EOL;
		echo "data: $msg" . PHP_EOL;
		echo PHP_EOL;
		ob_flush();
		flush();
	}
	
	function getPlayers(){
		$connect = new mysqli("localhost","root","","ut4serverdb") or die("Failed to connect to the server");
		$sql = "SELECT * FROM games WHERE (player1ID='$_GET[userID]' OR player2ID='$_GET[userID]') AND player1ID IS NOT NULL AND player2ID IS NOT NULL AND winnerID IS NULL";
		$result = mysqli_query($connect,$sql);
		$return="";
		while($row = mysqli_fetch_array($result)){
			$name=$_GET['userID']==$row['player1ID']? $row['player2Name']:$row['player1Name'];
			$return .="<a href='matches/".$row['id']."'>You vs ".$name."</a>";
		}
		mysqli_close($connect);
		
		return $return;
	}
	
	$serverTime = time();
	sendMsg($serverTime, getPlayers());
?>
