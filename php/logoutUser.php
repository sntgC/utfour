<?php
	$cookie_name="userID";
	unset($_COOKIE[$cookie_name]);
	setcookie($cookie_name,"",time() - (86400*366),"/");
	header("Location: ../index");
?>