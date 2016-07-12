function checkForLoggedIn(){
	var cookie = document.cookie;
	if (cookie.indexOf("userID") > -1){
		return true;
	}
	else{
		return false;
	}
}