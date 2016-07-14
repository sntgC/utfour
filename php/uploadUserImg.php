<?php
	$imageName = $_COOKIE["userID"];
	$target_dir = "../images/userIcons/";
	$uploadOk = 1;
	$imageFileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
	$target_file = $target_dir . $imageName . "." .$imageFileType;
	
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
	&& $imageFileType != "gif" ) {
		echo "Only JPG, JPEG, PNG & GIF files are allowed. ";
		$uploadOk = 0;
	}
	
	if ($uploadOk == 0) {
		echo "Your file was not uploaded. ";
		header("Location: ../account");
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
	
	if ($uploadOk == 0) {
		echo "Your file was not uploaded. ";
	} 
	else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". $imageName . "." .$imageFileType . " has been uploaded. ";
		} else {
			echo "There was an error uploading your file. ";
		}
	}
	
	header("Location: ../account");
?>