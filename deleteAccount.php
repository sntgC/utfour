<!DOCTYPE html>
<html>
	<head>
		<title>Delete My Account</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style/utfour.css">
		<link rel="stylesheet" type="text/css" href="style/form.css">
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
			
			$(document).ready(function(){
				$(window).keydown(function(event){
					if(event.keyCode == 13){
						event.preventDefault();
						return false;
					}
				});
				$("#submit").on('click',function(){
					$.post($("#deleteForm").attr("action"),
						   $("#deleteForm :input").serializeArray(),
						   function(data){
								if(data == "Account deletion successful"){
									window.location.replace("index");
								}
								else if(data == "Authentication failed"){
									window.location.replace("login");
								}
								else{
									$("#alert").html(data);
								}
						   }
					);
					return false;
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
		</script>
	</head>
	<body style="display:none">
		<div class="header">
			<div class="dropdown right" id="userData">
				<a href="javascript:dropMenu('accountSettings');" class="dropbtn blue"><?php include 'php/loadUserImg.php'; $emailOnly=""; $winsOnly=""; $includeWins="true"; include 'php/getUser.php';?></a>
				<div class="dropdown-content" id="accountSettings">
					<a href="spectate" class="dropdownLink">Spectate</a>
					<a href="php/logoutUser.php" class="dropdownLink">Sign Out</a>
				</div>
			</div>
            <span class="filler"></span>
			<div class="dropdown left">
				<a href="account" class="dropbtn title blue">My Account</a>
			</div>
			<div class="dropdown left">
				<a href="lobby" class="dropbtn title blue">UT<sup>4</sup></a>
			</div>
		</div>
        <div class="center-container">
            <div class="form-container">
                <h1 class="form-title">Delete My Account</h1>
                <div class="formSection blue">
                    <p id="alert" class="warningText"></p>
                    <p class="warningText">WARNING! By entering your password and clicking the delete button, you understand<br> that all of your current progress will be destroyed and will be unrecoverable.</p>
                    <form id="deleteForm" action="php/deleteUser.php" method="post">
                        <label class="form-label">Password</label><br>
                        <input class="form-text-field" id="password" name="password" type="password"><br>
                        <input class="submit" id="submit" name="submit" type="submit" value="Delete Account"><br>
                    </form>
                </div>
            </div>
        </div>
	</body>
</html>