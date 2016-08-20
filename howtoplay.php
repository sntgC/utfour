<!DOCTYPE html>
<html>
	<head>
		<title>How To Play</title>
		<meta charset="utf-8">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style/header.css">
		<link rel="stylesheet" type="text/css" href="style/howtoplay.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="script.js"></script>
		<script type="text/javascript">
			authenticateUser();
			function adjustNav(){
				if(checkForLoggedIn()){
					$(document).ready(function(){
						$("#parentNav2").show();
						$("#parentNav1").hide();
					});
				}
			}
			adjustNav();
			adjustTheme();

			$(document).ready(function(){
				$("a").on('click', function(event) {
						if (this.hash !== "") {
							event.preventDefault();
							var hash = this.hash;
							$('html, body').animate({
								scrollTop: $(hash).offset().top
								}, 800, function(){
								window.location.hash = hash;
							});
						}
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
	<body>
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
					<a href="php/logoutUser.php" class="dropdownLink">Sign Out</a>
					<a href="spectate" class="dropdownLink">Spectate</a>
				</div>
			</li>
			<li class="dropdown left">
				<a href="lobby" class="dropbtn title blue">UT<sup>4</sup></a>
			</li>
		</ul>

		<div id="nav">
			<ul>
				<li class="left"><a href="#pt1">Part 1</a></li>
				<li class="left"><a href="#pt2">Part 2</a></li>
				<li class="left"><a href="#pt3">Part 3</a></li>
				<li class="left"><a href="#pt4">Part 4</a></li>
				<li class="left"><a href="#pt5">Part 5</a></li>
				<li class="left"><a href="#pt6">Part 6</a></li>
			</ul>
		</div>

		<div id="page1">
			<a id="pt1"></a>
				<h3>A Simple Game</h3>
				<p>If you've ever played Tic-Tac-Toe, you had soon come to realize how hard it is to win against a competent opponent</p>
				<i>>Mini Tic-Tac-Toe Board</i>
		</div>
		<div id="page2">
			<a id="pt2"></a>
				<h3>A Simple Fix</h3>
				<p>To fix this, we simply make a larger board composed of nine smaller boards in a three-by-three pattern</p>
				<i>Animation</i></i>
		</div>
		<div id="page3">
			<a id="pt3"></a>
				<h3>A Goal</h3>
				<p>In this version of the game, your goal is to win three boards in a row, each of which is won the same way as you would win a regular game of Tic-Tac-Toe</p>
				<i>Animation</i>
		</div>
		<div id="page4">
			<a id="pt4"></a>
				<h3>A Twist</h3>
				<p>However, there is an element of strategy to the game. For every piece a player places on a small board, his opponent's next move must be in the respective board on the larger square</p>
				<i>Animation</i>
		</div>
		<div id="page5">
			<a id="pt5"></a>
				<h3>A Full Board</h3>
				<p>However, if the board they are sent to is taken or completely full, they can play anywhere on the board</p>
				<i>Animation</i>
		</div>
		<div id="page6">
			<a id="pt6"></a>
				<h3>Credits</h3>
				<p>Thanks to <a href='https://mathwithbaddrawings.com/2013/06/16/ultimate-tic-tac-toe/'>Math with Bad Drawings</a> for the original idea.</p>
				<p><small>UT<sup>4</sup> is only supported on modern browsers such as Chrome and Firefox, not Internet Explorer or Microsoft Edge</small></p>
		</div>
	</body>
</html>
