<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "ut4serverdb";
	$connect = new mysqli($server,$username,$password,$database) or die("Failed to connect to the server");
	$sql = "UPDATE games SET winnerID = '$_GET[winID]' WHERE id='$_GET[gameID]'";
	$result = mysqli_query($connect,$sql);
	if (!$result){
		die ("The SQL command was not processed correctly");
	} else{
		//Redirects to the page where the form was added. This can be avoided using AJAX
		header( 'Location: ../test' ) ;
	}
	mysqli_close($connect);
?>