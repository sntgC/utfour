<!DOCTYPE html>
<html>
	<head>
		<title>Lobby</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
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
		</script>
		<script>
		// This is from w3schools, not my code
		function dropUserMenu() {
			document.getElementById("accountSettings").classList.toggle("show");
		}

		// Close the dropdown if the user clicks outside of it
		window.onclick = function(e) {
		if (!e.target.matches('.dropbtn')) {
			var dropdowns = document.getElementsByClassName("dropdown-content");
			for (var d = 0; d < dropdowns.length; d++) {
			var openDropdown = dropdowns[d];
			if (openDropdown.classList.contains('show')) {
			openDropdown.classList.remove('show');
			}
			}
		}
		}
		</script>
		<script type="text/javascript" src="bracket.js"></script>
		<script type="text/javascript" src="tournamentStart.js"></script>
	</head>
	<body>
		<ul>
			<li class="dropdown">
			<a class="dropbtn" onclick="dropUserMenu()"><?php include 'php/loadUserImg.php'; $emailOnly=""; $winsOnly=""; $includeWins="true"; include 'php/getUser.php';?></a>
			<div class="dropdown-content" id="accountSettings">
				<a href="account">My Account</a>
				<a href="php/logoutUser.php">Sign Out</a>
				<a href="index">Spectate</a>
			</div>
			</li>
		</ul>
		<br>
		<div id="privateRoom">
			Username<input type="text" id="requestedUsername"></input>
			<button onclick="generatePrivateGame()">Create Custom Match</button>
		</div>
		<br>
		<div id="adminControls"></div>
		<br>
		<div id="players"></div>
		<br>
		<div id="notification"></div>
	</body>
</html>