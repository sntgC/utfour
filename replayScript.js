var playerIDs;

function getPlayerIDS(){
	var players=new Array();
    console.log($("#gameID").html());
    try{
		$.ajax({
			type: "GET",
			url: "php/getMatchPlayers.php",
			data: {gameID : $("#gameID").html()},
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

function loadPlayers(){
	$.post("php/getUser.php",{ twoPlayers : JSON.stringify(playerIDs) },function(data){
		var array = JSON.parse(data);
		var p1 = array[0];
		var p2 = array[1];
		$("#p1").html(p1);
		$("#p2").html(p2);
	});
}

$(document).ready(function(){
    if($("#gameID").html() != ""){
        getPlayerIDS();
    }
});

function finishLoading(){
    loadPlayers();
    setReplayColors();
}