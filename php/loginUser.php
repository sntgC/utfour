<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	$sql = "SELECT * FROM users WHERE username='$_POST[usernameIn]' AND password='$_POST[passwordIn]'";
	$results = $connection->query($sql);
	
	if(mysqli_num_rows($results)==1){
		$remember = isset($_POST['staySignedIn']);
		$cookie_name = "userID";
		$sql2 = "SELECT userID FROM users WHERE username='$_POST[usernameIn]' AND password='$_POST[passwordIn]'";
		$results2 = $connection->query($sql2);
		$row = $results2->fetch_assoc();
		$cookie_value = $row["userID"];
		if (!$remember){
			//Creates a cookie set to expire upon the closure of the browser
			setcookie($cookie_name, $cookie_value, 0, "/" );
		}
		else{
			//Creates a cookie set to expire in one year
			setcookie($cookie_name, $cookie_value, time() + (86400*365), "/" );
		}
		header("Location: ../lobby");
	}else{
		header("Location: ../login");
	}

	$connection->close();
	exit();
?>