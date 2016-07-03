<?php
	$newFile = fopen("../matches/"."$_POST[fileName]".".html", "w") or die("Unable to open file!");
	$roomTemplate = fopen('../matches/room.html','r');
	while ($line = fgets($roomTemplate)) {
		fwrite($newFile, $line);
	}
	fclose($newFile);
	fclose($roomTemplate);
	$connection=mysqli_connect("localhost","root","") or die("Failed to connect to the server");
	mysqli_select_db($connection,"ut4serverdb") or die("Failed to connect to the database");
	$sql="";
	if($_POST['player1ID']!=""){
		$sql = "INSERT INTO games (id, player1ID, player2ID) VALUES ('$_POST[fileName]','$_POST[player1ID]','$_POST[player2ID]')";
	}else{
		$sql = "INSERT INTO games (id) VALUES ('$_POST[fileName]')";
	}
	
	if ($connection->query($sql)===TRUE){
		echo "<p><a href='/matches/".$_POST['fileName'].".html"."'>Go To Room</a> for ".$_POST['player1ID']." and ".$_POST['player2ID']."</p>";
	}else{
		echo "Something seems to have gone wrong";
	}
	
	$connection->close();
	exit();
?>