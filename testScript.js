
function requestGameData(game){
	//alert(game);
    try{
      callPage('/testPHP.php?gameID='+game,document.getElementById("testDisplay"));
    }catch(err){
      document.getElementById("testDisplay").innerHTML=err;
}
}

function getGameIDS(){
	//$("#table").bootstrapTable('removeAll',"");
    try{
		var ajax=AjaxCaller();
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
						requestGameData(idArray[i]);
						//alert(idArray[i]);
					}
				}
			}
		}
		ajax.send(null);
    }catch(err){
      document.getElementById("testDisplay").innerHTML=err;
}
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
	alert("running");
    var ajax=AjaxCaller();
    //Requests with the specified url
    ajax.open("GET", url, false);
    ajax.onreadystatechange=function(){
        //Request is finished and the response is ready
        if(ajax.readyState==4){
            if(ajax.status==200){
                //Gets the response from the server and then updates the table based on it
                    json="["+ajax.responseText+"]";
					alert(json);
                    //div.innerHTML=ajax.responseText;
				   updateTable(json);
            }
        }
    }
    ajax.send(null);
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
	getGameIDS();
});