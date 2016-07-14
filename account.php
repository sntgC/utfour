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
				$('#upload_link').on('click',function(e) {
					e.preventDefault();
					$('#fileToUpload').trigger('click');
					$('#fileToUpload').on('change',function(){
						if(document.getElementById("fileToUpload").value.length > 0){
							document.getElementById("submit").click();
						}
					});
				});
			});
		</script>
	</head>
	<body>
		<a href="lobby">Home Page</a>
		<h3>My Account</h3>
		Username: <b><?php $includeWins="false"; $winsOnly=""; include 'php/getUser.php';?></b><br>
		Profile picture: <?php include 'php/loadUserImg.php'; ?><br>
		Number of wins: <b><?php $winsOnly="true"; $includeWins=""; include 'php/getUser.php';?></b><br><br>
		<a href="changePassword">Change my password</a><br>
		<a href="" id="upload_link" title="The selected image must be no larger than 500 kB">Change my profile picture</a><br>
		<form id="picForm" action="php/uploadUserImg.php" method="post" enctype="multipart/form-data">
			<input id="fileToUpload" name="fileToUpload" type="file" accept="image/*" style="display:none;">
			<input type="submit" id="submit" name="submit" style="display:none;">
		</form>
	</body>
</html>