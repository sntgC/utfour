<!DOCTYPE html>
<html>
	<head>
		<title>Game Room</title>
		<meta charset="utf-8">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="../style/style.css">
		<link rel="stylesheet" type="text/css" href="../style/header.css">
		<link rel="stylesheet" type="text/css" href="../style/fontello.css">
		<link rel="stylesheet" type="text/css" href="../style/room.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="../script.js"></script>
		<script type="text/javascript" src="../roomScript.js"></script>
		<script type="text/javascript" src="../turnScript.js"></script>
		<script type="text/javascript" src="../UTTTScript.js"></script>
		<script type="text/javascript">
			function authenticateUser(){
				if(!checkForLoggedIn()){
					return;
				}
				$.ajax({
					url: "../php/authenticateUser.php",
					success: function(data){
						if(data == "Authentication failed"){
							location.replace("../login");
						}
					}
				});
			}
			authenticateUser();

			function adjustNav(){
				if(checkForLoggedIn()){
					$(document).ready(function(){
						$("#parentNav1").hide();
						$("#parentNav2").show();
					});
				}
			}

			adjustNav();
			adjustTheme();

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
	<body>
		<ul class="blue" id="parentNav1">
			<li class="dropdown left">
				<a href="../index" class="dropbtn title blue">UT<sup>4</sup></a>
			</li>
		</ul>
	
		<ul class="blue" id="parentNav2" style="display:none">
			<li class="dropdown right" id="userData">
				<a href="javascript:dropMenu('accountSettings');" class="dropbtn dropdownLink blue"><?php $from = "room"; include '../php/loadUserImg.php'; $emailOnly=""; $winsOnly=""; $includeWins="true"; include '../php/getUser.php';?></a>
				<div class="dropdown-content" id="accountSettings">
					<a href="../account" class="dropdownLink">My Account</a>
					<a href="../php/logoutUser.php" class="dropdownLink">Sign Out</a>
					<a href="../spectate" class="dropdownLink">Spectate</a>
					<a href="../howtoplay" class="dropdownLink">How to Play</a>
				</div>
			</li>
			<li class="dropdown left">
				<a href="../lobby" class="dropbtn title blue">UT<sup>4</sup></a>
			</li>
		</ul>
		<div id="gameArea">
		<div style="background-color:#dfdfdf">
			<div id="playerContainer">
				<canvas id="p1Color" width="15" height="15"></canvas><p id="p1" class="">Player 1: </p>
				<br>
				<canvas id="p2Color" width="15" height="15"></canvas><p id="p2" class="">Player 2: </p>
			</div>
			<div id="divThatUsedToCenterTurnDisplay"><canvas id="turnDisplay" width="55" height="55"></canvas></div>
		</div>
			<br>
 			<canvas id="display" width="468" height="468"></canvas>
 		</div>
<!--PLACEHOLDER-->
	</body>
</html>