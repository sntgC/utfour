<!DOCTYPE html>
<html>
	<head>
		<title>Change Email Address</title>
		<meta charset="utf-8">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="style/utfour.css">
		<link rel="stylesheet" type="text/css" href="style/form.css">
		<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
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
				document.getElementById("checkmarkEmail").style.display = "none";
				document.getElementById("xEmail").style.display = "none";
				document.getElementById("emailNotif").style.display = "none";
				document.getElementById("emailConfNotif").style.display = "none";
                $(".dropdown-content").toggle();
			}
			
			var availableEmail=false;
			var goodEntry = true;
			function verifyForm(){
				var email = document.forms["changeEmailForm"]["emailIn"].value;
				var emailConf = document.forms["changeEmailForm"]["emailInConf"].value;
				goodEntry = true;
				
				document.getElementById("emailNotif").style.display = "none";
				document.getElementById("emailNotif").innerHTML = "";
				document.getElementById("emailConfNotif").style.display = "none";
				document.getElementById("emailConfNotif").innerHTML = "";
				
				var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				if(!availableEmail){
					document.getElementById("emailNotif").style.display = "block";
					document.getElementById("emailNotif").innerHTML = "Email is not available";
					goodEntry = false;
				}
				else if(!re.test(email)){
					document.getElementById("emailNotif").style.display = "block";
					document.getElementById("emailNotif").innerHTML = "Email is invalid";
					goodEntry = false;
				}
				else if(email.length > 100){
					document.getElementById("emailNotif").style.display = "block";
					document.getElementById("emailNotif").innerHTML = "Email is too long";
					goodEntry = false;
				}
				else if(email != emailConf){
					document.getElementById("emailNotif").style.display = "block";
					document.getElementById("emailNotif").innerHTML = "Emails do not match";
					document.getElementById("emailConfNotif").style.display = "block";
					document.getElementById("emailConfNotif").innerHTML = "Emails do not match";
					goodEntry = false;
				}
				else{
					document.getElementById("emailNotif").style.display = "none";
					document.getElementById("emailNotif").innerHTML = "";
					document.getElementById("emailConfNotif").style.display = "none";
					document.getElementById("emailConfNotif").innerHTML = "";
				}
				
				return goodEntry;
			}
			
			function checkEmail(str){
				if (str == ""){
					document.getElementById("xEmail").style.display = "none";
					document.getElementById("checkmarkEmail").style.display = "none";
					availableEmail=false;
					return;
				}
				$.post("php/checkForEmail.php",
					   {email : str},
					   function(data){
							if(data == "true"){
								document.getElementById("xEmail").style.display = "inline";
								document.getElementById("checkmarkEmail").style.display = "none";
								availableEmail=false;
							}
							else if(data == "false"){
								document.getElementById("checkmarkEmail").style.display = "inline";
								document.getElementById("xEmail").style.display = "none";
								availableEmail=true;
							}
					   }
				);
			}
			
			$(document).ready(function(){
				$("#submit").on('click',function(){
					verifyForm();
					if(verifyForm() == false){
						return false;
					}
					$.post($("#changeEmailForm").attr("action"),
						   $("#changeEmailForm :input").serializeArray(),
						   function(data){
								if(data == "Email address changed successfully"){
									$("#alert").html(data);
									$("#alert").removeClass("warningText").addClass("alertText");
									$("#currEmail").val("");
									$("#email").val("");
									$("#emailConf").val("");
								}
								else if(data == "Authentication failed"){
									window.location.replace("login");
								}
								else{
									$("#alert").html(data);
									$("#alert").removeClass("alertText").addClass("warningText");
									$("#currEmail").val("");
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
				if (!e.target.matches('#usrImg')&&!e.target.matches(".dropdownLink")&&!e.target.matches(".dropbtn")) {
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
		<div class="header">
			<div class="dropdown right" id="userData">
				<a href="javascript:dropMenu('accountSettings');" class="dropbtn  blue"><?php include 'php/loadUserImg.php'; $emailOnly=""; $winsOnly=""; $includeWins="true"; include 'php/getUser.php';?></a>
				<div class="dropdown-content" id="accountSettings">
					<a href="spectate" class="dropdownLink">Spectate</a>
					<a href="php/logoutUser.php" class="dropdownLink">Sign Out</a>
				</div>
			</div>
            <span class="filler"></span>
			<div class="dropdown left">
				<a href="account" class="dropbtn title blue">My Account</a>
			</div>
			<div class="dropdown left">
				<a href="lobby" class="dropbtn title blue">UT<sup>4</sup></a>
			</div>
		</div>
        <div class="center-container">
            <div class="form-container">
                <h1 class="form-title">Change Email Address</h1>
                <div class="formSection blue">
                    <p id="alert"></p>
                    <form onsubmit="return verifyForm()" action="php/updateEmail.php" method="post" name="changeEmailForm" id="changeEmailForm">
                        <label class="form-label">Current Email Address</label><br>
                        <input class="form-text-field" id="currEmail" type="text" name="currEmailIn" title="Please enter your current email."><br>
                        <label class="form-label">New Email Address</label><br>
                        <input class="form-text-field shortInput" id="email" type="text" name="emailIn" oninput="checkEmail(this.value)" title="Please enter a valid email address that is no more than 100 characters in length and is not already in use.">
                        <span id="checkmarkEmail"><i class="material-icons green-txt">check</i></span>
                        <span id="xEmail"><i class="material-icons red-txt">close</i></span><br>
                        <p id="emailNotif" class="warningText"></p>
                        <label class="form-label">New Email Address Confirmation</label><br>
                        <input class="form-text-field" id="emailConf" type="text" name="emailInConf" title="Please re-enter your new email address."><br>
                        <p id="emailConfNotif" class="warningText"></p>
                        <input class="submit" type="submit" id="submit" value="Change Email Address">
                    </form>
                </div>
            </div>
        </div>
	</body>
</html>