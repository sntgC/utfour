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

/*var g=new Game('abc','p1','p2','p1','dat');
var h=new Game('bcd','hp1','hp2','hp2','dat');
var i=new Game('cde','','','','');
var ghi=[g,h,i];
alert(updateBracket(ghi)[2].p1);*/