<?php
	$dir = "images/userIcons/";
	$imageName = $_COOKIE["userID"];
	
	if (file_exists($dir . $imageName . ".jpg")) {
		$source = $dir . $imageName . ".jpg";
		echo "<img src='$source' width='30' height='30'> ";
	}
	else if(file_exists($dir . $imageName . ".jpeg")){
		$source = $dir . $imageName . ".jpeg";
		echo "<img src='$source' width='30' height='30'> ";
	}
	else if(file_exists($dir . $imageName . ".png")){
		$source = $dir . $imageName . ".png";
		echo "<img src='$source' width='30' height='30'> ";
	}
	else if(file_exists($dir . $imageName . ".gif")){
		$source = $dir . $imageName . ".gif";
		echo "<img src='$source' width='30' height='30'> ";
	}
	else{
		$source = $dir . "defaultIcon.jpg";
		echo "<img src='$source' width='30' height='30'> ";
	}
?>