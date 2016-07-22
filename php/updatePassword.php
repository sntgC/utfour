<?php
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	if(strlen($_POST['newPasswordIn']) < 6){
		echo "New password is too short. ";
		$connection->close();
		exit();	
	}
	else if(strlen($_POST['newPasswordIn']) > 20){
		echo "New password is too long. ";
		$connection->close();
		exit();
	}
	
	$hashedPwd = password_hash($_POST["newPasswordIn"],PASSWORD_BCRYPT);
	
	if(isset($_POST["resetCode"])){
		$sql = "UPDATE users SET password='$hashedPwd' WHERE pwdReset='$_POST[resetCode]'";
		$connection->query($sql);
		
		if($connection->affected_rows > 0){
			echo "Password changed successfully";
			
			$sql = "SELECT * FROM users WHERE pwdReset='$_POST[resetCode]'";
			$results = $connection->query($sql);
			$row = $results->fetch_assoc();
			$email = $row["email"];
			$username = $row["username"];
			
			require_once '../libs/PHPMailer/PHPMailerAutoload.php';
			
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
			
			$m->Subject = 'UT4 Password Recently Reset';
			$m->Body = "This message was sent to notify you that your UT4 account password was recently reset.";
			$m->AltBody = "This message was sent to notify you that your UT4 account password was recently reset.";
		
			$m->send();
			
			$sql = "UPDATE users SET pwdReset=NULL WHERE pwdReset='$_POST[resetCode]'";
			$connection->query($sql);
		}
		else{
			echo "Password change failed";
		}
		
		$connection->close();
		exit();
	}
	
	$sql = "SELECT password FROM users WHERE userID='$_COOKIE[userID]'";
	$results = $connection->query($sql);
	$row = $results->fetch_assoc();
	$dbpassword = $row["password"];
	$password = $_POST["currPasswordIn"];
	$verify = password_verify($password,$dbpassword);
	
	if($verify){
		$sql = "UPDATE users SET password='$hashedPwd' WHERE userID='$_COOKIE[userID]'";
		$connection->query($sql);
	}
	else{
		echo "Password change failed";
		$connection->close();
		exit();
	}
	
	if($connection->affected_rows > 0){
		echo "Password changed successfully";
	}
	else{
		echo "Password change failed";
	}
	
	$connection->close();
	exit();
?>