<?php
	require_once '../libs/PHPMailer/PHPMailerAutoload.php';
    $email = $_POST["email"];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		echo "Email is not valid.";
		exit();
	}
    
    $server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");

	function generateKey(){
		$charList1 = "abcdefghijklmnopqrstuvwxyz";
		$charList2 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$charList3 = "1234567890";
		$charList4 = "!@#$%^&*";
		
		$generatedKey = "";
		for($i = 0; $i < 10; $i++){
			$chooseList = mt_rand(1,4);
			if($chooseList == 1){
				$selectChar = mt_rand(0,25);
				$char = $charList1{$selectChar};
				$generatedKey .= $char;
			}
			else if($chooseList == 2){
				$selectChar = mt_rand(0,25);
				$char = $charList2{$selectChar};
				$generatedKey .= $char;
			}
			else if($chooseList == 3){
				$selectChar = mt_rand(0,9);
				$char = $charList3{$selectChar};
				$generatedKey .= $char;
			}
			else{
				$selectChar = mt_rand(0,7);
				$char = $charList4{$selectChar};
				$generatedKey .= $char;
			}
		}
		return $generatedKey;
	}
	
	$createdKey = generateKey();
	
    $sql = "UPDATE users SET pwdReset='$createdKey' WHERE email='$email'";
    $connection->query($sql);
	
	if($connection->affected_rows > 0){
		$sql = "SELECT * FROM users WHERE email='$email'";
		$results = $connection->query($sql);
		$row = $results->fetch_assoc();
		
		$uniqueCode = $row["pwdReset"];
		$username = $row["username"];
		
		//Will need to change link address later when we have our domain name chosen. If you wish to test this feature
		//you must change the directory for your utfour website copy as needed.
		$link = "http://localhost/utfour/resetPassword?resetCode=" . urlencode($uniqueCode);
		
		$m = new PHPMailer();
		
		$m->isSMTP();
		$m->SMTPAuth = true;
		
		$m->Host = 'smtp.gmail.com';
		
		//The authentication below uses a Google account in order to send the emails. This will be
		//changed in the future when we have our webhost and domain name selected, however, for testing
		//purposes you must currently enter you username and password for your Google account.
		$m->Username = '';
		$m->Password = '';
		
		$m->SMTPSecure = 'tls';
		$m->Port = 587;
		
		//Enter email for the first parameter
		$m->setFrom('', 'UT4');
		$m->addAddress($email,$username);
		$m->isHTML(true);
		
		$m->Subject = 'UT4 Password Reset Requested';
		$m->Body = "Password reset link: <a href=\"$link\"><b>$link</b></a>";
		$m->AltBody = "Password reset link: " . $link;
	
		$m->send();
	}
	
	echo "If the email address is correct, an email containing a password reset link has been sent to you.";
	$connection->close();
	exit();
?>