<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	function generateID(){
		$charList1 = "abcdefghijklmnopqrstuvwxyz";
		$charList2 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$charList3 = "1234567890";
		$charList4 = "!@#$%^&*";
		
		$generatedID = "";
		for($i = 0; $i < 7; $i++){
			$chooseList = mt_rand(1,4);
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
			else if($chooseList == 3){
				$selectChar = mt_rand(0,9);
				$char = $charList3{$selectChar};
				$generatedID .= $char;
			}
			else{
				$selectChar = mt_rand(0,7);
				$char = $charList4{$selectChar};
				$generatedID .= $char;
			}
		}
		return $generatedID;
	}
	
	$createdID = generateID();
	
	$isUnique = false;
	while($isUnique == false){
		$sql1 = "SELECT * FROM users WHERE userID='$createdID'";
		$results = $connection->query($sql1);
		if (mysqli_num_rows($results) > 0){
			$createdID = generateID();
		}
		else{
			$isUnique = true;
		}
	}
	
	$sql2 = "INSERT INTO users (userID, username, password)
	VALUES ('$createdID','$_POST[usernameIn]','$_POST[passwordIn]')";

	if ($connection->query($sql2)===TRUE){
		header("Location: ../login");
	}else{
		header("Location: ../register");
	}
	
	$connection->close();
	exit();
?>