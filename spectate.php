<!DOCTYPE html>
<html>
	<head>
		<title>Spectate</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style/utfour.css">
		<link rel="stylesheet" type="text/css" href="style/form.css">
		<link rel="stylesheet" type="text/css" href="style/table.css">
		<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="script.js"></script>
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

			function showSearch (){
				$("#formDiv").show();
				$("#tableDiv").hide();
				$(".formSectionTitle").css("text-align","");
				$("#return").hide();
				$("#gameListTable tr:not(:first)").remove();
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
				if (!e.target.matches('#usrImg')&&!e.target.matches(".dropdownLink")&&!e.target.matches(".dropbtn")) {
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
			};

			$(document).ready(function(){
				$("#submit").on("click",function(){
					$.get("php/getGames.php",
						  $("#spectateForm :input").serializeArray(),
						  function(data){
							  if(data == "Username input empty"){
								  $("#alert").html("Please enter a valid player name");
							  }
							  else if(data == "No games found" || data == "User not found"){
								  $("#alert").html(data);
							  }
							  else {
								  $("#formDiv").hide();
								  $("#tableDiv").show();
								  $(".formSectionTitle").css("text-align","center");
								  $("#return").show();

								  var array = data.split(" ");
								  var currentTableRow = 1;
								  for (var i = 0; i < array.length-1; i+=2){
									  var table = document.getElementById("gameListTable");

									  var gameRoomID = array[i];
									  var opponent = array[i+1];

									  var row = table.insertRow(currentTableRow);
									  var opponentCell = row.insertCell(0);
									  var linkCell = row.insertCell(1);

									  opponentCell.innerHTML = opponent;
									  linkCell.innerHTML = "<a href='matches/" + gameRoomID + "'>" + gameRoomID + "</a>";
								  }
							  }
						  }
					);
					return false;
				});
			});
		</script>
	</head>
	<body>
        <ul class="header" id="parentNav1">
			<li class="dropdown left">
				<a href="index" class="dropbtn title blue">UT<sup>4</sup></a>
			</li>
		</ul>

        <div class="header" id="parentNav2" style="display:none">
			<div class="dropdown right" id="userData">
				<a href="javascript:dropMenu('accountSettings');" class="dropbtn blue"><?php include 'php/loadUserImg.php'; $emailOnly=""; $winsOnly=""; $includeWins="true"; include 'php/getUser.php';?></a>
				<div class="dropdown-content" id="accountSettings">
					<a href="account" class="dropdownLink">My Account</a>
					<a href="php/logoutUser.php" class="dropdownLink">Sign Out</a>
				</div>
			</div>
            <span class="filler"></span>
			<div class="dropdown left">
				<a href="lobby" class="dropbtn title blue">UT<sup>4</sup></a>
			</div>
		</div>
        <div class="center-container">
            <div class="form-container">
                <h1 class="form-title">Spectate Game</h1>
                <div class="formSection blue" id="formDiv">
                    <p id="alert" class="warningText"></p>
                    <form id="spectateForm">
                        <label for="usernameIn" class="form-label">Player Name</label>
                        <br>
                        <input type="text" name="username" id="usernameIn" class="form-text-field">
                        <br>
                        <input type="submit" id="submit" value="Search" class="submit">
                    </form>
                </div>
                <div id="tableDiv" class="table-container" style="display:none;">
                    <table id="gameListTable" class="blue">
                        <tr>
                            <th class="blue">Opponent</th>
                            <th class="blue">Link</th>
                        </tr>
                    </table>	
                    <a href="javascript: showSearch();" id="return" style="display:none">Return to Search</a>
                </div>
            </div>
        </div>
	</body>
</html>