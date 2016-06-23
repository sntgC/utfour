var playerIDs;
//A character denoting if this is player 1 ('1'), 2 ('2'), or possibly a spectator ('s') 
var inRoundID;

function getRoomID(){
	/*
	Returns the id of the room, which will probably just be the name of the file. Need to find a way to read the url
	*/
	return "testID1";
}

function AjaxCaller(){
    //Sets up the xml file
    var xmlhttp=false;
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch(E){
            xmlhttp = false;
        }
    }

    if(!xmlhttp && typeof XMLHttpRequest!='undefined'){
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function getPlayerIDS(){
	var players=new Array();
    try{
		/*
		The code in this try block uses synchronous requests which have
		'detrimental effects to the user experience.' However, the script
		needs to know the information from the server before it can do
		anything with it, which leaves an issue for a later time.
		*/
		var ajax=AjaxCaller();
		ajax.open("GET", 'php/getMatchPlayers.php?gameID='+getRoomID(), false);
		ajax.onreadystatechange=function(){
			if(ajax.readyState==4){
				if(ajax.status==200){
					var json=JSON.parse(ajax.responseText);
					players.push(json.player1ID);
					players.push(json.player2ID);
				}
			}
		}
		ajax.send(null);
    }catch(err){
      console.log(err);
	}
	return players;
}

function getPlayerID(){
	/*
	Returns the id of this player based on a cookie
	*/
	return "p1";
}

function setWinner(oneOrTwo){
	//If the function is called for testing purposes, the function looks at the state of a checkbox, otherwise this function is only called internally
	if(oneOrTwo==="test"){
		var p1=document.getElementById("p1Win").checked;
		if(p1){
			p1=playerIDs[0];
		}else{
			p1=playerIDs[1];
		}
		try{
			var ajax=AjaxCaller();
			ajax.open("GET", 'php/setWinner.php?gameID='+getRoomID()+'&winID='+p1, true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					if(ajax.status==200){
						
					}
				}
			}
			ajax.send(null);
		}catch(err){
		console.log(err);
		}
	}else{
		var winner=playerIDs[parseInt(oneOrTwo,10)-1];
	}
}

jQuery(document).ready(function(){
	playerIDs=getPlayerIDS();
	inRoundID = playerIDs[0]===getPlayerID()? '1':playerIDs[1]===getPlayerID()? '2':'s';
	console.log(inRoundID);
});