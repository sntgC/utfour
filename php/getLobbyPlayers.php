<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connect = new mysqli($server,$username,$password,$database) or die("Failed to connect to the server");
	$sql = "SELECT userID FROM lobby WHERE isReady=1";
	$result = mysqli_query($connect,$sql);
	$return="";
	while($row = mysqli_fetch_array($result)){
		$return .=$row['userID']." ";
	}
	mysqli_close($connect);
		
	echo $return;
?>