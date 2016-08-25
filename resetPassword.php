<?php
	if(!isset($_GET["resetCode"])){
		header("Location: index");
	}
	
	$code = urldecode($_GET["resetCode"]);
	
	$display = "display:none";
	
	$server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");
	
	$sql = "SELECT * FROM users WHERE pwdReset='$code'";
	$results = $connection->query($sql);
	
	if(mysqli_num_rows($results) == 1){
		$display = "display:block";
	}
	else{
		header("Location: index");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Password Reset</title>
		<meta charset="utf-8">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<link rel="stylesheet" type="text/css" href="style/header.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="script.js"></script>
		<script type="text/javascript">
			authenticateUser();
			
			function verifyForm(){
				var goodEntry = true;
				var newPassword = document.forms["resetPassForm"]["newPassword"].value;
				var newPasswordConf = document.forms["resetPassForm"]["newPasswordConf"].value;
				
				document.getElementById("alert").innerHTML = "";
				document.getElementById("passwordNotif").style.display = "none";
				document.getElementById("passwordNotif").innerHTML = "";
				document.getElementById("passwordConfNotif").style.display = "none";
				document.getElementById("passwordConfNotif").innerHTML = "";
				
				if(newPassword.length < 6){
					document.getElementById("passwordNotif").style.display = "block";
					document.getElementById("passwordNotif").innerHTML = "New password is too short";
					goodEntry = false;
				}
				else if(newPassword.length > 20){
					document.getElementById("passwordNotif").style.display = "block";
					document.getElementById("passwordNotif").innerHTML = "New password is too long";
					goodEntry = false;
				}
				else if(newPassword != newPasswordConf){
					document.getElementById("passwordNotif").style.display = "block";
					document.getElementById("passwordNotif").innerHTML = "New passwords do not match";
					document.getElementById("passwordConfNotif").style.display = "block";
					document.getElementById("passwordConfNotif").innerHTML = "New passwords do not match";
					goodEntry = false;
				}
				
				return goodEntry;
			}
			
			$(document).ready(function(){
				$("#submit").on('click',function(){
					verifyForm();
					if(verifyForm() === false){
						return false;
					}
					var data = $("#resetPassForm").serializeArray();
					var tmp = $("body").attr("id");
					data.push({ name : "resetCode", value : tmp });
					$.post($("#resetPassForm").attr("action"),
						   data,
						   function(data){
								if(data == "Password changed successfully"){
									$("#info").hide();
									$("#resetPassForm").hide();
									$("#alert").html("Password reset successfully. You will be redirected to the login page in 10 seconds.");
									$("#alert").addClass("alertText").removeClass("warningText");
									window.setTimeout(function(){window.location.replace("login");},10000);
								}
								else if(data == "Password change failed"){
									$("#alert").html("Password reset failed. Please retry.");
									$("#alert").addClass("warningText").removeClass("alertText");
								}
						   }
					);
					return false;
				});
			});
		</script>
	</head>
	<body style="<?php echo $display; ?>" id="<?php echo $code; ?>">
		<ul class="blue" id="parentNav1">
			<li class="dropdown left">
				<a href="index" class="dropbtn title blue">UT<sup>4</sup></a>
			</li>
			<li class="dropdown left">
				<a href="login" class="dropbtn title blue">Login</a>
			</li>
		</ul>

		<h1 class="formSectionTitle">Password Reset</h1>
		<div class="formSection blue">
			<p id="alert" class="warningText"></p>
			<p id="info">Please hover your mouse over the input boxes for the requirements regarding that field.</p>
			<form action="php/updatePassword.php" method="post" name="resetPassForm" id="resetPassForm">
				<label>New Password</label><br>
				<input class="blue" type="password" name="newPasswordIn" id="newPassword" title="Your new password must be 6 to 20 characters in length."><br>
				<p id="passwordNotif" style="display:none" class="warningText"></p>
				<label>New Password Confirmation</label><br>
				<input class="blue" type="password" name="newPasswordInConf" id="newPasswordConf" title="Please re-enter your new password."><br>
				<p id="passwordConfNotif" style="display:none" class="warningText"></p>
				<input class="blue" id="submit" type="submit" value="Reset Password">
			</form>
		</div>
	</body>
</html>