<!DOCTYPE html>
<html>
	<head>
		<title>My Account</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="style.css">
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
		
			$(function(){
				$( "#upload_link" ).on('click',function(e) {
					e.preventDefault();
					$('#selector:hidden').trigger('click');
					$('#selector:hidden').on('change',function(){
						document.getElementById("selectedFile").innerHTML = this.value;
					});
				});
			});
		</script>
	</head>
	<body>
		<a href="lobby">Home Page</a>
		<h3>My Account</h3>
		Username: <b><?php $includeWins="false"; $winsOnly=""; include 'php/getUser.php';?></b><br>
		Profile picture: <img src="images/userIcons/defaultIcon.jpg" width="25" height="25"><br>
		Number of wins: <b><?php $winsOnly="true"; $includeWins=""; include 'php/getUser.php';?></b></br><br>
		<a href="changePassword">Change my password</a><br>
		<a href="" id="upload_link" title="The selected image must be no larger than 2 MB">Change my profile picture</a><br>
		<input id="selector" type="file" accept="image/*" style="display:none;"/>
		<span id="selectedFile"></span>
	</body>
</html>