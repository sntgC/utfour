function getGameIDS(){
	var games=new Array();
    try{
		ajax=AjaxCaller();
		//Requests with the specified url
		ajax.open("GET", 'php/getTournamentGames.php', false);
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
	for(i=0;i<games.length;i++){
		updateTable(games[i]);
	}
}

function requestGameData(game){
	var ret="";
    try{
      ret =callPage('php/testPHP.php?gameID='+game,document.getElementById("testDisplay"));
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

function fixString(fix){
  var ret="";
  for(i=0;i<fix.length;i++){
    if(fix.charAt(i)==='}'&&i<fix.length-2){
      ret+="},"
    }else{
      ret+=fix.charAt(i);
    }
  }
  return ret;
}

function updateTable(jsonString){
	    try{
		    var json=jQuery.parseJSON(jsonString);
		    $("#table").bootstrapTable('append',json);
	    }catch(err){
		    document.getElementById("testDisplay").innerHTML=err;
	}
}

jQuery(document).ready(function(){
	//getGameIDS();
});
