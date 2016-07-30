<?php
	$dir = "images/userIcons/";
	$imageName = $_COOKIE["userID"];
	
	if (isset($from)) {
		if($from == "room"){
			$dir = "../images/userIcons/";
		}
	}
	
	if (file_exists($dir . $imageName . ".jpg")) {
		$source = $dir . $imageName . ".jpg";
		echo "<img id='usrImg' src='$source' width='30' height='30'> ";
	}
	else if(file_exists($dir . $imageName . ".jpeg")){
		$source = $dir . $imageName . ".jpeg";
		echo "<img id='usrImg' src='$source' width='30' height='30'> ";
	}
	else if(file_exists($dir . $imageName . ".png")){
		$source = $dir . $imageName . ".png";
		echo "<img id='usrImg' src='$source' width='30' height='30'> ";
	}
	else if(file_exists($dir . $imageName . ".gif")){
		$source = $dir . $imageName . ".gif";
		echo "<img id='usrImg' src='$source' width='30' height='30'> ";
	}
	else{
		$source = $dir . "defaultIcon.jpg";
		echo "<img id='usrImg' src='$source' width='30' height='30'> ";
	}
?>