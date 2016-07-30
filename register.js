authenticateUser();
adjustTheme();

var availableUsername=false;
var availableEmail=false;
var goodEntry = true;

function verifyForm(){
	var username = document.forms["registrationForm"]["usernameIn"].value;
	var email = document.forms["registrationForm"]["emailIn"].value;
	var emailConf = document.forms["registrationForm"]["emailInConf"].value;
	var password = document.forms["registrationForm"]["passwordIn"].value;
	var passwordConf = document.forms["registrationForm"]["passwordInConf"].value;
	goodEntry = true;
	
	document.getElementById("alert").innerHTML = "";
	
	document.getElementById("usernameNotif").style.display = "none";
	document.getElementById("usernameNotif").innerHTML = "";
	
	if (username.length < 6){
		document.getElementById("usernameNotif").style.display = "block";
		document.getElementById("usernameNotif").innerHTML = "Username is too short";
		goodEntry = false;
	}
	else if (username.length > 20){
		document.getElementById("usernameNotif").style.display = "block";
		document.getElementById("usernameNotif").innerHTML = "Username is too long";
		goodEntry = false;
	}
	else if(!availableUsername){
		document.getElementById("usernameNotif").style.display = "block";
		document.getElementById("usernameNotif").innerHTML = "Username is not available";
		goodEntry = false;
	}
	else{
		document.getElementById("usernameNotif").style.display = "none";
		document.getElementById("usernameNotif").innerHTML = "";
	}
	
	document.getElementById("emailNotif").style.display = "none";
	document.getElementById("emailNotif").innerHTML = "";
	document.getElementById("emailConfNotif").style.display = "none";
	document.getElementById("emailConfNotif").innerHTML = "";
	
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if(!availableEmail){
		document.getElementById("emailNotif").style.display = "block";
		document.getElementById("emailNotif").innerHTML = "Email is not available";
		goodEntry = false;
	}
	else if(!re.test(email)){
		document.getElementById("emailNotif").style.display = "block";
		document.getElementById("emailNotif").innerHTML = "Email is invalid";
		goodEntry = false;
	}
	else if(email.length > 100){
		document.getElementById("emailNotif").style.display = "block";
		document.getElementById("emailNotif").innerHTML = "Email is too long";
		goodEntry = false;
	}
	else if(email != emailConf){
		document.getElementById("emailNotif").style.display = "block";
		document.getElementById("emailNotif").innerHTML = "Emails do not match";
		document.getElementById("emailConfNotif").style.display = "block";
		document.getElementById("emailConfNotif").innerHTML = "Emails do not match";
		goodEntry = false;
	}
	else{
		document.getElementById("emailNotif").style.display = "none";
		document.getElementById("emailNotif").innerHTML = "";
		document.getElementById("emailConfNotif").style.display = "none";
		document.getElementById("emailConfNotif").innerHTML = "";
	}
	
	document.getElementById("passwordNotif").style.display = "none";
	document.getElementById("passwordNotif").innerHTML = "";
	document.getElementById("passwordConfNotif").style.display = "none";
	document.getElementById("passwordConfNotif").innerHTML = "";
	
	if (password.length < 6){
		document.getElementById("passwordNotif").style.display = "block";
		document.getElementById("passwordNotif").innerHTML = "Password is too short";
		goodEntry = false;
	}
	else if (password.length > 20){
		document.getElementById("passwordNotif").style.display = "block";
		document.getElementById("passwordNotif").innerHTML = "Password is too long";
		goodEntry = false;
	}
	else if (password != passwordConf){
		document.getElementById("passwordNotif").style.display = "block";
		document.getElementById("passwordNotif").innerHTML = "Passwords do not match";
		document.getElementById("passwordConfNotif").style.display = "block";
		document.getElementById("passwordConfNotif").innerHTML = "Passwords do not match";
		goodEntry = false;
	}
	else{
		document.getElementById("passwordNotif").style.display = "none";
		document.getElementById("passwordNotif").innerHTML = "";
		document.getElementById("passwordConfNotif").style.display = "none";
		document.getElementById("passwordConfNotif").innerHTML = "";
	}
	
	return goodEntry;
}

function init(){
	document.getElementById("checkmarkUsr").style.display = "none";
	document.getElementById("xUsr").style.display = "none";
	document.getElementById("checkmarkEmail").style.display = "none";
	document.getElementById("xEmail").style.display = "none";
	document.getElementById("usernameNotif").style.display = "none";
	document.getElementById("emailNotif").style.display = "none";
	document.getElementById("emailConfNotif").style.display = "none";
	document.getElementById("passwordNotif").style.display = "none";
	document.getElementById("passwordConfNotif").style.display = "none";
}

function checkUsername(str){
	if (str == ""){
		document.getElementById("xUsr").style.display = "none";
		document.getElementById("checkmarkUsr").style.display = "none";
		availableUsername=false;
		return;
	}
	$.post("php/checkForUser.php",
		   {username : str},
		   function(data){
				if(data == "true"){
					document.getElementById("xUsr").style.display = "inline";
					document.getElementById("checkmarkUsr").style.display = "none";
					availableUsername=false;
				}
				else if(data == "false"){
					document.getElementById("checkmarkUsr").style.display = "inline";
					document.getElementById("xUsr").style.display = "none";
					availableUsername=true;
				}
		   }
	);
}

function checkEmail(str){
	if (str == ""){
		document.getElementById("xEmail").style.display = "none";
		document.getElementById("checkmarkEmail").style.display = "none";
		availableEmail=false;
		return;
	}
	$.post("php/checkForEmail.php",
		   {email : str},
		   function(data){
				if(data == "true"){
					document.getElementById("xEmail").style.display = "inline";
					document.getElementById("checkmarkEmail").style.display = "none";
					availableEmail=false;
				}
				else if(data == "false"){
					document.getElementById("checkmarkEmail").style.display = "inline";
					document.getElementById("xEmail").style.display = "none";
					availableEmail=true;
				}
		   }
	);
}

$(document).ready(function(){
	$("#submit").on('click',function(){
		verifyForm();
		if(verifyForm() == false){
			return false;
		}
		$.post($("#registrationForm").attr("action"),
			   $("#registrationForm :input").serializeArray(),
			   function(data){
				   if(data == "Registration successful"){
					   window.location.replace("login");
				   }
				   else{
					   $("#alert").html(data);
				   }
			   }
		);
		return false;
	})
});