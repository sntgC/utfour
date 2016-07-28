function checkForLoggedIn(){
	var cookie = document.cookie;
	if (cookie.indexOf("userID") > -1){
		return true;
	}
	else{
		return false;
	}
}

function authenticateUser(){
	$.ajax({
		url: "php/authenticateUser.php",
		success: function(data){
			if(data == "User authentication successful"){
				$('body').show();
			}
			else if(data == "User authentication failed"){
				try{
					redirect();
				}catch(err){}
			}
		}
	});
}

function adjustTheme(){
	var endOfCookie = document.cookie.length - 1;
	var start = document.cookie.indexOf("theme=") + 6;
	var end = -1;

	var i = 0;
	while(true){
		var current = document.cookie.substring(start + i, start + i + 1);
		if(current == ";"){
			end = start + i;
			break;
		}
		else if (start + i == endOfCookie){
			end = -2;
			break;
		}
		i++;
	}

	var color = "";
	if(end == -2){
		color = document.cookie.substring(start);
	}
	else{
		color = document.cookie.substring(start, end);
	}

	if(color == "blue"){
		return;
	}
	else{
		var cssLink = $('link[href*="style/headerblue.css"]');
		cssLink.replaceWith('<link href="style/header' + color + '.css" type="text/css" rel="stylesheet">');
	}
}