var isMyTurn=true;
var gameDataSent=true;
var gameData="";

var dataSource = new EventSource('../php/gameDataSSE.php?gameID='+getRoomID());
dataSource.onmessage = function(e) {
	if(gameData===""){
		gameData=e.data;
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
		gameDataSent=false;
		isMyTurn=true;
	}
 };

 function sendData(){
	 if(isMyTurn){
		jQuery.post("../php/setData.php",{'gData':document.getElementById("gData").value,'gameID':getRoomID()},function(){
			gameData=document.getElementById("gData").value;
			gameDataSent=true;
			isMyTurn=false;
		});
	 }
 }
 
 jQuery(document).ready(function(){
	 window.setInterval(function () {
        document.getElementById("p2").innerHTML="My Turn?:"+isMyTurn+" IRID:"+inRoundID+" Sent?:"+gameDataSent;
    }, 1000	); // repeat forever, polling every 3 seconds
});