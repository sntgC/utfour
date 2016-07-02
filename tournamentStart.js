var source = new EventSource('php/lobbySSE.php');
source.onmessage = function(e) {
	document.getElementById("players").innerHTML=e.data;
	//console.log(e.data);
 };

function generateRooms(players){
	/*
	Does everything
	
	players-number of players
	*/
	// $¢ For now it just makes the room, to populate later
	var tourID=generateID();
	var gamesInTournament=[];
	var length=2*Math.pow(2,Math.ceil(Math.log(players)/Math.log(2)))-1;
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
	//Sends game objects to server $¢ Add a player field, register rooms, change this to $.post
	for(k=0;k<length;k++){
		var ajax=new XMLHttpRequest();
		ajax.open("GET", 'php/getARoom.php?fileName='+gamesInTournament[k].id, true);
		ajax.onreadystatechange=function(){
        //Request is finished and the response is ready
			if(ajax.readyState==4){
				if(ajax.status==200){
						
				}
			}
		}
		ajax.send(null);
	}
	console.log(gamesInTournament);
}

function beginTournament(){
	jQuery.post('php/registerTournament.php',{'tourID':'abcdefgh', 'tourData':'here come dat boi'}, function(){console.log("callback")});
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

function whoAmI(){
	return prompt("Input a number");
}

jQuery(document).ready(function(){
	/* $¢ Don't forget to add an unload() */
	jQuery.post('php/updateLobby.php',{'id':document.cookie.substring("userID=".length),'join':'true'}, function(){console.log("callback")});
});

$( window ).unload(function() {
	jQuery.post('php/updateLobby.php',{'id':document.cookie.substring("userID=".length),'join':'false'}, function(){console.log("callback")});
});