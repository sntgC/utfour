var source = new EventSource('php/lobbySSE.php?user='+document.cookie.substring("userID=".length));
source.onmessage = function(e) {
	document.getElementById("players").innerHTML=e.data;
 };
 
var notificationSource = new EventSource('php/notificationSSE.php?userID='+document.cookie.substring("userID=".length));
notificationSource.onmessage = function(e) {
	document.getElementById("notification").innerHTML=e.data;
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
	for(k=0;k<length;k++){
		jQuery.post('php/getARoom.php',
						 {'fileName':gamesInTournament[k].id,'player1ID':gamesInTournament[k].p1,'player2ID':gamesInTournament[k].p2},
							function(data){
								document.getElementById("notification").innerHTML+=data;
								});
	}
	return(gamesInTournament);
}

function populate(players, games){
	/* $¢Room for improvement */
	var pIndex=0;
	for(g=0;g<games.length;g++){
		if(pIndex>players.length)
			break;
		if(!games[g].hasP1()){
			games[g].setP1(players[pIndex++]);
			g--;
		}else if(!games[g].hasP2()){
			games[g].setP2(players[pIndex++]);
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
	var userID=document.cookie.substring("userID=".length);
	jQuery.post('php/updateLobby.php',{'id':userID,'join':'true'}, function(){console.log(userID+" joined the lobby")});
});

$( window ).unload(function() {
	jQuery.post('php/updateLobby.php',{'id':document.cookie.substring("userID=".length),'join':'false'}, function(){console.log("callback")});
});