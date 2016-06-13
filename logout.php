<?php
	$cookie_name="username";
	unset($_COOKIE[$cookie_name]);
	setcookie($cookie_name,"",time() - (86400*366),"/");
	//Temporary redirect. Will be set to index.html later on.
	header("Location: lobby.html");
?>