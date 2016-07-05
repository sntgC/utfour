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
	
	function timeStamp(){
		$connect = new mysqli("localhost","root","","ut4serverdb") or die("Failed to connect to the server");
		$sql = "UPDATE lobby SET lastActive='".date("Y-m-d H:i:s",time())."' WHERE userID='$_GET[user]'; ";
		$sql .= "DELETE FROM lobby WHERE lastActive < '".date("Y-m-d H:i:s",time()-30)."'; ";
		$result = mysqli_multi_query($connect,$sql);
		if (!$result){
			die ("The SQL command was not processed correctly");
		} else{
			//
		}
		mysqli_close($connect);
	}
	
	timeStamp();
	$serverTime = time();
	sendMsg($serverTime, getPlayers());
?>
