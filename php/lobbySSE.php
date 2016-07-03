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
		$sql = "SELECT userID FROM lobby";
		$result = mysqli_query($connect,$sql);
		$return="";
		while($row = mysqli_fetch_array($result)){
			$return .=$row['userID']."<br>";
		}
		mysqli_close($connect);
		
		return $return;
	}
	
	$serverTime = time();
	sendMsg($serverTime, getPlayers());
?>
