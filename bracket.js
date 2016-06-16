class Game {
  constructor(id, p1,p2, winner, data) {
    this.id = id;
	this.p1=p1;
	this.p2=p2;
	this.winner=winner;
	this.data=data;
  }
  hasP1(){
	  return this.p1!='';
  }
  hasP2(){
	  return this.p2!='';
  }
  hasWinner(){
	  return this.winner!='';
  }
  setP1(p1){
	  this.p1=p1;
  }
  setP2(p2){
	  this.p2=p2;
  }
  getWinner(){
		return this.winner;
  }
}

function updateBracket(gameArray){
	var retArray=gameArray;
	var playersInTourney=(retArray.length+1)/2;
	for(i=0;i<retArray.length;i++){
		var p1=i%2===0;
		var childPos=playersInTourney+Math.floor(i/2);
		if(childPos>retArray.length){
			continue;
		}
		if(retArray[i].hasWinner()){
			if(p1&&!retArray[childPos].hasP1()){
				retArray[childPos].setP1(retArray[i].getWinner());
			}else if(!(p1||retArray[childPos].hasP2())){
				retArray[childPos].setP2(retArray[i].getWinner());
			}
		}
	}
	return retArray;
}

function getGameObjectArray(){
	var games=new Array();
    try{
		ajax=AjaxCaller();
		//Requests with the specified url
		ajax.open("GET", '/getTournamentGames.php', false);
		ajax.onreadystatechange=function(){
        //Request is finished and the response is ready
			if(ajax.readyState==4){
				if(ajax.status==200){
                //Gets the response from the server and then updates the table based on it
                    json=ajax.responseText;
					json=json.substring(json.indexOf("data")+7,json.length-2);
					idArray=json.split(" ");
					var len=idArray.length;
					
					for(i=0;i<len;i++){
						games.push(requestGameData(idArray[i]));
						//alert(idArray[i]);
					}
				}
			}
		}
		ajax.send(null);
    }catch(err){
      document.getElementById("testDisplay").innerHTML=err;
	}
	alert(games);
}

function requestGameData(game){
	var ret="";
    try{
      ret =callPage('/testPHP.php?gameID='+game,document.getElementById("testDisplay"));
    }catch(err){
      document.getElementById("testDisplay").innerHTML=err;
	}
	return ret;
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

function callPage(url, div){
    var ajax=AjaxCaller();
	var ret="";
    //Requests with the specified url
    ajax.open("GET", url, false);
    ajax.onreadystatechange=function(){
        //Request is finished and the response is ready
        if(ajax.readyState==4){
            if(ajax.status==200){
                //Gets the response from the server and then updates the table based on it
                    ret=ajax.responseText;
            }
        }
    }
    ajax.send(null);
	return ret;
}

/*var g=new Game('abc','p1','p2','p1','dat');
var h=new Game('bcd','hp1','hp2','hp2','dat');
var i=new Game('cde','','','','');
var ghi=[g,h,i];
alert(updateBracket(ghi)[2].p1);*/