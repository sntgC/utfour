class Game {
//	$¢ Maybe I should overload this method
	constructor(id, p1,p2, winner, data) {
		this.id = id;
		this.p1=p1;
		this.p2=p2;
		this.winner=winner;
		this.data=data;
	}
	hasP1(){
		return !(this.p1==''||this.p1=="null");
	}	
	hasP2(){
		return !(this.p2==''||this.p2=="null");;
	}
	hasWinner(){
		return !(this.winner==''||this.winner=="null");
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
	clone(){
		return new Game(this.id,this.p1,this.p2,this.winner,this.data);
	}
	toString(){
		return "ID: "+this.id+"\n\tP1: "+this.p1+"\n\tP2: "+this.p2+"\n\tWinner: "+this.winner+"\n\tData: "+this.data+"\n";
	}
}

function updateBracket(gameArray){
	var retArray=gameArray;
	var playersInTourney=(retArray.length+1)/2;
	for(i=0;i<retArray.length;i++){
		var p1=i%2===0;
		var childPos=playersInTourney+Math.floor(i/2);
		if(childPos>=retArray.length){
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

function convertJSONToGameArray(jsonArray){
	var arr=jsonArray;
	var names=['"id"','"player1ID"','"player2ID"','"winnerID"','"gameData"'];
	for(i=0;i<arr.length;i++){
		var str=arr[i];
		var spliterate=str.split(",");
		for(k=0;k<spliterate.length;k+=2){
			names[Math.floor(k/2)]=spliterate[k].substring(spliterate[k].indexOf(":")+1);
		}
		arr[i]=new Game(names[0],names[1],names[2],names[3],names[4]);
	}
	return arr;
}