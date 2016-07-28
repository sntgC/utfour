<?php
	unset($_COOKIE["userID"]);
	setcookie("userID","",time() - (86400*366),"/");
	unset($_COOKIE["sessionID"]);
	setcookie("sessionID","",time() - (86400*366), "/");
	unset($_COOKIE["theme"]);
	setcookie("theme","",time() - (86400*366),"/");
	header("Location: ../index");
?>