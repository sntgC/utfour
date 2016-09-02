<?php
	if(!isset($_GET["gameID"])){
		header("Location: index");
	}
    $gameID = $_GET["gameID"];

    $server="localhost";
	$username="root";
	$password="";
	$database="ut4serverdb";
	
	$connection=mysqli_connect($server,$username,$password) or die("Failed to connect to the server");
	mysqli_select_db($connection,$database) or die("Failed to connect to the database");

    $sql = "SELECT id, gameHistory FROM games WHERE id='$gameID' AND winnerID IS NOT NULL AND gameHistory IS NOT NULL";
    $results = $connection->query($sql);

	$messageDisplay = "display:none";
	$gameDisplay = "display:none";
	$replayText = "";
	$id = "";
	if (mysqli_num_rows($results) == 0){
		$messageDisplay = "display:block";
	}
	else if (mysqli_num_rows($results) == 1){
		$row = $results->fetch_assoc();
		$replayText = $row["gameHistory"];
		$id = $row["id"];
		$gameDisplay = "display:block";
	}

	$connection->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Game Replay</title>
		<meta charset="utf-8">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<link rel="stylesheet" type="text/css" href="style/header.css">
		<link rel="stylesheet" type="text/css" href="style/room.css">
		<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="script.js"></script>
		<script type="text/javascript" src="replayScript.js"></script>
		<script type="text/javascript" src="UTTTScript.js"></script>
		<script type="text/javascript">
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

			var currentMove = 0;
			function previousMove (){
				var replayData = document.getElementById("replayData").innerHTML;
				if(currentMove != 0){
					board.convertGameHistoryStringIntoThePositionOfTheBoardAtTheSpecifiedTurn(replayData, currentMove - 1);
					currentMove--;
				}
			}
			function nextMove (){
				var replayData = document.getElementById("replayData").innerHTML;
				var totalMoves = replayData.length / 2;
				if(currentMove != totalMoves){
					board.convertGameHistoryStringIntoThePositionOfTheBoardAtTheSpecifiedTurn(replayData, currentMove + 1);
					currentMove++;
				}
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
		<style>
			#noGame {
				text-align: center;
			}
		</style>
    </head>
    <body>
		<!--HTML elements used to store data-->
		<div id="replayData" style="display:none"><?php echo $replayText; ?></div>
		<div id="gameID" style="display:none"><?php echo $id; ?></div>

		<ul class="blue" id="parentNav1">
			<li class="dropdown left">
				<a href="index" class="dropbtn title blue">UT<sup>4</sup></a>
			</li>
		</ul>

		<ul class="blue" id="parentNav2" style="display:none">
			<li class="dropdown right" id="userData">
				<a href="javascript:dropMenu('accountSettings');" class="dropbtn dropdownLink blue"><?php include 'php/loadUserImg.php'; $emailOnly=""; $winsOnly=""; $includeWins="true"; include 'php/getUser.php';?></a>
				<div class="dropdown-content" id="accountSettings">
					<a href="account" class="dropdownLink">My Account</a>
					<a href="spectate" class="dropdownLink">Spectate</a>
					<a href="php/logoutUser.php" class="dropdownLink">Sign Out</a>
				</div>
			</li>
			<li class="dropdown left">
				<a href="lobby" class="dropbtn title blue">UT<sup>4</sup></a>
			</li>
			<li class="dropdown left">
				<a href="matchHistory" class="dropbtn title blue">Match History</a>
			</li>
		</ul>

		<h1 id="noGame" style="<?php echo $messageDisplay; ?>" class="formSectionTitle">No Such Game Exists</h1>
		<div id="gameArea" style="<?php echo $gameDisplay; ?>">
			<div style="background-color:#dfdfdf">
				<div id="playerContainer">
					<canvas id="p1Color" width="15" height="15"></canvas><p id="p1" class=""></p>
					<br>
					<canvas id="p2Color" width="15" height="15"></canvas><p id="p2" class=""></p>
				</div>
				<div id="divThatUsedToCenterTurnDisplay"><canvas id="turnDisplay" width="55" height="55"></canvas></div>
			</div>
			<br>
 			<canvas id="display" width="468" height="468"></canvas>
			<a id="previousMove" href="javascript:previousMove();">Previous Move</a>
			<a id="nextMove" href="javascript:nextMove();">Next Move</a>
 		</div>
    </body>
</html>
