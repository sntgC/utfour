<?php
	$connection=mysqli_connect("localhost","root","") or die("Failed to connect to the server");
	mysqli_select_db($connection,"ut4serverdb") or die("Failed to connect to the database");
	$sql="";
	$quotes="";
	//If the player2ID is simply an id, the quotes are added
	//Otherwise it is probably an SQL command from a trusted source 
	if(strpos($_POST['player2ID'],'SELECT')===false){
		$quotes="'";
	}
	else{
		$sql = $_POST['player2ID'];
		$results = $connection->query($sql);
		$row = $results->fetch_assoc();
		$userID = $row["userID"];
		if($userID == $_POST['player1ID']){
			echo "Opponent is the same as the creating user.";
			$connection->close();
			exit();
		}
	}
	
	//Create room file
	$newFile = fopen("../matches/"."$_POST[fileName]".".php", "w") or die("Unable to open file!");
	$roomTemplate = fopen('../matches/room.php','r');
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
	
	//$¢ Try something similar to an SQL injection
	if($_POST['player1ID']!=""){
		$sql = "INSERT INTO games (id, player1ID, player2ID, player1Name, player2Name, consent) VALUES ('$_POST[fileName]','$_POST[player1ID]',".$quotes."$_POST[player2ID]".$quotes.",(SELECT username FROM users WHERE userID='$_POST[player1ID]'),(SELECT username FROM users WHERE userID=".$quotes."$_POST[player2ID]".$quotes."), $_POST[consent])";
	}else{
		$sql = "INSERT INTO games (id, consent) VALUES ('$_POST[fileName]', $_POST[consent])";
	}
	if ($connection->query($sql)===TRUE){
		echo "Game created.";
	}else{
		echo "Something seems to have gone wrong.";
	}
	
	$connection->close();
	exit();
?>