<?php 
    include 'connect_tictactoedb.php' ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dermaskinshop Tic-Tac-Toe</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="static/css/tictactoestyle.css">
  <script src="static/js/tictactoe_dev.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Rancho&display=swap" rel="stylesheet">
</head>

<!-- <body onload="userrewardmessage()"> -->

<!--if session message detected display success message else return to initialize method-->
<?php if(isset($_SESSION['success_message'])) { ?>
    <body onload="userrewardmessage()"> 
<?php } if(isset($_SESSION['duplicate_msg'])) { ?>
    <body onload="userduplicatemessage()"> 
<?php } if(isset($_SESSION['stop_insert'])) { ?>
    <body onload="userstopmessage()"> 
<?php } else {?>
    <body onload="initialize()">
<?php unset($_SESSION['success_message']);  unset($_SESSION['duplicate_msg']); unset($_SESSION['stop_insert']);} ?>

    <div class="border">
        <div class="box-sample">
            <img src="static/assets/dermaskinshop-Logo-Color.png" alt="" class="derma-logo">
        </div>
    </div>
    
    <div class="container">
        <img src="static/assets/tic-tac-toe_minigames.png" alt="" class="tic-tac-toe-logo">

        <?php   
                // $externalContent = file_get_contents('http://checkip.dyndns.com/');
                // preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
                // $externalIp = $m[1];
        ?>
        
        <h3>Your IP Address : <?php echo $_SERVER["HTTP_CLIENT_IP"];  ?></h3>
        <h2>Round <p id="round_number" class="round_number"></p></h2>
    
        <table id="table_tictactoe">
            <tr><td class="td_tictactoe"><div id="cell0" class="td_fixed" onclick="cellClicked(this.id)"></div></td>
            <td class="td_tictactoe"><div id="cell1" class="td_fixed" onclick="cellClicked(this.id)"></div></td>
            <td class="td_tictactoe"><div id="cell2" class="td_fixed" onclick="cellClicked(this.id)"></div></td></tr>
            <tr><td class="td_tictactoe"><div id="cell3" class="td_fixed" onclick="cellClicked(this.id)"></div></td>
            <td class="td_tictactoe"><div id="cell4" class="td_fixed" onclick="cellClicked(this.id)"></div></td>
            <td class="td_tictactoe"><div id="cell5" class="td_fixed" onclick="cellClicked(this.id)"></div></td></tr>
            <tr><td class="td_tictactoe"><div id="cell6" class="td_fixed" onclick="cellClicked(this.id)"></div></td>
            <td class="td_tictactoe"><div id="cell7" class="td_fixed" onclick="cellClicked(this.id)"></div></td>
            <td class="td_tictactoe"><div id="cell8" class="td_fixed" onclick="cellClicked(this.id)"></div></td></tr>
        </table>
        <table id="table_score">
            <tr><th class="th_list">Computer</th><th class="th_list" style="padding-right:10px;padding-left:10px">Draws</th><th class="th_list">Player</th></tr>
            <tr><td class="td_list" id="computer_score" name="computer_score">0</td><td class="td_list" style="padding-right:10px;padding-left:10px" id="tie_score" name="tie_score">0</td><td class="td_list" id="player_score" name="player_score">0</td></tr>
        </table>

        <!--Modal Dialog Part-->
        <!--Modal Win Announce Part-->
        <div id="winAnnounce" class="modal">
            <!--Modal Content-->
            <div class="modal-content">
                <span class="close" onclick="closeModal('winAnnounce')">&times;</span>
                <p id="winText"></p>
            </div>
        </div>

        <!--Modal Get Feedback Part-->
        <div id="userFeedback" class="modal">
            <!--Modal Content-->
            <div class="modal-content">
                <p id="questionText"></p>
                <p><button id="yesBtn">Yes</button></p>
                <p><button id="noBtn">No</button></p>
            </div>
        </div>

        <!--Options Dialog -->
        <div id="optionsDlg" class="modal">
            <div class="modal-content">
                <h2>Lets Start</h2>
                <h3>Difficulty:</h3>
                <label><input type="radio" name="difficulty" id="r0" value="0" checked>EASY</label>
                <label><input type="radio" name="difficulty" id="r1" value="1" >HARD</label>
                
                <h3>Play as:</h3>
                <label>
                    <input type="radio" name="player" id="rx" value="x" checked>X (go first)
                </label>
                <label><input type="radio" name="player" id="ro" value="o">O<br></label>
                <button id="submitBtn" type="submit" class="startButton" onclick="getOptions()">Play</button>
                <p>Remarks : Only Can Play One Time </p>
            </div>
        </div>

        <!--Enter User Details-->
        <form method="post" action="connect_tictactoedb.php" enctype="multipart/form-data" id="tictactoe_form">
            <div id="userDetails" class="modal">
                <div class="modal-content">
                    <h2>Forms</h2>
                    <label for="playername">Player Name : </label>
                    <input type="text" id="playername" name="playername"><br><br>
                    <label for="email">Email : </label>
                    <input type="text" id="email" name="email"><br><br>
                    <button id="submitUser" type="submit" class="userButton" name="save" >Submit</button>
                </div>
            </div>
        </form>
        
        <div id="rewardWinMessage" class="modal">
            <div class="modal-content">
                    <p>Reward Message</p>
                    <p>Computer: <?php echo $_SESSION['score_computer'] ?></p>
                    <p>Player: <?php echo $_SESSION['score_player'] ?></p>
                    <p>You Get: <?php echo $_SESSION['reward_item'] ?></p>
                    <?php if ($_SESSION['score_computer'] == 1){ ?>
                        <p>testscore1</p>
                    <?php } ?>

            </div>
        </div>

        <div id="rewardStopMessage" class="modal">
            <div class="modal-content">
                <p>Game Was Closed, Thanks You For Participating Our Contest.</p>
            </div>
        </div>

        <div id="rewardDuplicateMessage" class="modal">
            <div class="modal-content">
                <p>Messages</p>
                <p>You Already Try Once, Thank You For Participating Our Contest.</p>
            </div>
        </div>

    </div>
</body>
</html>