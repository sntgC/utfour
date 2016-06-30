<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	$input=$_POST["username"];
	
	$sql="SELECT * FROM users WHERE username='$input'";
	$results=$connection->query($sql);
	
	if(mysqli_num_rows($results)==1){
		echo "true";
	}else{
		echo "false";
	}

	$connection->close();
	exit();
?>