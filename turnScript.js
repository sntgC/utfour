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


 function turnDraw(playLocation){
	 miniCtx.fillStyle="#ababab";
	var xIndex=0;
	var yIndex=0;
	for(var drawR=0;drawR<3;drawR++){
		for(var drawC=0;drawC<3;drawC++){
			if(playLocation===drawR*3+drawC||playLocation===9)
				miniCtx.fillStyle="#454545";
			else
				miniCtx.fillStyle="#ababab";
			miniCtx.fillRect(xIndex,yIndex,15,15);
			xIndex+=20;
		}
		xIndex=0;
		yIndex+=20;
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
		turnDraw(board.onPlay);
	});
}