<!DOCTYPE html>
<html>
	<head>
		<title>Lobby</title>
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
			
			function showPrvtMatch(){
				$("#privateRoom").toggle();
			}
			
			function hideLobbyUsrs(){
				$("#players").toggle();
			}
			
			function hideNotifications(){
				$("#notification").toggle();
			}
			
			var isOpen = false;
			function dropUserMenu() {
				$("#accountSettings").toggle();
				isOpen = !isOpen;
			}

			// Close the dropdown if the user clicks outside of the button or image
			window.onclick = function(e) {
				if (!e.target.matches('.dropbtn') && !e.target.matches('#usrImg')) {
					if(isOpen){
						$("#accountSettings").toggle();
						isOpen = !isOpen;
					}
				}
			}
		</script>
		<script type="text/javascript" src="bracket.js"></script>
		<script type="text/javascript" src="tournamentStart.js"></script>
	</head>
	<body style="display:none">
		<ul>
			<li class="dropdown">
			<a href="javascript:dropUserMenu();" class="dropbtn"><?php include 'php/loadUserImg.php'; $emailOnly=""; $winsOnly=""; $includeWins="true"; include 'php/getUser.php';?></a>
			<div class="dropdown-content" id="accountSettings">
				<a href="account">My Account</a>
				<a href="php/logoutUser.php">Sign Out</a>
				<a href="index">Spectate</a>
			</div>
			</li>
		</ul>
		<div id="adminControls" style="display:none"></div>
		<!--Will later replace this and other similar links with small icons that function the same-->
		<a href="javascript:showPrvtMatch();" class="dropdown"><h3>Create 1v1 Private Match</h3></a>
		<div id="privateRoom" style="display:none">
			<span id="alert" style="display:none"></span>
			Username: <input type="text" id="requestedUsername">
			<button onclick="generatePrivateGame()">Create Private Match</button>
		</div>
		<br>
		<a href="javascript:hideLobbyUsrs();" class="dropdown"><h3>Players in Lobby</h3></a>
		<div id="players"></div>
		<br>
		<a href="javascript:hideNotifications();" class="dropdown"><h3>Notifications</h3></a>
		<div id="notification"></div>
	</body>
</html>