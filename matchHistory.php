<!DOCTYPE html>
<html>
	<head>
		<title>Match History</title>
		<meta charset="utf-8">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<link rel="stylesheet" type="text/css" href="style/header.css">
        <!--Used for table formatting-->
        <link rel="stylesheet" type="text/css" href="style/spectate.css">
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

            function getMatchHistory(){
                $.ajax({
                    url: "php/getCompletedGames.php",
                    type: "GET",
                    data: {userID : getCookie("userID")},
                    success: function(data){
                        if(data == "No matches found"){
                            return;
                        }
                        var array = data.split(" ");
                        console.log(array);
                        var currentTableRow = 1;
                        $("#noneFound").hide();
                        $("#tableDiv").show();
                        for (var i = 0; i < array.length-1; i+=4){
                            var table = document.getElementById("gameHistoryTable");

                            var opponent = array[i];
                            var winner = array[i+1];
                            var creationDate = array[i+2];
                            var endDate = array[i+3];

                            var row = table.insertRow(currentTableRow);
                            var opponentCell = row.insertCell(0);
                            var winnerCell = row.insertCell(1);
                            var creationDateCell = row.insertCell(2);
                            var endDateCell = row.insertCell(3);

                            opponentCell.innerHTML = opponent;
                            winnerCell.innerHTML = winner;
                            creationDateCell.innerHTML = creationDate;
                            endDateCell.innerHTML = endDate;
                        }
                    }
                });
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

            $(document).ready(function(){
                getMatchHistory();
            });
		</script>
        <style>
            #noneFound {
                text-align: center;
            }
        </style>
	</head>
	<body style="display:none">
		<ul class="blue">
			<li class="dropdown right" id="userData">
				<a href="javascript:dropMenu('accountSettings');" class="dropbtn dropdownLink blue"><?php include 'php/loadUserImg.php'; $emailOnly=""; $winsOnly=""; $includeWins="true"; include 'php/getUser.php';?></a>
				<div class="dropdown-content" id="accountSettings">
					<a href="spectate" class="dropdownLink">Spectate</a>
					<a href="php/logoutUser.php" class="dropdownLink">Sign Out</a>
				</div>
			</li>
			<li class="dropdown left">
				<a href="lobby" class="dropbtn title blue">UT<sup>4</sup></a>
			</li>
			<li class="dropdown left">
				<a href="account" class="dropbtn title blue">My Account</a>
			</li>
		</ul>

        <h1 id="noneFound" class="formSectionTitle">No Completed Matches Found</h1>
        <div id="tableDiv" style="display:none">
			<table id="gameHistoryTable" class="blue">
				<tr>
					<th class="blue">Opponent</th>
                    <th class="blue">Winner</th>
					<th class="blue">Started</th>
                    <th class="blue">Ended</th>
				</tr>
			</table>	
		</div>
	</body>
</html>