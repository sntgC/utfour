<!DOCTYPE html>
<html>
	<head>
		<title>How To Play</title>
		<meta charset="utf-8">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style/header.css">
		<link rel="stylesheet" type="text/css" href="style/howtoplay.css">
		<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="script.js"></script>
		<script type="text/javascript" src="UTTTScript.js"></script>
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
		<script type="text/javascript">
			//Looking back at this, it might have been a waste of time but i like the effect it gives so i'm keeping it
			$(document).ready(function(){
				var page1=document.getElementById("page1Grid");
				var page2=document.getElementById("page2InnerGrid");
				var page4=document.getElementById("page4Grid");
				var page5=document.getElementById("page5Grid");
				for(i=0;i<9;i++){
					var ret=[
								page1.innerHTML+"<div class='square' id='sqr"+i+"'></div>",
								page2.innerHTML+"<div class='square page2Square' id='sqrTwo"+i+"'></div>",
								page4.innerHTML+"<div class='bigSqr page4Square' id='sqrFour"+i+"'></div>",
								page5.innerHTML+"<div class='bigSqr page5Square' id='sqrFive"+i+"'></div>"
								];
					if((i+1)%3===0){
						ret[0]+="<br>";
						ret[1]+="<br>";
						ret[2]+="<br>";
						ret[3]+="<br>";
					}
					page1.innerHTML=ret[0];
					page2.innerHTML=ret[1];
					page4.innerHTML=ret[2];
					page5.innerHTML=ret[3];
				}
				for(i=0;i<9;i++){
					var page4=document.getElementById("sqrFour"+i);
					var page5=document.getElementById("sqrFive"+i);
					for(j=0;j<9;j++){
						var ret=[
									page4.innerHTML+"<div class='square page4SmallSquare' id='smallSqrFour"+i+j+"'></div>",
									page5.innerHTML+"<div class='square page5SmallSquare' id='smallSqrFive"+i+j+"'></div>"];
						if((j+1)%3===0){
							ret[0]+="<br>";
							ret[1]+="<br>";
						}
						page4.innerHTML=ret[0];
						page5.innerHTML=ret[1];
					}
				}
				jQuery( "#page2Grid" ).one( "click", function() {
					animatePageTwoGrid();
				});
				loadAFilledSquareInPage5BigSquare3();
				var lastID=null;
				$('.page4SmallSquare').click(function() { 
					if(lastID!=null){
						jQuery("#"+lastID).removeClass("redSqr blueSqr");
						document.getElementById("sqrFour"+lastID.charAt(lastID.length-1)).style.border="0px solid black";
					}
					jQuery("#page4Instructions").hide();
					var id = $(this).attr('id');
					var nextMove=id.charAt(id.length-1);
					var target=document.getElementById("sqrFour"+nextMove);
					target.style.border="5px solid #D32F0C";
					jQuery("#"+id).addClass("blueSqr");
					lastID=id;
				});
				$('.page5SmallSquare').click(function() { 
					var id = $(this).attr('id');
					var nextMove=id.charAt(id.length-1);
					if(nextMove==='3'){
						var targets=document.getElementsByClassName("page5Square");
						for(i=0;i<9;i++)
							if(i!=3)
								targets[i].style.border="5px solid #D32F0C";
						jQuery("#"+id).addClass("blueSqr");
					}
				});
			});
			
			function shuffle(choices){
					var allMoves=choices;
					var ret="";
					while(allMoves.length!=0){
						var index=Math.floor(Math.random()*allMoves.length);
						ret+=allMoves[index];
						allMoves.splice(index,1);
					}
					return ret;
			}
			
			function createAnOrderWhichIsPlausibleForATwoPlayerGameOfTicTacToe(gameString){
				var p1=[];
				var p2=[];
				var retString="";
				for(i=0;i<9;i++){
					if(gameString.charAt(i)==='1')
						p1.push(''+i);
					else
						p2.push(''+i);
				}
				p1=shuffle(p1).split("");
				p2=shuffle(p2).split("");
				for(i=0;i<9;i++){
					if(i%2==0)
						retString+=p1[Math.floor(i/2)];
					else
						retString+=p2[Math.floor(i/2)];
				}
				return retString;
			}
			
			function clearGrid(id) {
				for(i=0;i<9;i++){
					jQuery("#sqr"+i).removeClass();
					jQuery("#sqr"+i).addClass("square");
				}
			}
			
			function animatePageTwoGrid(){
				jQuery("#page2Instructions").hide();
				jQuery(".page2Square").animate({
					width: '150px',
					height: '150px',
					margin: '14px 19px'
				},1000);
				window.setTimeout(function(){
					for(j=0;j<9;j++){
						var div=document.getElementById("sqrTwo"+j);
						div.style.background="#dddddd";
						for(i=0;i<9;i++){
							var ret=div.innerHTML+"<div class='square'></div>";
							if(i%3===2&&i!=8){
								ret+="<br>";
							}
							div.innerHTML=ret;
						}
					}
				},990);
			}
			
			function animateGrid(location, value){
				if(value=='1')
					jQuery(location).addClass("blueSqr");
				else
					jQuery(location).addClass("redSqr");
			}
			
			function loadAFilledSquareInPage5BigSquare3(){
				var data="111221122";
				for(i=0;i<9;i++){
					animateGrid("#smallSqrFive3"+i,data.charAt(i));
				}
			}
			
			var currentData="221112211";
			var genBoard=new MiniGrid(0,0,0);
			genBoard.loadGrid(shuffle(['1','2','1','2','1','2','1','2','1']));
			var turns=0;
			var noTie=genBoard.isWon();
			var order=createAnOrderWhichIsPlausibleForATwoPlayerGameOfTicTacToe(currentData);
			window.setInterval(function(){ 
				if(turns<9){
					if(noTie){
						genBoard.loadGrid(shuffle(['1','2','1','2','1','2','1','2','1']));
						noTie=genBoard.isWon();
					}
					animateGrid("#sqr"+order.charAt(turns),currentData.charAt(parseInt(order.charAt(turns)+"")));
				}else if (turns>10){
					currentData=genBoard.toString();
					genBoard.loadGrid(shuffle(['1','2','1','2','1','2','1','2','1']));
					turns=-1;
					noTie=genBoard.isWon();
					order=createAnOrderWhichIsPlausibleForATwoPlayerGameOfTicTacToe(currentData);
					clearGrid();
				}
				turns++;
			}, 1500);
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
					<a href="spectate" class="dropdownLink">Spectate</a>
					<a href="php/logoutUser.php" class="dropdownLink">Sign Out</a>
				</div>
			</li>
			<li class="dropdown left">
				<a href="lobby" class="dropbtn title blue">UT<sup>4</sup></a>
			</li>
		</ul>

		<div id="nav">
			<ul>
				<li class="left"><a href="#pt1">A Simple Game</a></li>
				<li class="left"><a href="#pt2">A Simple Fix</a></li>
				<li class="left"><a href="#pt3">A Goal</a></li>
				<li class="left"><a href="#pt4">A Twist</a></li>
				<li class="left"><a href="#pt5">A Full Board</a></li>
				<li class="left"><a href="#pt6">Credits</a></li>
			</ul>
		</div>

		<div id="page1" class="centeredGrid">
			<a id="pt1"></a>
				<h3>A Simple Game</h3>
				<p>If you've ever played Tic-Tac-Toe, you had soon come to realize how hard it is to win against a competent opponent</p>
				<br>
				<div id="page1Grid"></div>
		</div>
		<div id="page2" class="centeredGrid">
			<a id="pt2"></a>
				<h3>A Simple Fix</h3>
				<p>To fix this, we simply make a larger board composed of nine smaller boards in a three-by-three pattern</p>
				<p id="page2Instructions"><em>Click on the board</em></p>
				<br>
				<div id="page2Grid">
					<div id="page2InnerGrid">
					</div>
				</div>
		</div>
		<div id="page3" class="centeredGrid">
			<a id="pt3"></a>
				<h3>A Goal</h3>
				<p>In this version of the game, your goal is to win three boards in a row, each of which is won the same way as you would win a regular game of Tic-Tac-Toe</p>
				<div class="centeredGrid" display="inline-block"><img src="images/h2pp3.png"></div>
		</div>
		<div id="page4" class="centeredGrid">
			<a id="pt4"></a>
				<h3>A Twist</h3>
				<p>However, there is an element of strategy to the game. For every piece a player places on a small board, his opponent's next move must be in the respective board on the larger square</p>
				<em id="page4Instructions">Click on any square</em>
				<div id="page4Grid" class="centeredGrid">
				</div>
		</div>
		<div id="page5" class="centeredGrid">
			<a id="pt5"></a>
				<h3>A Full Board</h3>
				<p>However, if the board they are sent to is taken or completely full, they can play anywhere on the board</p>
				<em>Try to send your opponent to the large square in the middle left</em>
				<div id="page5Grid" class="centeredGrid">
				</div>
		</div>
		<div id="page6" class="centeredGrid">
			<a id="pt6"></a>
				<h3>Credits</h3>
				<p>Thanks to <a href='https://mathwithbaddrawings.com/2013/06/16/ultimate-tic-tac-toe/' id="creditLink">Math with Bad Drawings</a> for the original idea.</p>
				<p><small>UT<sup>4</sup> is only supported on modern browsers such as Chrome and Firefox, not Internet Explorer or Microsoft Edge</small></p>
		</div>
	</body>
</html>
