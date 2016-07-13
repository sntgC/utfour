<!DOCTYPE html>
<html>
	<head>
		<title>Lobby</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
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
		<script type="text/javascript" src="bracket.js"></script>
		<script type="text/javascript" src="tournamentStart.js"></script>
	</head>
	<body>
		<!--The low quality of graphics is due to both the lack of bootstrap and a competent web designer, will be fixed in the future-->
		<h3>Lobby</h3>
		Welcome <b><?php $winsOnly=""; $includeWins="true"; include 'php/getUser.php';?></b><br>
		<a href="php/logoutUser.php">Sign Out</a><br>
		<a href="account">My Account</a><br>
		<!--Temporary link. Will need to create spectate.html later-->
		<a href="index">Spectate</a><br><br>
		<button onclick=beginTournament()>Begin Tournament</button>
		<div id="players">
		
		</div>
		<div id="notification">
		</div>
	</body>
</html>