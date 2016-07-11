var onPlay=9;

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
                if(this.cells[r][c]==='0')
                    return false;
        return true;
    }
	
	isWon(){
        if(this.winner!='0')
            return true;
        for(var r=0;r<3;r++){
            if(this.cells[r][0]!='0'&&this.cells[r][0]===this.cells[r][1]&&this.cells[r][1]===this.cells[r][2]){
                this.winner=this.cells[r][0];
                return true;
            }
            if(this.cells[0][r]!='0'&&this.cells[0][r]===this.cells[1][r]&&this.cells[1][r]===this.cells[2][r]){
                this.winner=this.cells[0][r];
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
		this.isWon();
	}
	
	toString(){
		var ret="";
		for(var mgr=0;mgr<3;mgr++){
			for(var mgc=0;mgc<3;mgc++)
				ret+=this.cells[mgr][mgc];
			ret+="\n";
		}
		return ret;	
	}
}

class Grid {
	constructor(x,y, scale) {
		this.grid=x;
	}
	toString(){
		return "";
	}
}


function encode(gameData){

}

function decode(gameData){

}

function draw(){
	
}

var miniBoard=new MiniGrid(1,2,3);
/*console.log(miniBoard.setCell(0,0,1));
console.log(miniBoard.setCell(0,0,1));
console.log(miniBoard.setCell(1,1,1));
console.log(miniBoard.setCell(2,2,1));
console.log(miniBoard.setCell(0,2,2));*/
miniBoard.loadGrid("011021001");
console.log(miniBoard.toString());
console.log(miniBoard.isWon());