<!DOCTYPE html>
<html>
	<head>
		<title>Lobby</title>
		<meta charset="utf-8">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<link rel="stylesheet" type="text/css" href="style/header.css">
		<link rel="stylesheet" type="text/css" href="style/fontello.css">
		<link rel="stylesheet" type="text/css" href="style/lobby.css">
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

			function showPrvtMatch(){
				$("#alert").hide();
				$("#alert").html("");
				$("#requestedUsername").val("");
				$("#prvtMatchDisplayLink").toggleClass("icon-down-open").toggleClass("icon-up-open");
				$("#privateRoom").toggle();
			}
			
			function hideLobbyUsrs(){
				$("#playersLabel").toggle();
				$("#players").toggle();
				$("#playersDisplayLink").toggleClass("icon-down-open").toggleClass("icon-up-open");
			}
			
			function hideNotifications(){
				$("#notification").toggle();
				$("#notifDisplayLink").toggleClass("icon-down-open").toggleClass("icon-up-open");
			}
			
			function hideCheckbox(){
				$("#readySwitch").toggle();
				$("#readyDisplayLink").toggleClass("icon-down-open").toggleClass("icon-up-open");
			}

			function enableCheckbox(){
				$("#playerReady").attr("disabled",false);
			}

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
				window.setTimeout(enableCheckbox,3000);
			};

			//Used to prevent spamming of the checkbox
			var lastClicked=Date.now();
			$(document).ready(function(){
				$("#playerReady").on('change',function(){
					if(Date.now()>lastClicked+3000){
						lastClicked=Date.now();
						jQuery.post('php/setLobbyReady.php',
									{'bool':document.getElementById('playerReady').checked? 1:0,'userID':getCookie("userID")},
									function(data){
										if(data == "User is ready"){
											$("#playerReady").attr("disabled",true);
											setTimeout(enableCheckbox,3000);
										}
										else if(data == "User is not ready"){
											$("#playerReady").attr("disabled",true);
											setTimeout(enableCheckbox,3000);
										}
									}
						);
					}
				});
				$("#alert").on("click",function(){
					$("#alert").toggle();
				});
			});	
		</script>
		<script type="text/javascript" src="bracket.js"></script>
		<script type="text/javascript" src="tournamentStart.js"></script>
	</head>
	<body style="display:none">
		<ul class="blue">
			<li class="dropdown right">
			<a href="javascript:dropMenu('lobbySettings');" class="dropbtn dropdownLink blue"><img src="images/settings.png" height="30" width="30" class="dropdownLink"></a>
			<div class="dropdown-content" id="lobbySettings">
				<a href="javascript:hideLobbyUsrs()" class="dropdownLink">Toggle Players</a>
				<a href="javascript:hideNotifications()" class="dropdownLink">Toggle Notifications</a>
			</div>
			</li>
			<li class="dropdown right" id="notificationButton">
				<a href="javascript:dropMenu('notification')" class="dropbtn dropdownLink blue"><img src="images/notifications.png" height="30" width="30" class="dropdownLink"></a>
				<div class="dropdown-content" id="notification">
				<p>Hey its me</p>
				</div>
			</li>
			<li class="dropdown right" id="userData">
			<a href="javascript:dropMenu('accountSettings');" class="dropbtn dropdownLink blue"><?php include 'php/loadUserImg.php'; $emailOnly=""; $winsOnly=""; $includeWins="true"; include 'php/getUser.php';?></a>
			<div class="dropdown-content" id="accountSettings">
				<a href="account" class="dropdownLink">My Account</a>
				<a href="php/logoutUser.php" class="dropdownLink">Sign Out</a>
				<a href="spectate" class="dropdownLink">Spectate</a>
				<a href="howtoplay" class="dropdownLink">How to Play</a>
			</div>
			</li>
			<li class="dropdown left">
				<a class="dropbtn title noclick">UT<sup>4</sup></a>
			</li>
		</ul>
		<!--
		REWRITING THE LOBBY. TEMPORARILY DISABLING ALL PREVIOUS FUNCTIONALITY WHILE THE DIVS ARE SET UP
		<div id="lobbyMenu">
			<h1>Lobby</h1>
			<div id="adminControls" style="display:none"></div>
			<a href="javascript:showPrvtMatch();" class="menu blue"><h3 id="prvtMatchDisplayLink" class="icon-down-open">Create 1v1 Private Match</h3></a>
			<div id="privateRoom" style="display:none">
				<span id="alert" style="display:none"></span><br id="tmpbr" style="display:none">
				Username: <input type="text" id="requestedUsername">
				<button onclick="generatePrivateGame()">Create Private Match</button>
			</div>
			<br>
			<a href="javascript:hideLobbyUsrs();" class="menu blue"><h3 id="playersDisplayLink" class="icon-up-open">Players in Lobby</h3></a>
			<div id="players"></div>
			<br>
			<a href="javascript:hideNotifications();" class="menu blue"><h3 id="notifDisplayLink" class="icon-up-open">Notifications</h3></a>
			<div id="notification"></div>
			<br>
			<!--We willeventually get rid of this look in exchange for the new lobby, so it's only temporary->
			<a href='javascript:hideCheckbox()' class="menu blue"><h3 id="readyDisplayLink" class="icon-up-open">Ready up for Tournament</h3></a>
			<div id="readySwitch">
				Put me in the next tournament <input type='checkbox' id='playerReady' disabled='true'>
			</div>
		</div>
		-->
		<div class="leftContent blue">
			<div id='privateRoom'>
				<span id="alert" style="display:none" class="dismissable"></span>
				<span id="privateGameLabel">Username</span><input type="text" id="requestedUsername" class="blue">
				<button onclick="generatePrivateGame()" id="privateGameButton" class="blue">Create Private Match</button>
			</div>
			<div id='readySwitch'>
				<input type='checkbox' id='playerReady' disabled='true'> Ready up for tournament
			</div>
			<div id="playersLabel">
				Online Players
			</div>
			<div id="players">
			</div>
		</div>
		<div class="mainContent">
		</div>
	</body>
</html>
