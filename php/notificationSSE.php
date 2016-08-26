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
			if($row['consent']==1){
				$name=$_GET['userID']==$row['player1ID']? $row['player2Name']:$row['player1Name'];
				$return .="<a href='matches/".$row['id']."'>You vs ".$name."</a>";
			}else if($_GET['userID']==$row['player1ID']){
				$return .="<a>Waiting for ".$row['player2Name']."'s response</a>";
			}else{
				$return .="<div id='$row[id]' class='dataDiv dropdownLink'>Game request from <b>".$row['player1Name']."</b>, accept? <a href='javascript:acceptMatchRequest(1, $row[id])' class='dropdownLink'>Y</a><a href='javascript:acceptMatchRequest(0, $row[id])' class='dropdownLink'>N</a></div>";
			}
		}
		mysqli_close($connect);
		
		return $return;
	}
	
	$serverTime = time();
	sendMsg($serverTime, getPlayers());
?>
