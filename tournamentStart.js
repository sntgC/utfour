function generateRooms(players){
	/*
	Generates IDs
	Creates new tournament
	Sends requests to the server for new rooms
	*/
	
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