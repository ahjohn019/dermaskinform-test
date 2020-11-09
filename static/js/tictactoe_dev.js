//==================================
// EVENT BINDINGS
//==================================

// When user clicks outside of modal box, close it.
window.onclick = function(evt){
    var modaltarget = document.getElementsByClassName("modal")[2];
    if(evt.target === modaltarget){
        $('#optionsDlg').hide();
    }
}

//Select Esc Key To exit the modal dialog.
document.onkeydown = function (evt) {
    evt = evt || window.event;
    var isEscape = false;
    if ("key" in evt){
        isEscape = (evt.key === "Escape" || evt.key === "Esc");
    } else {
        isEscape = (evt.keyCode === 27);
    }
    if (isEscape) {
        $('#optionsDlg').hide();
    }
}

//==================================
// AI HELPER FUNCTIONS
//==================================
function sumArray(array){
    var sum = 0;
        i = 0;
    for(i=0;i<array.length;i++){
        sum += array[i];
    }
    return sum;
}

function isInArray(element, array){
    if(array.indexOf(element) > -1) {
        return true;
    }
    return false;
}

function shuffleArray(array) {
    var counter = array.length,
        temp,
        index;
    while (counter > 0){
        index = Math.floor(Math.random() * counter);
        counter--;
        temp = array[counter];
        array[counter] = array[index];
        array[index] = temp;
    }
    return array;
}

function intRandom(min,max){
    var rand = min + Math.random() * (max + 1 - min);
    return Math.floor(rand);
}


//==================================
// GLOBAL VARIABLES
//==================================
var moves = 0,
    winner = 0,
    x = 1,
    o = 3,
    player = x,
    computer = o,
    whoseTurn = x,
    gameOver = false,
    score = {
        ties: 0,
        player: 0,
        computer: 0
    },
    round = 1,
    //replace with product images (later)
    // xText = "<span class=\"x\">&times;</span>",
    image_x = "static/assets/heliocare_thumbnails.png",
    xText = '<img src="'+ image_x +'" class=\"image_x\"></img>' ,
    oText = "<span class=\"o\">o</span>",
    playerText = xText,
    computerText = oText,
    difficulty = 1,
    myGrid = null;

//==================================
// GRID OBJECT
//==================================

// Grid constructor
//=================
function Grid() {
    this.cells = new Array(9);
}

//Get free cells in an array
// Returns an array of indices in the original Grid.cells array, not the values
// of the array elements.
Grid.prototype.getFreeCellIndices = function (){
    var i = 0;
        resultArray = [];
    for (i = 0; i<this.cells.length; i++){
        if(this.cells[i] === 0){
            resultArray.push(i);
        }
    }
    // console.log("resultArray: " + resultArray.toString());
    return resultArray;
};

// Get a row (accepts 0,1,2 as argument)
// Returns the values of the elements.
Grid.prototype.getRowValues = function (index) {
    if (index !== 0 && index !== 1 && index !== 2) {
        console.error("Wrong arg for getRowValues!");
        return undefined;
    }
    var i = index * 3;
    return this.cells.slice(i, i + 3);
};

// Get a row (accepts 0, 1, or 2 as argument).
// Returns an array with the indices, not their values.
Grid.prototype.getRowIndices = function (index) {
    if (index !== 0 && index !== 1 && index !== 2) {
        console.error("Wrong arg for getRowIndices!");
        return undefined;
    }
    var row = [];
    index = index * 3;
    row.push(index);
    row.push(index + 1);
    row.push(index + 2);
    return row;
};

// get a column (values)
Grid.prototype.getColumnValues = function (index) {
    if (index !== 0 && index !== 1 && index !== 2) {
        console.error("Wrong arg for getColumnValues!");
        return undefined;
    }
    var i, column = [];
    for (i = index; i < this.cells.length; i += 3) {
        column.push(this.cells[i]);
    }
    return column;
};

// get a column (indices)
Grid.prototype.getColumnIndices = function (index) {
    if (index !== 0 && index !== 1 && index !== 2) {
        console.error("Wrong arg for getColumnIndices!");
        return undefined;
    }
    var i, column = [];
    for (i = index; i < this.cells.length; i += 3) {
        column.push(i);
    }
    return column;
};

// get diagonal cells
// arg 0: from top-left
// arg 1: from top-right
Grid.prototype.getDiagValues = function (arg) {
    var cells = [];
    if (arg !== 1 && arg !== 0) {
        console.error("Wrong arg for getDiagValues!");
        return undefined;
    } else if (arg === 0) {
        cells.push(this.cells[0]);
        cells.push(this.cells[4]);
        cells.push(this.cells[8]);
    } else {
        cells.push(this.cells[2]);
        cells.push(this.cells[4]);
        cells.push(this.cells[6]);
    }
    return cells;
};

// get diagonal cells
// arg 0: from top-left
// arg 1: from top-right
Grid.prototype.getDiagIndices = function (arg) {
    if (arg !== 1 && arg !== 0) {
        console.error("Wrong arg for getDiagIndices!");
        return undefined;
    } else if (arg === 0) {
        return [0, 4, 8];
    } else {
        return [2, 4, 6];
    }
};

// Get first index with two in a row (accepts computer or player as argument)
Grid.prototype.getFirstWithTwoInARow = function (agent) {
    if (agent !== computer && agent !== player) {
        console.error("Function getFirstWithTwoInARow accepts only player or computer as argument.");
        return undefined;
    }
    var sum = agent * 2,
        freeCells = shuffleArray(this.getFreeCellIndices());
        
    for (var i = 0; i < freeCells.length; i++) {
        for (var j = 0; j < 3; j++) {
            var rowV = this.getRowValues(j);
            var rowI = this.getRowIndices(j);
            var colV = this.getColumnValues(j);
            var colI = this.getColumnIndices(j);
            if (sumArray(rowV) == sum && isInArray(freeCells[i], rowI)) {
                return freeCells[i];
            } else if (sumArray(colV) == sum && isInArray(freeCells[i], colI)) {
                return freeCells[i];
            }
        }
        for (j = 0; j < 2; j++) {
            var diagV = this.getDiagValues(j);
            var diagI = this.getDiagIndices(j);
            if (sumArray(diagV) == sum && isInArray(freeCells[i], diagI)) {
                return freeCells[i];
            }
        }
    }
    return false;
};

Grid.prototype.reset = function () {
    for (var i = 0; i < this.cells.length; i++) {
        this.cells[i] = 0;
    }
    return true;
};


//====================
// Main Functions
//====================

//executed while page loads
function initialize(){
    myGrid = new Grid();
    moves = 0;
    gameOver = 0;
    whoseTurn = player;
    for (var i=0; i<=myGrid.cells.length-1; i++){
        myGrid.cells[i] = 0;
    }
    setTimeout(showOptions, 500);
}

function assignRoles() {
    var askUser = askUser("Do you want to go first?");
    document.getElementById("yesBtn").addEventListener("click", makePlayerX);
}

function makePlayerX(){
    player = x;
    computer = o;
    whoseTurn = player;
    playerText = xText;
    computerText = oText;
    document.getElementById("userFeedback").style.display = "none";
    document.getElementById("yesBtn").removeEventListener("click", makePlayerX);
    document.getElementById("noBtn").removeEventListener("click", makePlayerO);
}

function makePlayerO() {
    player = o;
    computer = x;
    whoseTurn = computer;
    playerText = oText;
    computerText = xText;
    setTimeout(makeComputerMove, 400);
    document.getElementById("userFeedback").style.display = "none";
    document.getElementById("yesBtn").removeEventListener("click", makePlayerX);
    document.getElementById("noBtn").removeEventListener("click", makePlayerO);
}

//executed when player clicks one of table cells
function cellClicked(id){
    var idName = id.toString();
    var cell = parseInt(idName[idName.length-1]);

    if (myGrid.cells[cell] > 0 || whoseTurn !== player || gameOver){
        //cell is occupied or else wrong
        return false;
    }
    moves += 1;

    //get the html value from "x"
    document.getElementById(id).innerHTML = playerText;

    // randomize orientation (for looks only)
    // var rand = Math.random();
    // if (rand < 0.3){
    //     document.getElementById(id).style.transform = "rotate(180deg)";
    // } else if (rand > 0.6) {
    //     document.getElementById(id).style.transform = "rotate(90deg)";
    // }

    document.getElementById(id).style.cursor = "default";
    myGrid.cells[cell] = player;

    //Test if got winner:
    if(moves >= 5){
        winner = checkWin();
    }

    if(winner === 0){
        whoseTurn = computer;
        makeComputerMove();
    }
    return true;

}


//button after trigger
function getOptions(){
    var diffs = document.getElementsByName('difficulty');
    for (var i =0; i<diffs.length;i++){
        if (diffs[i].checked) {
            difficulty = parseInt(diffs[i].value);
            break;
        }
    }
    if (document.getElementById('rx').checked === true){
        player = x;
        computer = o;
        whoseTurn = player;
        playerText = xText;
        computerText = oText;
    }
    else {
        player = o;
        computer = x;
        whoseTurn = computer;
        playerText = oText;
        computerText = xText;
        setTimeout(makeComputerMove, 400);
    }
    document.getElementById("optionsDlg").style.display = 'none';
    document.getElementById("round_number").innerHTML = 1;
}

//make core AI logic move
function makeComputerMove(){
    if (gameOver) {
        return false;
    }
    var cell = -1;
        myArr = [],
        corners = [0,2,6,8];

    if (moves >= 3){
        cell = myGrid.getFirstWithTwoInARow(computer);
        if (cell === false){
            cell = myGrid.getFirstWithTwoInARow(player);
        }
        if (cell === false){
            if(myGrid.cells[4] === 0 && difficulty == 1) {
                
                cell = 4;
            } else {
                myArr = myGrid.getFreeCellIndices();
                cell = myArr[intRandom(0, myArr.length - 1)];
            }
        }
        // Avoid a catch-22 situation:
        if (moves == 3 && myGrid.cells[4] == computer && player == x && difficulty == 1) {
            
            if (myGrid.cells[7] == player && (myGrid.cells[0] == player || myGrid.cells[2] == player)) {
                myArr = [6,8];
                cell = myArr[intRandom(0,1)];
            }
            else if (myGrid.cells[5] == player && (myGrid.cells[0] == player || myGrid.cells[6] == player)) {
                myArr = [2,8];
                cell = myArr[intRandom(0,1)];
            }
            else if (myGrid.cells[3] == player && (myGrid.cells[2] == player || myGrid.cells[8] == player)) {
                myArr = [0,6];
                cell = myArr[intRandom(0,1)];
            }
            else if (myGrid.cells[1] == player && (myGrid.cells[6] == player || myGrid.cells[8] == player)) {
                myArr = [0,2];
                cell = myArr[intRandom(0,1)];
            }
        }
        else if (moves == 3 && myGrid.cells[4] == player && player == x && difficulty == 1) {
            
            if (myGrid.cells[2] == player && myGrid.cells[6] == computer) {
                cell = 8;
            }
            else if (myGrid.cells[0] == player && myGrid.cells[8] == computer) {
                cell = 6;
            }
            else if (myGrid.cells[8] == player && myGrid.cells[0] == computer) {
                cell = 2;
            }
            else if (myGrid.cells[6] == player && myGrid.cells[2] == computer) {
                cell = 0;
            }
        }

    } else if (moves === 1 && myGrid.cells[4] == player && difficulty == 1) {
        
        // if player is X and played center, play one of the corners
        cell = corners[intRandom(0,3)];
    } else if (moves === 2 && myGrid.cells[4] == player && computer == x && difficulty == 1) {
        
        // if player is O and played center, take two opposite corners
        if (myGrid.cells[0] == computer) {
            cell = 8;
        }
        else if (myGrid.cells[2] == computer) {
            cell = 6;
        }
        else if (myGrid.cells[6] == computer) {
            cell = 2;
        }
        else if (myGrid.cells[8] == computer) {
            cell = 0;
        }
    } else if(moves === 0 && intRandom(1,10) < 8){
        cell = corners[intRandom(0,3)];
    } else {
        myArr = myGrid.getFreeCellIndices();
        cell = myArr[intRandom(0, myArr.length - 1)];
    }
    
    var id = "cell" + cell.toString();
    document.getElementById(id).innerHTML = computerText;
    document.getElementById(id).style.cursor = "default";


    myGrid.cells[cell] = computer;
    moves += 1;
    if(moves >= 5) {
        winner = checkWin();
    }
    if (winner === 0 && !gameOver) {
        whoseTurn = player;
    } 
}

//check if the game finished and determine winner
function checkWin(){
    winner = 0;

    // ROWS
    for(var i=0; i<=2; i++){
        var row = myGrid.getRowValues(i);

        //if the row is in winning conditions, match with other row with same value
        if(row[0] > 0 && row[0] == row[1] && row[0] == row[2]){
            if (row[0] == computer) {
                //update the moves increment (AI)
                score.computer++;
                winner = computer;
                console.log("AI WONS");
            } else {
                //update the moves increment (PLAYER)
                score.player++;
                winner = player;
                console.log("PLAYER WINS");
            }
            var tmpAr = myGrid.getRowIndices(i);
            //Give the winning row a different bg-color
            for (var j=0; j < tmpAr.length; j++) {
                var str = "cell" + tmpAr[j];
                document.getElementById(str).classList.add("win-color");
            }
            //Set Timeout
            setTimeout(endGame, 1000, winner);
            return winner;
        }
    }

    // COLUMNS
    for (i = 0; i <= 2; i++) {
        var col = myGrid.getColumnValues(i);
        if(col[0] > 0 && col[0] == col[1] && col[0] == col[2]) {
            if (col[0] == computer){
                score.computer++;
                winner = computer;
            } else {
                score.player++;
                winner = player;
            }
            //Give the winning col a different bg-color
            var tmpAr = myGrid.getColumnIndices(i);
            for(var j = 0; j < tmpAr.length; j++){
                var str = "cell" + tmpAr[j];
                document.getElementById(str).classList.add("win-color");
            }
            //Set Timeout
            setTimeout(endGame, 1000, winner);
            return winner;
        }
    }

    // DIAGONALS
    for (i = 0; i<= 1; i++){
        var diagonal = myGrid.getDiagValues(i);
        if(diagonal[0] > 0 && diagonal[0] == diagonal[1] && diagonal[0] == diagonal[2]){
            if(diagonal[0] == computer){
                score.computer++;
                winner = computer;
            } else {
                score.player++;
                winner = player;
            }
            //Give the winning diagonal a different bg-color
            var tmpAr = myGrid.getDiagIndices(i);
            for(var j = 0; j < tmpAr.length; j++){
                var str = "cell" + tmpAr[j];
                document.getElementById(str).classList.add("win-color");
            }
            //Set Timeout
            setTimeout(endGame, 1000, winner);
            return winner;
        }
    }

    //Tie Game If The Board Is Full
    var myArr = myGrid.getFreeCellIndices();
    if (myArr.length === 0){
        winner = 10;
        score.ties++;
        endGame(winner);
        return winner;
    }
    return winner;
}

function restartGame(ask){
    if (moves > 0){
        var response = confirm("Are you sure you want to start over?");
        if (response === false) {
            return;
        }
    }
    gameOver = false;
    moves = 0;
    winner = 0;
    whoseTurn = x;
    myGrid.reset();

    for(var i = 0; i<=8; i++){
        var id = "cell" + i.toString();
        document.getElementById(id).innerHTML = "";
        document.getElementById(id).style.cursor = "pointer";
        document.getElementById(id).classList.remove("win-color");
    }
    if (ask === true) {
        // setTimeout(assignRoles, 200);
        setTimeout(showOptions, 200);
    } else if (whoseTurn == computer) {
        setTimeout(makeComputerMove, 800);
    }
}

function announceWinner(text) {
    document.getElementById("winText").innerHTML = text;
    document.getElementById("winAnnounce").style.display = "block";
    setTimeout(closeModal, 1500, "winAnnounce");
}

function askUser(text) {
    document.getElementById("questionText").innerHTML = text;
    document.getElementById("userFeedback").style.display = "block";
}

function showOptions(){
    document.getElementById("optionsDlg").style.display = "block";
}

function closeModal(id) {
    document.getElementById(id).style.display = "none";
}

function enteruserdetails(){
    document.getElementById("userDetails").style.display = "block";
}

function userrewardmessage(){
    $("#rewardWinMessage").show();
    console.log("urewardmsg");
}

function userstopmessage(){
    $("#rewardStopMessage").show();
    console.log("ustopmsg");
}

function userduplicatemessage(){
    $("#rewardDuplicateMessage").show();
    console.log("udupmsg");
}



function endGame(who){
    if (who == player) {
        announceWinner("Congratulations, you win!");
    } else if (who == computer) {
        announceWinner("Computer wins!");
    } else {
        announceWinner("It's a tie!");
    }
    gameOver = true;
    whoseTurn = 0;
    moves = 0;
    winner = 0;
    round ++;

    document.getElementById("computer_score").innerHTML = score.computer;
    document.getElementById("tie_score").innerHTML = score.ties;
    document.getElementById("player_score").innerHTML = score.player;
    document.getElementById("round_number").innerHTML = round;

    const gamescoredata = {
        score_computer : score.computer,
        score_ties : score.ties,
        score_player : score.player,
        round_number : round
    };

    const searchParams = new URLSearchParams(gamescoredata);

    for (var i = 0; i<=8; i++){
        var id = "cell" + i.toString();
        document.getElementById(id).style.cursor = "default";
    }

    if(round >= 6){
        enteruserdetails();
    }

    $("#tictactoe_form").attr("action","connect_tictactoedb.php?"+ searchParams.toString());

    setTimeout(restartGame, 800);
    
}

