<?php
	$imageName = $_COOKIE["userID"];
	$target_dir = "../images/userIcons/";
	
	try{
		if (file_exists($target_dir . $imageName . ".jpg")) {
			unlink($target_dir . $imageName . ".jpg");
		}
		else if(file_exists($target_dir . $imageName . ".jpeg")){
			unlink($target_dir . $imageName . ".jpeg");
		}
		else if(file_exists($target_dir . $imageName . ".png")){
			unlink($target_dir . $imageName . ".png");
		}
		else if(file_exists($target_dir . $imageName . ".gif")){
			unlink($target_dir . $imageName . ".gif");
		}
	} catch(Exception $e){}
	
	header("Location: ../account.php");
?>