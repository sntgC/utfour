<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	$password = $_POST["passwordIn"];
	
	$sql = "SELECT * FROM users WHERE username='$_POST[usernameIn]'";
	$results = $connection->query($sql);
	
	if(mysqli_num_rows($results)==1){
		$row = $results->fetch_assoc();
		$dbpassword = $row["password"];
		if(password_verify($password,$dbpassword)){
			$remember = isset($_POST['staySignedIn']);
			$cookie_name = "userID";
			$cookie_value = $row["userID"];
			if (!$remember){
				//Creates a cookie set to expire upon the closure of the browser
				setcookie($cookie_name, $cookie_value, 0, "/" );
			}
			else{
				//Creates a cookie set to expire in one year
				setcookie($cookie_name, $cookie_value, time() + (86400*365), "/" );
			}
			
			$sha1Time = sha1( time() );
			$sql = "UPDATE users SET sessionID=UNHEX('$sha1Time') WHERE userID='$cookie_value'";
			$connection->query($sql);
			$sql = "SELECT sessionID FROM users WHERE userID='$cookie_value'";
			$results = $connection->query($sql);
			$row = $results->fetch_assoc();
			$value = $row["sessionID"];
			setcookie("sessionID", $value, time() + (86400*365), "/");
			
			echo "Login successful";
		}
		else{
			echo "Login failed";
		}
	}else{
		echo "Login failed";
	}

	$connection->close();
	exit();
?>