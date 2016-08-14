var isMyTurn=true;
var gameDataSent=true;
var gameData="";

var dataSource = new EventSource('../php/gameDataSSE.php?gameID='+getRoomID());
dataSource.onmessage = function(e) {
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
 };

 function sendData(dat){
	 if(isMyTurn){
		jQuery.post("../php/setData.php",{'gData':dat,'gameID':getRoomID()},function(){
			gameData=dat;
			//Redraw & Logic
			gameDataSent=true;
			isMyTurn=false;
		});
	 }
 }
 
 jQuery(document).ready(function(){
	 window.setInterval(function () {
		 if(isMyTurn){
			 if(getCookie("userID") == playerIDs[0]){
				 $("#p1").addClass("icon-right-dir");
				 $("#p2").removeClass("icon-right-dir");
			 }
			 else if(getCookie("userID") == playerIDs[1]){
				 $("#p2").addClass("icon-right-dir");
				 $("#p1").removeClass("icon-right-dir");
			 }
		 }
		 else{
			 if(getCookie("userID") == playerIDs[0]){
				 $("#p2").addClass("icon-right-dir");
				 $("#p1").removeClass("icon-right-dir");
			 }
			 else if(getCookie("userID") == playerIDs[1]){
				 $("#p1").addClass("icon-right-dir");
				 $("#p2").removeClass("icon-right-dir");
			 }
		 }
        document.getElementById("turn").innerHTML="Square: "+board.onPlay;
    }, 1000	); 
});