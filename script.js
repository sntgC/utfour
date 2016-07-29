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

function getCookie(cookie_name){
	if(document.cookie.indexOf(cookie_name + "=") < 0){
		return;
	}
	var endOfCookie = document.cookie.length - 1;
	var start = document.cookie.indexOf(cookie_name+"=") + cookie_name.length + 1;
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

	var cookie_value = "";
	if(end == -2){
		cookie_value = document.cookie.substring(start);
	}
	else{
		cookie_value = document.cookie.substring(start, end);
	}

	return cookie_value;
}

function adjustTheme(){
	var color = getCookie("theme");
	if(color == "blue"){
		return;
	}
	else{
		$(document).ready(function(){
			$(".blue").removeClass("blue").addClass(color);
		});
	}
}