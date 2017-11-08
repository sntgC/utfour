if(typeof(EventSource) === "undefined"){
	alert("Server-Sent Events are not supported on this browser. Please upgrade to a new browser.");
}

var source = new EventSource('php/lobbySSE.php?user='+document.cookie.substring(document.cookie.indexOf("userID=") + 7,document.cookie.indexOf("userID=") + 14));
source.onmessage = function(e) {
	document.getElementById("players").innerHTML=e.data;
 };
 
var notificationSource = new EventSource('php/notificationSSE.php?userID='+document.cookie.substring(document.cookie.indexOf("userID=") + 7,document.cookie.indexOf("userID=") + 14));
var lastNotification="";
notificationSource.onmessage = function(e) {
	if(e.data===""){
		document.getElementById("notification").innerHTML="<a class='dropdownLink'><em class='dropdownLink'>No games available</em></a>";
		document.getElementById("notifLink").innerHTML="<img src='images/notifications.png' height='30' width='30' class='dropdownLink'>";
		notificationsChecked=false;
		return;
	}
	if(e.data!=lastNotification){
		lastNotification=e.data;
		document.getElementById("notifLink").innerHTML="<img src='images/notificationsOn.png' height='30' width='30' class=''>";
		notificationsChecked=false;
	}
	document.getElementById("notification").innerHTML=e.data;
	if(notificationsChecked){
		document.getElementById("notifLink").innerHTML="<img src='images/notifications.png' height='30' width='30' class=''>";
	}
 };

var featuredGameSource = new EventSource("php/featuredGameSSE.php");
var previousGame = "";
featuredGameSource.onmessage = function(e) {
	if (e.data == previousGame){
		return;
	}
	else {
		if(e.data == ""){
			previousGame = "";
			if($("#featuredGame").css("display") == "none"){
				return;
			}
			else{
				toggleFeaturedGame();
				return;
			}
		}
		if(previousGame == ""){
			toggleFeaturedGame();
		}
		$("#featuredGame").attr("src","matches/"+e.data);
		previousGame = e.data;
	}
};

function generateRooms(players, playerNames){
	/*
	Generates the rooms for the server
	
	players-number of players
	*/
	var gamesInTournament=[];
	var length=2*Math.pow(2,Math.ceil(Math.log(players/2)/Math.log(2)))-1;
	for(k=0; k < length;k++){
		/* Apparently when I call generateID(), the 'i' I use in the for-loops in that function
			is the same as the 'i' I use in this loop, so I had to change the name
		*/
		gamesInTournament.push(generateID());
	}
	//Turns ids into Game objects
	for(k=0;k<length;k++){
		gamesInTournament[k]=new Game(gamesInTournament[k],"","","","");
	}
	//Sends game objects to server
	populate(playerNames,gamesInTournament);
	var initialRooms=(gamesInTournament.length+1)/2;
	for(k=0;k<length;k++){
		var p1=k%2===0;
		var childPos=initialRooms+Math.floor(k/2);
		var pointerString=p1? "P1":"P2";
		if(childPos<gamesInTournament.length){
			pointerString+="_OF_"+gamesInTournament[childPos].id;
		}else{
			pointerString="WINNER";
		}
		jQuery.post('php/getARoom.php',
						 {'fileName':gamesInTournament[k].id,'player1ID':gamesInTournament[k].p1,'player2ID':gamesInTournament[k].p2,'pointer':pointerString,'consent':1},
							function(data){
									console.log(data);
								});
	}
	return(gamesInTournament);
}

function generatePrivateGame(){
	var usernameIn=document.getElementById("requestedUsername").value;
	usernameIn=cleanString(usernameIn);
	$.post("php/checkForUser.php",
		   {username : usernameIn},
		   function(data){
			   if(data == "false"){
					$("#alert").html("This user does not exist.");
					$("#alert").removeClass("alertText").addClass("warningText");
					$("#alert").show();
			   }
			   else if(data == "true"){
					//$¢ Change the pointer to something else that doesn't trigger a win upgrade
					console.log(usernameIn);
					jQuery.post('php/getARoom.php',
								{'fileName':generateID(),
								'player1ID':document.cookie.substring(document.cookie.indexOf("userID=") + 7,document.cookie.indexOf("userID=") + 14),
								'player2ID':"(SELECT userID FROM users WHERE username='"+usernameIn+"')",
								'pointer':"SOLOWINNER",
								'consent':0},
								function(data){
									if(data == "Game request sent to user."){
										$("#alert").removeClass("warningText").addClass("alertText");
									}
									else{
										$("#alert").removeClass("alertText").addClass("warningText");
									}
									$("#alert").html(data);
									$("#alert").show();
								}
					);
			   }
		   }
	);
}

function acceptMatchRequest(response ,id){
	var element=document.getElementById(id);
	element.parentNode.removeChild(element);
	jQuery.post('php/matchResponse.php', {'response':response, 'matchID':id},function(data){
		console.log(data);
	});
}

function cleanString(dat){
	//$¢Prevents SQL Injection
	if(dat.indexOf("'")>-1||dat.indexOf(';')>-1){
		return 'null' 	
	}
	return dat;
}

function populate(players, games){
	/* $¢Room for improvement */
	var shuffledPlayers=[];
	var playersCopy=players.slice(0);
	while(playersCopy.length>0){
		var randInd=Math.floor(Math.random()*playersCopy.length);
		shuffledPlayers.push(playersCopy.splice(randInd,1)[0]);
	}
	var pIndex=0;
	for(g=0;g<games.length;g++){
		if(pIndex>=shuffledPlayers.length)
			break;
		if(!games[g].hasP1()){
			games[g].setP1(shuffledPlayers[pIndex++]);
			g--;
		}else if(!games[g].hasP2()){
			games[g].setP2(shuffledPlayers[pIndex++]);
		}
	}
}


function beginTournament(){
	jQuery.get('php/getLobbyPlayers.php',function(data){
		console.log(data);
		var tourID=generateID();
		var tourData="";
		data=data.substring(0,data.length-1);
		var ids=data.split(" ");
		var rooms=generateRooms(ids.length,ids);
		for(g=0;g<rooms.length;g++){
			tourData+=rooms[g].id+" ";
		}
		tourData=tourData.substring(0,tourData.length-1);
		jQuery.post('php/registerTournament.php',{'tourID':tourID, 'tourData':tourData}, function(){console.log("callback")});
	});
}

function generateID(){
	//Makes an idea using 8 digits/letters
	
	// $¢ Maybe a better way to do this
	var validChars=[];
	for(i=48;i<97+26;i++){
		if(i<58||i>=97||(i>=65&&i<65+26)){
			validChars.push(i);
		}
	}
	
	var id="";
	for(i=0;i<8;i++){
		id+=String.fromCharCode(validChars[Math.floor(Math.random()*validChars.length)]);
	}
	
	return id;
}

jQuery(document).ready(function(){
	var loc = document.cookie.indexOf("userID=") + 7;
	var userID=document.cookie.substring(loc, loc+7);
	jQuery.post('php/getUser.php',{'jsCall':'$¢'},function(data){
		jQuery.post('php/updateLobby.php',{'id':userID,'join':'true','name':data}, function(){console.log(data+" joined the lobby")});
	});
	jQuery.get('php/authenticateBeeKeeper.php',function(data){
		if(data!='false'){
			$("#adminControls").show();
			document.getElementById("adminControls").innerHTML=data;
		}
	});
});

$( window ).on('unload',function() {
	var loc = document.cookie.indexOf("userID=") + 7;
	var userID=document.cookie.substring(loc, loc+7);
	jQuery.post('php/updateLobby.php',{'id':userID,'join':'false'}, function(){console.log("callback")});
});
