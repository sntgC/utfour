<!DOCTYPE html>
<html>
	<head>
		<title>Lobby</title>
		<meta charset="utf-8">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style/utfour.css">
		<link rel="stylesheet" type="text/css" href="style/fontello.css">
		<link rel="stylesheet" type="text/css" href="style/form.css">
		<link rel="stylesheet" type="text/css" href="style/home.css">
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

			function hideLobbyUsrs(){
				$("#playersLabel").toggle();
				$("#players").toggle();
			}

			function togglePrivateMatch(){
				$("#privateRoom").toggle();
			}

			function enableCheckbox(){
				$("#playerReady").attr("disabled",false);
			}

			function toggleFeaturedGame (){
				$("#featuredGame").toggle();
				$("#noGames").toggle();
			}

			//Made this into an object with ids as keys in order to support multiple dropdown
			var isOpen = {};
			var notificationsChecked=false;
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
				if(id==='notification')
					notificationsChecked=true;
			}

			window.onclick = function(e) {
				//.dropdownLink is the class for anything that does not hide the dropdowns
				if (false) {
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
                $(".dropdown-content").toggle();
				window.setTimeout(function(){
					var width=Math.floor($("#userData").width());
					document.getElementById("accountSettings").style.minWidth=width+"px";
				},500);
				window.setTimeout(enableCheckbox,3000);
			};

			//Used to prevent spamming of the checkbox
			var lastClicked=Date.now();
			$(document).ready(function(){
				$(".mainContent").css("width",$(window).width()-$(".leftContent").width());
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
		<div class="header">
			<div class="dropdown right">
                <a href="javascript:dropMenu('lobbySettings');" class="dropbtn blue"><img src="images/settings.png" height="30" width="30" class=""></a>
                <div class="dropdown-content right" id="lobbySettings">
                    <a href="javascript:hideLobbyUsrs()" class="dropdownLink">Toggle Players</a>
                    <a href="javascript:togglePrivateMatch()" class="dropdownLink">Toggle Private Match Creator</a>
                    <a href="javascript:beginTournament()" id="adminControls" class="dropdownLink" style="display:none">Begin Tournament</a>
                </div>
			</div>
			<div class="dropdown right" id="notificationButton">
				<a href="javascript:dropMenu('notification')" class="dropbtn blue" id="notifLink"><img src="images/notifications.png" height="30" width="30" class=""></a>
				<div class="dropdown-content right" id="notification">
				<a class="dropdownLink"><em class="dropdownLink" style="cursor:default">No games available</em></a>
				</div>
			</div>
			<div class="dropdown right" id="userData">
                <a href="javascript:dropMenu('accountSettings');" class="dropbtn  blue"><?php include 'php/loadUserImg.php'; $emailOnly=""; $winsOnly=""; $includeWins="true"; include 'php/getUser.php';?></a>
                <div class="dropdown-content right" id="accountSettings">
                    <a href="account" class="dropdownLink">My Account</a>
                    <a href="spectate" class="dropdownLink">Spectate</a>
                    <a href="howtoplay" class="dropdownLink">How to Play</a>
                    <a href="php/logoutUser.php" class="dropdownLink">Sign Out</a>
                </div>
			</div>
            <div class="filler"></div>
			<div class="dropdown left">
				<a class="dropbtn title noclick">UT<sup>4</sup></a>
			</div>
		</div>
        <div class="body-container">
            <div class="leftContent left-content">
                <div id='privateRoom'>
                    <span id="alert" style="display:none" class="dismissable"></span>
                    <span id="privateGameLabel" class="form-label">Username</span><br>
                    <input type="text" id="requestedUsername" class="form-text-field">
                    <button onclick="generatePrivateGame()" id="privateGameButton" class="submit">Create Private Match</button>
                </div>
                <div id='readySwitch'>
                    <input type='checkbox' id='playerReady' disabled='true'> Ready up for tournament
                </div>
                <div class="player-container">
                    <div id="playersLabel">
                        Online Players
                    </div>
                    <div id="players">
                    </div>
                </div>
            </div>
            <div class="mainContent main-content">
                <h1>Featured Game</h1>
                <iframe id="featuredGame" src="" style="display:none"></iframe>
                <h2 id="noGames">No currently active games :(</h2>
            </div>
        </div>
	</body>
</html>
