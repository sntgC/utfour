<?php
	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "ut4serverdb";
	
	function sendMsg($id, $msg) {
		echo "id: $id" . PHP_EOL;
		echo "data: $msg" . PHP_EOL;
		echo PHP_EOL;
		ob_flush();
		flush();
	}
	
	function getPlayers(){
		$connect = new mysqli($server,$username,$password,$database) or die("Failed to connect to the server");
		$sql = "SELECT userID FROM lobby";
		$result = mysqli_query($connect,$sql);
		$return ="";
	
		while($row = mysqli_fetch_array($result)){
			$return .= $row;
		}
		
		mysqli_close($connect);
		
		return "g";
	}
	
	$serverTime = time();
	sendMsg($serverTime, getPlayers());
?>
