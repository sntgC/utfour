<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
		$sql="";
	if($_POST['response']==1){
		$sql = "UPDATE games SET consent=$_POST[response] WHERE id='$_POST[matchID]'";
	}else{
		$sql = "DELETE FROM games WHERE id='$_POST[matchID]'";
		unlink('../matches/'."$_POST[matchID]".'.php');
	}

	if ($connection->query($sql)===TRUE){
		echo "Data succesfully inputted";
	}else{
		echo "Something seems to have gone wrong";
	}
	$connection->close();
	exit();
	
?>