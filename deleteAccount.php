<!DOCTYPE html>
<html>
	<head>
		<title>Delete My Account</title>
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
			
			$(document).ready(function(){
				$(window).keydown(function(event){
					if(event.keyCode == 13){
						event.preventDefault();
						return false;
					}
				});
				$("#submit").on('click',function(){
					$.post($("#deleteForm").attr("action"),
						   $("#deleteForm :input").serializeArray(),
						   function(data){
								if(data == "Account deletion successful"){
									window.location.replace("index");
								}
								else{
									$("#alert").html(data);
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
	<body style="display:none">
		<ul class="blue">
			<li class="dropdown right" id="userData">
				<a href="javascript:dropMenu('accountSettings');" class="dropbtn dropdownLink blue"><?php include 'php/loadUserImg.php'; $emailOnly=""; $winsOnly=""; $includeWins="true"; include 'php/getUser.php';?></a>
				<div class="dropdown-content" id="accountSettings">
					<a href="php/logoutUser.php" class="dropdownLink">Sign Out</a>
					<a href="index" class="dropdownLink">Spectate</a>
				</div>
			</li>
			<li class="dropdown left">
				<a href="lobby" class="dropbtn title blue">UT4</a>
			</li>
			<li class="dropdown left">
				<a href="account" class="dropbtn title blue">My Account</a>
			</li>
		</ul>
		<h1 class="formSectionTitle">Delete My Account</h1>
		<div class="formSection blue">
			<p id="alert" class="warningText"></p>
			<p class="warningText">WARNING! By entering your password and clicking the delete button, you understand that all of your current progress will be destroyed and will be unrecoverable.</p>
			<form id="deleteForm" action="php/deleteUser.php" method="post">
				<label>Password</label><br>
				<input class="blue" id="password" name="password" type="password"><br>
				<input class="blue" id="submit" name="submit" type="submit" value="Delete Account"><br>
			</form>
		</div>
	</body>
</html>