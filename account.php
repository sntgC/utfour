<!DOCTYPE html>
<html>
	<head>
		<title>My Account</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript" src="script.js"></script>
		<script type="text/javascript">
			authenticateUser();
			function redirect(){
				if(checkForLoggedIn() == false){
					window.location.replace("login");
				}
			}
			redirect();
		</script>
	</head>
	<body>
		<a href="lobby">Home Page</a>
		<h3>My Account</h3>
		Username: <b><?php $includeWins="false"; $winsOnly=""; include 'php/getUser.php';?></b><br>
		Number of wins: <b><?php $winsOnly="true"; $includeWins=""; include 'php/getUser.php';?></b></br>
		<a href="changePassword">Change my password</a>
	</body>
</html>