<!DOCTYPE html>
<html>
	<head>
		<title>Lobby</title>
		<meta charset="utf-8">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<link rel="stylesheet" type="text/css" href="style/header.css">
		<link rel="stylesheet" type="text/css" href="style/fontello.css">
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
				$("#tmpbr").hide();
				$("#requestedUsername").val("");
				$("#prvtMatchDisplayLink").toggleClass("icon-down-open").toggleClass("icon-up-open");
				$("#privateRoom").toggle();
			}
			
			function hideLobbyUsrs(){
				$("#players").toggle();
				$("#playersDisplayLink").toggleClass("icon-down-open").toggleClass("icon-up-open");
			}
			
			function hideNotifications(){
				$("#notification").toggle();
				$("#notifDisplayLink").toggleClass("icon-down-open").toggleClass("icon-up-open");
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
			<li class="dropdown right" id="userData">
			<a href="javascript:dropMenu('accountSettings');" class="dropbtn dropdownLink blue"><?php include 'php/loadUserImg.php'; $emailOnly=""; $winsOnly=""; $includeWins="true"; include 'php/getUser.php';?></a>
			<div class="dropdown-content" id="accountSettings">
				<a href="account" class="dropdownLink">My Account</a>
				<a href="php/logoutUser.php" class="dropdownLink">Sign Out</a>
				<a href="index" class="dropdownLink">Spectate</a>
			</div>
			</li>
			<li class="dropdown left">
				<a class="dropbtn title noclick">UT4</a>
			</li>
		</ul>
		<div id="optionsMenu">
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
		</div>
	</body>
</html>