
<?php
    session_start();

    //live server
    $conn = new mysqli('remotemysql.com','z3UPYAictr','5zZxKj7wNZ','z3UPYAictr') or die("Unable To Connect");

    //test server
    // $conn = new mysqli('localhost','root','', 'derma_tictactoe') or die("Unable To Connect");

    //Check connection
    if($conn->connect_error){
        die("Connection failed: ".$conn->connect_error);
    }

    if(isset($_POST['save'])){
        $playername = $_POST['playername'];
        $email = $_POST['email'];
        $playerpoint = $_GET['score_player'];
        $aipoint = $_GET['score_computer'];
        $drawpoint = $_GET['score_ties'];
        $date = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur'));
        $created_at = $date->format('Y-m-d H:i:s');
        $ip_address = getHostByName(getHostName());

        //return whole data
        $selectwholesql = "SELECT * FROM dermagame_dev";
        //return email data only
        $selectemailsql = "SELECT * FROM dermagame_dev WHERE email='$email'";
        //return ip address
        $selectipaddresssql = "SELECT * FROM dermagame_dev WHERE ip_address='$ip_address'";

        //initialize the db query set
        $emailresult=mysqli_query($conn,$selectemailsql);
        $ipresult=mysqli_query($conn,$selectipaddresssql);
        $wholeresult=mysqli_query($conn,$selectwholesql);

        //reward tier condition
        ($playerpoint == 1) ? $rewarditem = "Exuviance-100ml" : ($playerpoint == 3) ? $rewarditem = "Heliocare-100ml" : $rewarditem =  "Sorry No Reward Given";


        if($emailresult || $ipresult){
            //return number rows in email result set
            $emailrowcount = mysqli_num_rows($emailresult);
            $iprowcount = mysqli_num_rows($ipresult);

            //Email Duplicate Detected
            if( ($emailrowcount > 0) || ($iprowcount > 0)){
                $_SESSION['duplicate_msg'] = "You Already Try Once, Thank You For Participating Our Contest.";
                
                header("location: tic_tac_toe.php");
            } else {
                if($wholeresult) {
                    //detect player capacity rows
                    $countwholerow = mysqli_num_rows($wholeresult);
                    if($countwholerow >= 10){
                        $_SESSION['stop_insert'] = "Game Was Closed, Thanks You For Participating Our Contest.";
                        
                        header("location: tic_tac_toe.php");
                    } else {
                        // insert data to db
                        $insertsql = "INSERT INTO dermagame_dev
                        (player_name, email, player_point, 
                        ai_point, draw_point, reward_item, 
                        created_at, ip_address) 
                        VALUES ('$playername','$email',$playerpoint,
                        $aipoint,$drawpoint,'$rewarditem','$created_at','$ip_address')";

                        if ($conn->query($insertsql) === TRUE){
                            $_SESSION['success_message'] = 'Thank You For Support Our Contest!';
                            $_SESSION['score_player'] = $playerpoint;
                            $_SESSION['score_computer'] = $aipoint;
                            $_SESSION['reward_item'] = $rewarditem;
                            header("location: tic_tac_toe.php");
                        } else {
                            echo "Error: " . $insertsql . "<br>" . $conn->error;
                        }
                    }
                } else {
                    $_SESSION['error_message'] = 'Please Try Again !';
                    header("location: tic_tac_toe.php");
                }
            }
        }
        $conn->close();
    }
?>


