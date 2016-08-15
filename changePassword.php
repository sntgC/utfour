<!DOCTYPE html>
<html>
	<head>
		<title>Change Password</title>
		<meta charset="utf-8">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<link rel="stylesheet" type="text/css" href="style/header.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="script.js"></script>
		<script type="text/javascript">
			authenticateUser();
			function redirect(){
				if(checkForLoggedIn() == false){
					window.location.replace("login");
				}
			}
			redirect();
			adjustTheme();

			function init(){
				document.getElementById("passwordNotif").style.display = "none";
				document.getElementById("passwordConfNotif").style.display = "none";
			}
			
			function verifyForm(){
				var goodEntry = true;
				var newPassword = document.forms["changePassForm"]["newPassword"].value;
				var newPasswordConf = document.forms["changePassForm"]["newPasswordConf"].value;
				
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
					if(verifyForm() == false){
						return false;
					}
					$.post($("#changePassForm").attr("action"),
						   $("#changePassForm :input").serializeArray(),
						   function(data){
								if(data == "Password changed successfully"){
									$("#alert").html(data);
									$("#alert").removeClass("warningText").addClass("alertText");
									$("#currPassword").val("");
									$("#newPassword").val("");
									$("#newPasswordConf").val("");
								}
								else if(data == "Authentication failed"){
									window.location.replace("login");
								}
								else{
									$("#alert").html(data);
									$("#alert").removeClass("alertText").addClass("warningText");
									$("#currPassword").val("");
								}
						   }
					);
					return false;
				});
			});

			//Made this into an object with ids as keys in order to support multiple dropdown
			var isOpen = {};
			function dropMenu(id) {
				if(isOpen[id]===undefined){
					isOpen[id]=false;
				}
				//Closes all other divs
				var keys=Object.keys(isOpen);
				for(o=0;o<keys.length;o++){
						if(isOpen[keys[o]]&&keys[o]!=id){
							$("#"+keys[o]).toggle();
							isOpen[keys[o]] = !isOpen[keys[o]];
						}
				}
				$("#"+id).toggle();
				isOpen[id] = !isOpen[id];
			}

			// Close the dropdown if the user clicks outside of the button or image
			window.onclick = function(e) {
				//.dropdownLink is the class for anything that does not hide the dropdowns
				if (!e.target.matches('#usrImg')&&!e.target.matches(".dropdownLink")) {
					var keys=Object.keys(isOpen);
					for(o=0;o<keys.length;o++){
						if(isOpen[keys[o]]){
							$("#"+keys[o]).toggle();
							isOpen[keys[o]] = !isOpen[keys[o]];
						}
					}
				}
			}
			//This is a cheeky way of setting the menu width equal to the parent button
			window.onload=function(){
				window.setTimeout(function(){
					var width=Math.floor($("#userData").width());
					document.getElementById("accountSettings").style.minWidth=width+"px";
				},500);
			};
		</script>
	</head>
	<body onload="init()" style="display:none">
		<ul class="blue">
			<li class="dropdown right" id="userData">
				<a href="javascript:dropMenu('accountSettings');" class="dropbtn dropdownLink blue"><?php include 'php/loadUserImg.php'; $emailOnly=""; $winsOnly=""; $includeWins="true"; include 'php/getUser.php';?></a>
				<div class="dropdown-content" id="accountSettings">
					<a href="php/logoutUser.php" class="dropdownLink">Sign Out</a>
					<a href="index" class="dropdownLink">Spectate</a>
				</div>
			</li>
			<li class="dropdown left">
				<a href="lobby" class="dropbtn title blue">UT<sup>4</sup></a>
			</li>
			<li class="dropdown left">
				<a href="account" class="dropbtn title blue">My Account</a>
			</li>
		</ul>
		<h1 class="formSectionTitle">Change Password</h1>
		<div class="formSection blue">
			<p id="alert"></p>
			<p>Please hover your mouse over the input boxes for the requirements regarding that field.</p>
			<form action="php/updatePassword.php" method="post" name="changePassForm" id="changePassForm">
				<label>Current Password</label><br>
				<input class="blue" type="password" name="currPasswordIn" id="currPassword" title="Please enter your current password."><br>
				<label>New Password</label><br>
				<input class="blue" type="password" name="newPasswordIn" id="newPassword" title="Your new password must be 6 to 20 characters in length."><br>
				<p id="passwordNotif" class="warningText"></p>
				<label>New Password Confirmation</label><br>
				<input class="blue" type="password" name="newPasswordInConf" id="newPasswordConf" title="Please re-enter your new password."><br>
				<p id="passwordConfNotif" class="warningText"></p>
				<input class="blue" id="submit" type="submit" value="Change Password">
			</form>
		</div>
	</body>
</html>