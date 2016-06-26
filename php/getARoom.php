<?php
	$myfile = fopen("room.html", "w") or die("Unable to open file!");
	$txt = "<html>\n<head>\n<title>Generated</title>\n</head>\n<body>\n</body>\n</html>\n";
	fwrite($myfile, $txt);
	fclose($myfile);
?>