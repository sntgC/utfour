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