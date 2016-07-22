<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	$username = $_POST["usernameIn"];
	$goodUsername = true;
	
	$sql="SELECT * FROM users WHERE username='$username'";
	$results=$connection->query($sql);
	
	if(mysqli_num_rows($results)==1){
		echo "Username is taken. ";
		$goodUsername = false;
	}
	
	if(strlen($username) < 6){
		echo "Username is too short. ";
		$goodUsername = false;
	}
	else if(strlen($username) > 20){
		echo "Username is too long. ";
		$goodUsername = false;
	}
	
	$password = $_POST["passwordIn"];
	$goodPassword = true;
	
	if(strlen($password) < 6){
		echo "Password is too short. ";
		$goodPassword = false;
	}
	else if(strlen($password) > 20){
		echo "Password is too long. ";
		$goodPassword = false;
	}
	
	$email = $_POST["emailIn"];
	$goodEmail = true;
	
	$sqlE="SELECT * FROM users WHERE email='$email'";
	$resultsE=$connection->query($sqlE);
	
	if(mysqli_num_rows($resultsE)==1){
		echo "Email is taken. ";
		$goodEmail = false;
	}
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		echo "Email is not valid. ";
		$goodEmail = false;
	}
	
	if(strlen($email) > 100){
		echo "Email is too long. ";
		$goodEmail = false;
	}
	else if(strlen($email) == 0){
		echo "Email is too short. ";
		$goodEmail = false;
	}
	
	if(!$goodUsername || !$goodPassword || !$goodEmail){
		$connection->close();
		exit();
	}
	
	function generateID(){
		$charList1 = "abcdefghijklmnopqrstuvwxyz";
		$charList2 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$charList3 = "1234567890";
		
		$generatedID = "";
		for($i = 0; $i < 7; $i++){
			$chooseList = mt_rand(1,3);
			if($chooseList == 1){
				$selectChar = mt_rand(0,25);
				$char = $charList1{$selectChar};
				$generatedID .= $char;
			}
			else if($chooseList == 2){
				$selectChar = mt_rand(0,25);
				$char = $charList2{$selectChar};
				$generatedID .= $char;
			}
			else{
				$selectChar = mt_rand(0,9);
				$char = $charList3{$selectChar};
				$generatedID .= $char;
			}
		}
		return $generatedID;
	}
	
	$createdID = generateID();
	
	$isUnique = false;
	while($isUnique == false){
		$sql1 = "SELECT * FROM users WHERE userID='$createdID'";
		$results1 = $connection->query($sql1);
		if (mysqli_num_rows($results1) > 0){
			$createdID = generateID();
		}
		else{
			$isUnique = true;
		}
	}
	
	$hashedPwd = password_hash($password,PASSWORD_BCRYPT);
	
	$sql2 = "INSERT INTO users (userID, username, password, email)
	VALUES ('$createdID','$username','$hashedPwd','$email')";

	if ($connection->query($sql2)===TRUE){
		echo "Registration successful";
	}else{
		echo "Registration failed";
	}
	
	$connection->close();
	exit();
?>