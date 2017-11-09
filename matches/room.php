<!DOCTYPE html>
<html>
	<head>
		<title>Game Room</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../style/utfour.css">
		<link rel="stylesheet" type="text/css" href="../style/fontello.css">
		<link rel="stylesheet" type="text/css" href="../style/room.css">
		<link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="../script.js"></script>
		<script type="text/javascript" src="../roomScript.js"></script>
		<script type="text/javascript" src="../turnScript.js"></script>
		<script type="text/javascript" src="../UTTTScript.js"></script>
		<script type="text/javascript">
			function authenticateUser(){
				if(window.frameElement){
					return;
				}
				if(!checkForLoggedIn()){
					return;
				}
				$.ajax({
					url: "../php/authenticateUser.php",
					success: function(data){
						if(data == "Authentication failed"){
							location.reload();
						}
					}
				});
			}
			authenticateUser();

			function adjustNav(){
				if(window.frameElement){
					$(document).ready(function(){
						$("#parentNav1").hide();
						$("#parentNav2").hide();
					});
				}
				else if(checkForLoggedIn()){
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
				if (!e.target.matches('#usrImg')) {
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
		<!--Navigation bar used when the user is not logged in-->
		<div class="header" id="parentNav1">
            <div class="filler"></div>
			<div class="dropdown left">
				<a href="../index" class="dropbtn title blue">UT<sup>4</sup></a>
			</div>
		</div>
		
		<!--Navigation bar used when the user is logged in-->
		<div class="header" id="parentNav2" style="display:none">
			<div class="dropdown right" id="userData">
				<a href="javascript:dropMenu('accountSettings');" class="dropbtn blue"><?php $from = "room"; include '../php/loadUserImg.php'; $emailOnly=""; $winsOnly=""; $includeWins="true"; include '../php/getUser.php';?></a>
				<div class="dropdown-content right" id="accountSettings">
					<a href="../account" class="dropdownLink">My Account</a>
					<a href="../spectate" class="dropdownLink">Spectate</a>
					<a href="../howtoplay" class="dropdownLink">How to Play</a>
					<a href="../php/logoutUser.php" class="dropdownLink">Sign Out</a>
				</div>
			</div>
            <div class="filler"></div>
			<div class="dropdown left">
				<a href="../lobby" class="dropbtn title blue">UT<sup>4</sup></a>
			</div>
		</div>
		<div id="gameArea">
			<div class="player-info" style="background-color:#dfdfdf">
				<div id="playerContainer">
					<canvas id="p1Color" width="15" height="15"></canvas><p id="p1" class=""></p>
					<br>
					<canvas id="p2Color" width="15" height="15"></canvas><p id="p2" class=""></p>
				</div>
				<div id="divThatUsedToCenterTurnDisplay"><canvas id="turnDisplay" width="55" height="55"></canvas></div>
			</div>
			<br>
 			<canvas id="display" width="468" height="468"></canvas>
 		</div>
<!--PLACEHOLDER-->
	</body>
</html>