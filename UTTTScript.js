//var onPlay=9;
var c;
var ctx;
var colorA="#cc6699";
var colorB="#ffff99";

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
		console.log(data);
		this.isWon();
	}
	
	draw(){
		var xIndex=this.drawData[0];
        var yIndex=this.drawData[1];
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
			console.log(this.grid[2][0].toString());
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
		console.log("ENCODING>>>");
		var bulk=this.toString();
		var turn=inRoundID==='1'? '2':'1';
		this.noWinner=!this.gameWon();
		this.draw();
		return turn+this.onPlay+bulk;
	}
	
	decode(encodedString){
		console.log(encodedString);
		this.onPlay=parseInt(encodedString.charAt(1));
		encodedString=encodedString.substring(2);
		for(var decR=0;decR<3;decR++){
			for(var decC=0;decC<3;decC++){
				this.grid[decR][decC].loadGrid(encodedString.substring(0,9));
				encodedString=encodedString.substring(9);
			}
		}
		this.noWinner=!this.gameWon();
		this.draw();
		if(!this.noWinner){
			setWinner(board.winner);
		}
	}
	
	draw(){
		for(var dr=0;dr<3;dr++){
			for(var dc=0;dc<3;dc++)
				this.grid[dr][dc].draw();
		}
		console.log("DRAWN");
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

/*var miniBoard=new MiniGrid(1,2,3);
var board=new Grid(0,0,156);
console.log(board.toString());
console.log(board.setCell([0,0,0,0],"1"));
console.log(board.setCell([0,0,0,0],"1"));
console.log(board.toString());
/*console.log(miniBoard.setCell(0,0,1));
console.log(miniBoard.setCell(0,0,1));
console.log(miniBoard.setCell(1,1,1));
console.log(miniBoard.setCell(2,2,1));
console.log(miniBoard.setCell(0,2,2));
miniBoard.loadGrid("011021001");
console.log(miniBoard.toString());
console.log(miniBoard.isWon());*/

var board=new Grid(0,0,468);

jQuery(document).ready(function(){
	c=document.getElementById("display");
	ctx=c.getContext("2d");
	
	c.addEventListener('click', function(evt) {
		if(isMyTurn){
			var rect = c.getBoundingClientRect();
			var x=evt.clientX-rect.left;
			var y=evt.clientY-rect.top;
			//console.log(x+","+y);
			var coords=board.getCoords(x,y);
			if(coords!=null){
				if(board.noWinner&&board.setCell(coords,inRoundID)){
					console.log('2');
					sendData(board.encode());	
				}
			}
		}
      }, false);
	//board.decode("19222222222222222222222222222222222222222222222222222222222222222222222222222222222");
	board.draw();
});