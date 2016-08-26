<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "ut4serverdb";
	$connect = new mysqli($server,$username,$password,$database) or die("Failed to connect to the server");
	$sql = "UPDATE games SET winnerID = '$_POST[winID]' WHERE id='$_POST[gameID]'; ";
	if($_POST['pointerRoom']!="NONE"){
		if($_POST['player']==="P1"){
			$sql.="UPDATE games SET player1ID = '$_POST[winID]', player1Name = (SELECT username FROM users WHERE userID='$_POST[winID]') WHERE id='$_POST[pointerRoom]'; ";
		}else{
			$sql.="UPDATE games SET player2ID = '$_POST[winID]', player2Name = (SELECT username FROM users WHERE userID='$_POST[winID]') id='$_POST[pointerRoom]'; ";
		}
	}else{
		$sql.="UPDATE users SET wins = wins+1 WHERE userID='$_POST[winID]'; ";
	}
	$result = mysqli_multi_query($connect,$sql);
	if (!$result){
		die ("The SQL command was not processed correctly");
	} else{
		echo $_POST['winID']." won room ".$_POST['gameID'];
	}
	unlink('../matches/'."$_POST[gameID]".'.php');
	mysqli_close($connect);
?>