var source = new EventSource('php/lobbySSE.php?user='+document.cookie.substring(document.cookie.indexOf("userID=") + 7,document.cookie.indexOf("userID=") + 14));
source.onmessage = function(e) {
	document.getElementById("players").innerHTML=e.data;
 };
 
var notificationSource = new EventSource('php/notificationSSE.php?userID='+document.cookie.substring(document.cookie.indexOf("userID=") + 7,document.cookie.indexOf("userID=") + 14));
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
						 {'fileName':gamesInTournament[k].id,'player1ID':gamesInTournament[k].p1,'player2ID':gamesInTournament[k].p2,'pointer':pointerString},
							function(data){
									console.log(data);
								});
	}
	return(gamesInTournament);
}

var createdBreak = false;
function generatePrivateGame(){
	var usernameIn=document.getElementById("requestedUsername").value;
	$.post("php/checkForUser.php",
		   {username : usernameIn},
		   function(data){
			   if(data == "false"){
					$("#alert").show();
					if(createdBreak == false){
						$("#alert").after("<br>");
						createdBreak = true;
					}
					$("#alert").html("This user does not exist.");
			   }
			   else if(data == "true"){
					//$¢ Change the pointer to something else that doesn't trigger a win upgrade
					console.log(usernameIn);
					jQuery.post('php/getARoom.php',
								{'fileName':generateID(),
								'player1ID':document.cookie.substring(document.cookie.indexOf("userID=") + 7,document.cookie.indexOf("userID=") + 14),
								'player2ID':"(SELECT userID FROM users WHERE username='"+usernameIn+"')",
								'pointer':"WINNER"},
								function(data){
									$("#alert").show();
									if(createdBreak == false){
										$("#alert").after("<br>");
										createdBreak = true;
									}
									$("#alert").html(data);
								}
					);
			   }
		   }
	);
}

function cleanString(dat){
	//$¢Prevents SQL Injection
	return dat;
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