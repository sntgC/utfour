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

    $sql = "SELECT username FROM users WHERE email='$email'";
    $results = $connection->query($sql);
	
	if(mysqli_num_rows($results) == 1){
		$row = $results->fetch_assoc();
		$username = $row["username"];
		
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
		
		$m->Subject = 'UT4 Username Requested';
		$m->Body = 'Username: <b>' . $username . '</b>';
		$m->AltBody = 'Username: ' . $username;
	
		$m->send();
	}
	
	echo "If the email address is correct, an email containing your username has been sent to you.";
	$connection->close();
	exit();
?>