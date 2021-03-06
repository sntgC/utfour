<?php
	$imageName = $_COOKIE["userID"];
	$target_dir = "../images/userIcons/";
	$uploadOk = 1;
	$imageFileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
	$target_file = $target_dir . $imageName . "." . strtolower($imageFileType);
	
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check === false) {
			echo "File is not an image. ";
			$uploadOk = 0;
		}
	}
	
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		echo "File is too large. ";
		$uploadOk = 0;
	}
	
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" 
	&& $imageFileType != "JPEG" && $imageFileType != "GIF") {
		echo "Only JPG, JPEG, PNG & GIF files are allowed. ";
		$uploadOk = 0;
	}
	
	if ($uploadOk == 0) {
		echo "Your file was not uploaded. ";
		exit();
	}
	
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
	
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		echo "Your new profile picture has been uploaded successfully. Please <a href='javascript:window.location.reload();'>refresh</a> the webpage in order for the change to be visible on your end.";
	} else {
		echo "There was an error uploading your file. ";
	}
?>