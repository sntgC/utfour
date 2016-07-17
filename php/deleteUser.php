<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	$userID = $_COOKIE["userID"];
	$password = $_POST["password"];
	
	$sql = "SELECT * FROM users WHERE userID='$userID' AND password='$password'";
	$results = $connection->query($sql);
	
	if(mysqli_num_rows($results)==0){
		echo "Invalid password";
		$connection->close();
		exit();
	}
	
	$sql2 = "DELETE FROM users WHERE userID='$userID'";
	$connection->query($sql2);
	
	if($connection->affected_rows > 0){
		$imageName = $_COOKIE["userID"];
		$target_dir = "../images/userIcons/";
		
		try{
			if (file_exists($target_dir . $imageName . ".jpg")) {
				unlink($target_dir . $imageName . ".jpg");
			}
			else if(file_exists($target_dir . $imageName . ".jpeg")){
				unlink($target_dir . $imageName . ".jpeg");
			}
			else if(file_exists($target_dir . $imageName . ".png")){
				unlink($target_dir . $imageName . ".png");
			}
			else if(file_exists($target_dir . $imageName . ".gif")){
				unlink($target_dir . $imageName . ".gif");
			}
		} catch(Exception $e){}
		
		unset($_COOKIE["userID"]);
		setcookie("userID","",time() - (86400*366), "/");
		unset($_COOKIE["sessionID"]);
		setcookie("sessionID","",time() - (86400*366), "/");
		
		echo "Account deletion successful";
	}
	else{
		echo "Account deletion failed";
	}
	
	$connection->close();
	exit();
?>