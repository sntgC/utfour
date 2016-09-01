//var onPlay=9;
var c;
var ctx;
var miniC;
var miniCtx;
//colorA corresponds to player 1
var colorA="#cc6699";
//colorB corresponds to player 2
var colorB="#ffff99";
var p1ColorBox;
var p2ColorBox;

var safeDataSender = function () {

	function sendData(dat, pos) {
		if (isMyTurn && inRoundID != "s") {
			/*The bigSquare the player clicked on:
				0-A
				1-B
				2-C
				3-D
				4-E
				5-F
				6-G
				7-H
				8-I
			*/
			var conv=parseInt(pos[0]+""+pos[1],3);
    		var encodedMove=String.fromCharCode(65+conv);
			//Same concept as above 
			conv=parseInt(pos[2]+""+pos[3],3)
			encodedMove+=String.fromCharCode(65+conv);
			//Each move is sent to the server as 2 characters
			jQuery.post("../php/setData.php", {
				'gData' : dat,
				'gameID' : getRoomID(),
				'moveChar' : encodedMove
			}, function () {
				gameData = dat;
				//Redraw & Logic
				gameDataSent = true;
				isMyTurn = false;
			});
		}
	}
	return function(evt) {
			if(isMyTurn){
				var rect = c.getBoundingClientRect();
				var x=evt.clientX-rect.left;
				var y=evt.clientY-rect.top;
				//console.log(x+","+y);
				var coords=board.getCoords(x,y);
				if(coords!=null){
					if(board.noWinner&&board.setCell(coords,inRoundID)){
						sendData(board.encode(), coords);	
					}
				}
			}
		}
}

var replayFunctionality=function(){
	function resetBoard(board){
		board.grid=[];
		board.onPlay=9;
		var xIndex=0;
		var yIndex=0;
		board.noWinner = true;
		board.winner = '';
		for (var gr = 0; gr < 3; gr++) {
			var tempGrid = [];
			for (var gc = 0; gc < 3; gc++) {
				tempGrid.push(new MiniGrid(xIndex, yIndex, board.posData[2] / 39));
				xIndex += board.posData[2] / 39 * 14;
			}
			board.grid.push(tempGrid);
			xIndex = 0;
			yIndex += board.posData[2] / 39 * 14;
		}
	}
	return function(gameHistoryString, turn){
		//gameHistoryString - An unmodified gameHistory String from the database
		//turn - The turn at which you wish to render the board, begins counting at 1
		resetBoard(this);
		var p1Turn=true;
		for(i=0;i<turn;i++){
			var bigBoard=gameHistoryString.charCodeAt(i*2)-65;
			var lilBoard=gameHistoryString.charCodeAt(i*2+1)-65;
			console.log(bigBoard+" "+lilBoard);
            this.setCell([Math.floor(bigBoard/3),bigBoard%3,Math.floor(lilBoard/3),lilBoard%3], p1Turn? '1':'2');
			p1Turn=!p1Turn;
		}
		this.draw();
	}
}

class MiniGrid{
	
	constructor(x,y, scale){
		this.winner='0';
		this.cells=[];
		this.drawData=[x,y,scale];
		for(var mgi=0;mgi<3;mgi++){
			var row=['0','0','0'];
			this.cells.push(row);
		}
	}
	
	getWinner(){
		return this.winner;
	}
	
	isFull(){
        for(var mgr=0;mgr<3;mgr++)
            for(var mgc=0;mgc<3;mgc++)
                if(this.cells[mgr][mgc]==='0')
                    return false;
        return true;
    }
	
	isWon(){
        if(this.winner!='0')
            return true;
        for(var t=0;t<3;t++){
            if(this.cells[t][0]!='0'&&this.cells[t][0]===this.cells[t][1]&&this.cells[t][1]===this.cells[t][2]){
                this.winner=this.cells[t][0];
                return true;
            }
            if(this.cells[0][t]!='0'&&this.cells[0][t]===this.cells[1][t]&&this.cells[1][t]===this.cells[2][t]){
                this.winner=this.cells[0][t];
                return true;
            }
        }
        if(this.cells[0][0]!='0'&&this.cells[0][0]===this.cells[1][1]&&this.cells[1][1]===this.cells[2][2]){
            this. winner=this.cells[0][0];
            return true;
        }
        if(this.cells[0][2]!='0'&&this.cells[0][2]===this.cells[1][1]&&this.cells[1][1]===this.cells[2][0]){
            this.winner=this.cells[1][1];
            return true;
        }
        return false;
    }
	
	setCell(row,col,car){
		if(this.isWon()){
			return false;
		}
		if(this.cells[row][col]!='0'){
			return false;
		}
		this.cells[row][col]=car;
		return true;
	}
	
	loadGrid(data){
		for(var r=0;r<3;r++){
			for(var c=0;c<3;c++){
				this.cells[r][c]=data.charAt(r*3+c);
			}
		}
		//console.log(data);
		this.isWon();
	}
	
	draw(){
		var xIndex=this.drawData[0];
        var yIndex=this.drawData[1];
		if(this.winner!='0'){
			if(this.winner==='1'){
				ctx.fillStyle=colorA;
			}else{
				ctx.fillStyle=colorB;
			}
			ctx.fillRect(xIndex,yIndex, this.drawData[2]*11, this.drawData[2]*11);
		}else{
			for(var drawR=0;drawR<3;drawR++){
				for(var drawC=0;drawC<3;drawC++){
					switch(this.cells[drawR][drawC]){
						case '0':
							ctx.fillStyle="#dfdfdf";
							break;
						case '1':
							ctx.fillStyle=colorA;
							break;
						case '2':
							ctx.fillStyle=colorB;
					}
					ctx.fillRect(xIndex,yIndex,this.drawData[2]*3,this.drawData[2]*3);
					xIndex+=this.drawData[2]*4;
				}
				xIndex=this.drawData[0];
				yIndex+=this.drawData[2]*4;
			}
		}
	}
	
	toString(){
		var ret="";//+this.drawData[0]+","+this.drawData[1]+" "+this.drawData[2]+"\n";
		for(var mgr=0;mgr<3;mgr++){
			for(var mgc=0;mgc<3;mgc++)
				ret+=this.cells[mgr][mgc];
			//ret+="\n";
		}
		return ret;	
	}
}

class Grid {
	constructor(x,y, scale) {
		this.grid=[];
		this.onPlay=9;
		var xIndex=x;
		var yIndex=y;
		this.posData=[x,y,scale];
		this.noWinner=true;
		this.convertGameHistoryStringIntoThePositionOfTheBoardAtTheSpecifiedTurn=replayFunctionality();
		this.winner='';
		for(var gr=0;gr<3;gr++){
			var tempGrid=[];
			for(var gc=0;gc<3;gc++){
				tempGrid.push(new MiniGrid(xIndex,yIndex,scale/39));
                xIndex+=scale/39*14;
			}
			this.grid.push(tempGrid);
			xIndex=x;
            yIndex+=scale/39*14;
		}
	}
	
	gameWon(){
        for(var r=0;r<3;r++){
            if(this.grid[r][0].getWinner()!='0'&&this.grid[r][0].getWinner()===this.grid[r][1].getWinner()&&this.grid[r][1].getWinner()===this.grid[r][2].getWinner()){
				this.winner=this.grid[r][0].getWinner();
                return true;
			}
            if(this.grid[0][r].getWinner()!='0'&&this.grid[0][r].getWinner()===this.grid[1][r].getWinner()&&this.grid[1][r].getWinner()===this.grid[2][r].getWinner()){
				this.winner=this.grid[0][r].getWinner();
                return true;
			}
        }
        if(this.grid[0][0].getWinner()!='0'&&this.grid[0][0].getWinner()===this.grid[1][1].getWinner()&&this.grid[1][1].getWinner()===this.grid[2][2].getWinner()){
			this.winner=this.grid[0][0].getWinner();
            return true;
		}
        if(this.grid[0][2].getWinner()!='0'&&this.grid[0][2].getWinner()===this.grid[1][1].getWinner()&&this.grid[1][1].getWinner()===this.grid[2][0].getWinner()){
			this.winner=this.grid[0][2].getWinner();
            return true;
		}
        return false;
    }
	
	 setCell(coords,car){
        if(this.onPlay===9&&!this.grid[coords[0]][coords[1]].isWon()&&!this.grid[coords[0]][coords[1]].isFull()){
            if(this.grid[coords[0]][coords[1]].setCell(coords[2],coords[3],car)){
                this.grid[coords[0]][coords[1]].isWon();
                if(this.grid[coords[2]][coords[3]].isWon()||this.grid[coords[2]][coords[3]].isFull())
                    this.onPlay=9;
                else
                    this.onPlay=coords[2]*3+coords[3];
                return true;
            }else
                return false;
        }else if(coords[0]*3+coords[1]===this.onPlay&&!this.grid[coords[0]][coords[1]].isWon()&&!this.grid[coords[0]][coords[1]].isFull()){
            if(this.grid[coords[0]][coords[1]].setCell(coords[2],coords[3],car)){
                this.grid[coords[0]][coords[1]].isWon();
                if(this.grid[coords[2]][coords[3]].isWon()||this.grid[coords[2]][coords[3]].isFull())
                    this.onPlay=9;
                else
                    this.onPlay=coords[2]*3+coords[3];
                return true;
            }else
                return false;
        }
        return false;
    }
	
	getCoords(x,y){
		var coords=[];
		var xIndex=this.posData[0];
		var yIndex=this.posData[1];
		var scale=this.posData[2]/39;
        for(var or=0;or<3;or++){
            for(var oc=0;oc<3;oc++){
                for(var ir=0;ir<3;ir++){
                    for(var ic=0;ic<3;ic++){
                        if(x>=xIndex&&x<xIndex+scale*3&&y>=yIndex&&y<yIndex+scale*3)
                            return [or,oc,ir,ic];
						xIndex+=scale*4;
					}
					xIndex-=scale*12;
					yIndex+=scale*4;
				}
				xIndex+=scale*14;
				yIndex-=scale*12;
			}
			xIndex=0;
			yIndex+=scale*14;
		}
        return null;
	}
	
	encode(){
		var bulk=encodeBaseThree(this.toString(),'compress');
		var turn=inRoundID==='1'? '2':'1';
		this.noWinner=!this.gameWon();
		this.draw();
		return turn+this.onPlay+bulk;
	}
	
	decode(encodedString){
		this.onPlay=parseInt(encodedString.charAt(1));
		encodedString=encodeBaseThree(encodedString.substring(2),'expand');
		for(var decR=0;decR<3;decR++){
			for(var decC=0;decC<3;decC++){
				this.grid[decR][decC].loadGrid(encodedString.substring(0,9));
				encodedString=encodedString.substring(9);
			}
		}
		this.noWinner=!this.gameWon();
		this.draw();
		if(!this.noWinner && inRoundID != "s"){
			setWinner(board.winner);
		}
	}
	
	draw(){
		for(var dr=0;dr<3;dr++){
			for(var dc=0;dc<3;dc++)
				this.grid[dr][dc].draw();
		}
	}
	
	toString(){
		var ret="";
		for(var gr=0;gr<3;gr++){
			for(var gc=0;gc<3;gc++)
				ret+=this.grid[gr][gc];
			//ret+="\n";
		}
		return ret;	
	}
}

var board=new Grid(0,0,468);

function setColors(){
	var player1 = playerIDs[0];
	var player2 = playerIDs[1];
	$.ajax({
		type: 'POST',
		url: "../php/getGameColors.php",
		data: {"player1":player1,"player2":player2},
		success: function(data){
			var array = JSON.parse(data);
			var value1 = array[0];
			var value2 = array[1];
			if (value1 == value2){
				switch(value1){
					case "blue":
						colorA = "#5c5c8a";
						colorB = "#7676E3";
						break;
					case "green":
						colorA = "#41B56C";
						colorB = "#146E35";
						break;
					case "orange":
						colorA = "#DE9A57";
						colorB = "#FA9837";
						break;
					case "red":
						colorA = "#E8517C";
						colorB = "#AD1F48";
				}
			}
			else{
				switch(value1){
					case "blue":
						colorA = "#5c5c8a";
						break;
					case "green":
						colorA = "#41B56C";
						break;
					case "orange":
						colorA = "#DE9A57";
						break;
					case "red":
						colorA = "#E8517C";
				}
				switch(value2){
					case "blue":
						colorB = "#5c5c8a";
						break;
					case "green":
						colorB = "#41B56C";
						break;
					case "orange":
						colorB = "#DE9A57";
						break;
					case "red":
						colorB = "#E8517C";
				}
			}
			//Will call board.draw() once the AJAX call has completed rather than have the AJAX call be synchronous
			board.draw();
			//Sets the colors of the player boxes and names
			$("#p1").attr("style","color:"+colorA+";");
			$("#p2").attr("style","color:"+colorB+";");
			p1C = document.getElementById("p1Color");
			p2C = document.getElementById("p2Color");
			p1ColorBox = p1C.getContext("2d");
			p2ColorBox = p2C.getContext("2d");
			p1ColorBox.fillStyle = colorA;
			p2ColorBox.fillStyle = colorB;

			p1ColorBox.fillRect(0,0,15,15);
			p2ColorBox.fillRect(0,0,15,15);
		}
	});
}

function setReplayColors(){
	var player1 = playerIDs[0];
	var player2 = playerIDs[1];
	$.ajax({
		type: 'POST',
		url: "php/getGameColors.php",
		data: {"player1":player1,"player2":player2},
		success: function(data){
			var array = JSON.parse(data);
			var value1 = array[0];
			var value2 = array[1];
			if (value1 == value2){
				switch(value1){
					case "blue":
						colorA = "#5c5c8a";
						colorB = "#7676E3";
						break;
					case "green":
						colorA = "#41B56C";
						colorB = "#146E35";
						break;
					case "orange":
						colorA = "#DE9A57";
						colorB = "#FA9837";
						break;
					case "red":
						colorA = "#E8517C";
						colorB = "#AD1F48";
				}
			}
			else{
				switch(value1){
					case "blue":
						colorA = "#5c5c8a";
						break;
					case "green":
						colorA = "#41B56C";
						break;
					case "orange":
						colorA = "#DE9A57";
						break;
					case "red":
						colorA = "#E8517C";
				}
				switch(value2){
					case "blue":
						colorB = "#5c5c8a";
						break;
					case "green":
						colorB = "#41B56C";
						break;
					case "orange":
						colorB = "#DE9A57";
						break;
					case "red":
						colorB = "#E8517C";
				}
			}
			//Will call board.draw() once the AJAX call has completed rather than have the AJAX call be synchronous
			board.draw();
			//Sets the colors of the player boxes and names
			$("#p1").attr("style","color:"+colorA+";");
			$("#p2").attr("style","color:"+colorB+";");
			p1C = document.getElementById("p1Color");
			p2C = document.getElementById("p2Color");
			p1ColorBox = p1C.getContext("2d");
			p2ColorBox = p2C.getContext("2d");
			p1ColorBox.fillStyle = colorA;
			p2ColorBox.fillStyle = colorB;

			p1ColorBox.fillRect(0,0,15,15);
			p2ColorBox.fillRect(0,0,15,15);
		}
	});
}

function encodeBaseThree(fullString, direction){
    //Takes in a string and shortens it by dividing it into groups of three, and assigning a value to each of those groups
	var ret="";
	if(direction=='compress'){
		if(fullString.length%3!=0){
			fullString+=fullString.length%1? '00':'0';
		}
		for(s=0;s<fullString.length;s+=3){
			var conv=parseInt(fullString.substring(s,s+3),3);
			ret+=String.fromCharCode(64+conv);
		}
	}else if(direction='expand'){
		for(s=0;s<fullString.length;s++){
			var conv=fullString.charCodeAt(s)-64;
			var ternary=conv.toString(3);
            while(ternary.length<3){
                ternary='0'+ternary;
            }
            ret+=ternary;
		}
	}
	return ret;
}

$(document).ready(function(){
	c=document.getElementById("display");
	miniC=document.getElementById("turnDisplay");
	var width = c.offsetWidth;
	$("#gameArea").css("width",width);
	ctx=c.getContext("2d");
	miniCtx=miniC.getContext("2d");
});

function loadMouseListener (){
	if(inRoundID == "1" || inRoundID == "2"){
		c.addEventListener('click',safeDataSender() , false);
	}
}