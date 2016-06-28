<?php
	$newFile = fopen("$_GET[fileName]".".html", "w") or die("Unable to open file!");
	$roomTemplate = fopen('../room.html','r');
	while ($line = fgets($roomTemplate)) {
		fwrite($newFile, $line);
	}
	fclose($newFile);
	fclose($roomTemplate);
	echo"all good";
?>