var playerIDs;
//A character denoting if this is player 1 ('1'), 2 ('2'), or possibly a spectator ('s') 
var inRoundID;

var redirectSource = new EventSource('../php/roomSSE.php?gameID='+getRoomID());
redirectSource.onmessage = function(e) {
	//console.log(e.data);
	if(e.data!=''){
		window.location.replace("../lobby");
	}
 };

function getRoomID(){
	/*
	Returns the id of the room, which will probably just be the name of the file. Need to find a way to read the url
	*/
	var url=window.location.href;
	return url.substring(url.lastIndexOf("/")+1);
}

function getPlayerIDS(){
	var players=new Array();
    try{
		$.ajax({
			type: "GET",
			url: "../php/getMatchPlayers.php",
			data: {gameID : getRoomID()},
			success: function(data){
				var json=JSON.parse(data);
				players.push(json.player1ID);
				players.push(json.player2ID);
				playerIDs = players;
				finishLoading();
			}
		});
    }catch(err){
      console.log(err);
	}
}

function getPlayerID(){
	return getCookie("userID");
}

function setWinner(oneOrTwo){
	var p1="";
	if(oneOrTwo==='1'){
		p1=playerIDs[0];
	}else{
		p1=playerIDs[1];
	}
	jQuery.post('../php/setWinner.php',{'gameID':getRoomID(),'winID':p1,'pointerRoom':getPointerData()[1],'player':getPointerData()[0]},function(data){console.log(data)});
}

function getPointerData(){
	var loc=document.getElementById("pointer").innerHTML;
	var pointer=loc.substring(loc.indexOf("id=")+"id=".length+1);
	pointer=pointer.substring(0,pointer.indexOf("\""));
	var retArray=[];
	if(pointer==="WINNER"){
		retArray=["NONE","NONE"];
		return retArray;
	}else if(pointer=="SOLOWINNER"){
		retArray=["NONE","SOLOWINNER"];
		return retArray;
	}
	retArray.push(pointer.substring(0,2));
	retArray.push(pointer.substring(6));
	return retArray;
}

function loadPlayers(){
	$.post("../php/getUser.php",{ twoPlayers : JSON.stringify(playerIDs) },function(data){
		var array = JSON.parse(data);
		var p1 = array[0];
		var p2 = array[1];
		$("#p1").html(p1);
		$("#p2").html(p2);
	});
}

jQuery(document).ready(function(){
	getPlayerIDS();
});

function finishLoading(){
	inRoundID = playerIDs[0]===getPlayerID()? '1':playerIDs[1]===getPlayerID()? '2':'s';
	//console.log(inRoundID);
	//console.log(playerIDs);
	//console.log(getPlayerID());
	//console.log(getRoomID());
	//console.log(getPointerData());
	loadPlayers();
	setColors();
	loadMouseListener();
}