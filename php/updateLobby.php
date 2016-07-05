<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	$sql="";
	if($_POST['join']==="true"){
		$sql .= "REPLACE INTO lobby (userID,lastActive) VALUES ('$_POST[id]','".date("Y-m-d H:i:s",time())."')";
	}else{
		$sql .= "DELETE FROM lobby WHERE userID='$_POST[id]'";
	}
	if ($connection->query($sql)){
		echo "( ͡° ͜ʖ ͡°)";
	}else{
		echo "¯\_(ツ)_/¯";
	}
	
	$connection->close();
	exit();
?>