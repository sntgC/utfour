<!DOCTYPE html>
<html>
	<head>
		<title>My Account</title>
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
			adjustTheme();
			
			var showing = false;
			function showThemeChanger(){
				$("#changeThemeForm").toggle();
				showing = !showing;
				if(showing){
					$("#changeThemeLink").html("Hide theme selector");
					$("#changeThemeBr").show();
				}
				else{
					$("#changeThemeLink").html("Change theme color");
					$("#changeThemeBr").hide();
				}
			}

			$(document).ready(function(){
				$('#upload_link').on('click',function(e) {
					e.preventDefault();
					$('#fileToUpload').trigger('click');
					$('#fileToUpload').on('change',function(){
						if(document.getElementById("fileToUpload").value.length > 0){
							$("#submit").click(); 
						}
					});
				});
				$(document).on('submit','form#picForm',function(e){
					var formData = new FormData($("#picForm")[0]);
					$.ajax({
						url: $("#picForm").attr("action"),
						type: "POST",
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						success: function(data){
							$("#alert").html(data);
							if (data == "Your new profile picture has been uploaded successfully. Please <a href='javascript:window.location.reload();'>refresh</a> the webpage in order for the change to be visible on your end."){
								$("#alert").removeClass("warningText").addClass("alertText");
							}
							else{
								$("#alert").removeClass("alertText").addClass("warningText");
							}
						}
					});
					return false;
				});
				$("#submitTheme").on('click',function(){
					$.post($("#changeThemeForm").attr("action"),
						   $("#changeThemeForm").serializeArray(),
						   function(data){
							   if(data == "Theme color updated."){
								   window.location.reload();
								   return;
							   }
							   $("#alert").removeClass("alertText").addClass("warningText");
							   $("#alert").html(data);
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
	<body style="display:none">
		<ul class="blue">
			<li class="dropdown right" id="userData">
				<a href="javascript:dropMenu('accountSettings');" class="dropbtn dropdownLink blue"><?php include 'php/loadUserImg.php'; $emailOnly=""; $winsOnly=""; $includeWins="true"; include 'php/getUser.php';?></a>
				<div class="dropdown-content" id="accountSettings">
					<a href="php/logoutUser.php" class="dropdownLink">Sign Out</a>
					<a href="index" class="dropdownLink">Spectate</a>
				</div>
			</li>
			<li class="dropdown left">
				<a href="lobby" class="dropbtn title blue">UT<sup>4</sup></a>
			</li>
		</ul>
		<h3 id="accountTitle">My Account</h3>
		<p id="alert" class="accountMenuAlert"></p>
		<div id="accountMenu" class="blue">
			<table>
				<tr>
					<td class="label">Username:</td>
					<td class="input"><b><?php $emailOnly=""; $includeWins="false"; $winsOnly=""; include 'php/getUser.php';?></b></td>
				</tr>
				<tr>
					<td class="label">Email Address:</td>
					<td class="input"><b><?php $emailOnly="true"; $includeWins=""; $winsOnly=""; include 'php/getUser.php';?></b></td>
				</tr>
				<tr>
					<td class="label">Profile Picture:</td>
					<td class="input"><?php include 'php/loadUserImg.php'; ?></td>
				</tr>
				<tr>
					<td class="label">Number of Wins:</td>
					<td class="input"><b><?php $emailOnly=""; $winsOnly="true"; $includeWins=""; include 'php/getUser.php';?></b></td>
				</tr>
			</table>
			<a href="changeEmail">Change my email address</a><br>
			<a href="changePassword">Change my password</a><br>
			<a href="javascript: showThemeChanger();" id="changeThemeLink">Change theme color</a><br>
			<form id="changeThemeForm" name="changeThemeForm" action="php/updateTheme.php" method="post" style="display:none">
				<select name="colorSelector">
					<option value="blue">Blue</option>
					<option value="green">Green</option>
					<option value="orange">Orange</option>
					<option value="red">Red</option>
				</select>
				<input id="submitTheme" type="submit" name="submit" value="Change Theme">
			</form>
			<br id="changeThemeBr" style="display:none">
			<a href="" id="upload_link" title="The selected image must be no larger than 500 kB">Change my profile picture</a><br>
			<a href="php/resetUserImg.php" id="reset_link" title="This will reset your profile picture to the default user image">Reset my profile picture</a><br>
			<a href="deleteAccount">Delete my account</a>
			<form id="picForm" action="php/uploadUserImg.php" method="post" enctype="multipart/form-data">
				<input id="fileToUpload" name="fileToUpload" type="file" accept="image/*" style="display:none;">
				<input type="submit" id="submit" name="submit" style="display:none;">
			</form>
		</div>
	</body>
</html>