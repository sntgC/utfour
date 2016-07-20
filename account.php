<!DOCTYPE html>
<html>
	<head>
		<title>My Account</title>
		<meta charset="utf-8">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style/style.css">
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
						}
					});
					return false;
				});
			});
		</script>
	</head>
	<body>
		<a href="lobby">Home Page</a>
		<h3>My Account</h3>
		<p id="alert"></p>
		Username: <b><?php $emailOnly=""; $includeWins="false"; $winsOnly=""; include 'php/getUser.php';?></b><br>
		Email address: <b><?php $emailOnly="true"; $includeWins=""; $winsOnly=""; include 'php/getUser.php';?></b><br>
		Profile picture: <?php include 'php/loadUserImg.php'; ?><br>
		Number of wins: <b><?php $emailOnly=""; $winsOnly="true"; $includeWins=""; include 'php/getUser.php';?></b><br><br>
		<a href="changeEmail">Change my email address</a><br>
		<a href="changePassword">Change my password</a><br>
		<a href="" id="upload_link" title="The selected image must be no larger than 500 kB">Change my profile picture</a><br>
		<a href="php/resetUserImg.php" id="reset_link" title="This will reset your profile picture to the default user image">Reset my profile picture</a><br>
		<a href="deleteAccount">Delete my account</a>
		<form id="picForm" action="php/uploadUserImg.php" method="post" enctype="multipart/form-data">
			<input id="fileToUpload" name="fileToUpload" type="file" accept="image/*" style="display:none;">
			<input type="submit" id="submit" name="submit" style="display:none;">
		</form>
	</body>
</html>