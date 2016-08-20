var isMyTurn=true;
var gameDataSent=true;
var gameData="";
var whichPlayersTurn="";

var dataSource = new EventSource('../php/gameDataSSE.php?gameID='+getRoomID());
dataSource.onmessage = function(e) {
	whichPlayersTurn = e.data.charAt(0);
	updateTurn();
	if(inRoundID == "s"){
		board.decode(e.data);
		isMyTurn = false;
	}
	else {
		if(gameData===""){
			gameData=e.data;
			console.log(e.data.length);
			board.decode(gameData);
			var firstChar=e.data.charAt(0);
			if(firstChar===inRoundID){
				isMyTurn=true;
				gameDataSent=false;
			}else{
				isMyTurn=false;
				gameDataSent=true;
			}
		}
		if(gameDataSent&&e.data.charAt(0)===inRoundID){
			gameData=e.data;
			board.decode(gameData);
			gameDataSent=false;
			isMyTurn=true;
		}
	}
 };

 function sendData(dat){
	 if(isMyTurn && inRoundID != "s"){
		jQuery.post("../php/setData.php",{'gData':dat,'gameID':getRoomID()},function(){
			gameData=dat;
			//Redraw & Logic
			gameDataSent=true;
			isMyTurn=false;
		});
	 }
 }

function updateTurn(){
	$(document).ready(function(){
		if (whichPlayersTurn == "1"){
			$("#p1").addClass("icon-right-dir");
			$("#p2").removeClass("icon-right-dir");
		}
		else if (whichPlayersTurn == "2"){
			$("#p1").removeClass("icon-right-dir");
			$("#p2").addClass("icon-right-dir");
		}
		document.getElementById("turn").innerHTML="Square: "+board.onPlay;
	});
}