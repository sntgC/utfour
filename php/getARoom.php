<?php
	$newFile = fopen("../matches/"."$_POST[fileName]".".html", "w") or die("Unable to open file!");
	$roomTemplate = fopen('../matches/room.html','r');
	$cnt=0;
	while ($line = fgets($roomTemplate)) {
		if(strpos($line,"<!--PLACEHOLDER-->")===false){
			fwrite($newFile, $line);
		}else{
			fwrite($newFile,"<div id='pointer'>\n");
			fwrite($newFile,"<div id='$_POST[pointer]'></div>\n");
			fwrite($newFile,"</div>\n");
		}
	}
	fclose($newFile);
	fclose($roomTemplate);
	$connection=mysqli_connect("localhost","root","") or die("Failed to connect to the server");
	mysqli_select_db($connection,"ut4serverdb") or die("Failed to connect to the database");
	$sql="";
	//$¢ Try something similar to an SQL injection
	if($_POST['player1ID']!=""){
		$sql = "INSERT INTO games (id, player1ID, player2ID) VALUES ('$_POST[fileName]','$_POST[player1ID]',$_POST[player2ID])";
	}else{
		$sql = "INSERT INTO games (id) VALUES ('$_POST[fileName]')";
	}
	
	if ($connection->query($sql)===TRUE){
		echo "Thumbs Up";
	}else{
		echo "Something seems to have gone wrong";
	}
	
	$connection->close();
	exit();
?>