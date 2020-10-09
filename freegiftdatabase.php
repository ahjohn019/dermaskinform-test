<?php
    session_start();

    //live server
    $conn = new mysqli('remotemysql.com','z3UPYAictr','5zZxKj7wNZ','z3UPYAictr') or die("Unable To Connect");

    //test server
    // $conn = new mysqli('localhost','root','', 'freegift_form') or die("Unable To Connect");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    if(isset($_POST['save']) ){
        $fullname = $_POST['full_name'];
        $gender = $_POST['gender'];
        $dateofbirth = $_POST['dateofbirth'];
        $phonenumber = $_POST['phonenumber'];
        $email = $_POST['email'];

        //Additional Details
        $address_main = $_POST['address_main'];
        $states = $_POST['states'];
        $postcode = $_POST['postcode'];
        $inst_acc_name = $_POST['inst_acc_name'];
        $city = $_POST['city'];
        
        //select data from db
        $selectsql = "SELECT * FROM dermaform_dev WHERE email='$email'";
        
        if($result=mysqli_query($conn,$selectsql)){
            //Return number rows in result set
            $rowcount = mysqli_num_rows($result);

            //Check Duplication For Email, If Detected Dont Save (Throw Message Ask User Retry Again) Else Save It.
            if($rowcount > 0){
                $_SESSION['email_duplicate'] = "Cannot Input Same Email With Previous One, Please Retry Again.";
                header("location: freegift_form.php");
            } else {
                //limit database in live server db
                $selectwholesql = "SELECT * FROM dermaform_dev";

                if($wholeresult=mysqli_query($conn,$selectwholesql)){
                    $wholerowcount = mysqli_num_rows($wholeresult);
                    if($wholerowcount >= 1534){ //1336
                        $_SESSION['stop_insert'] = 'Reached Maximum 500 Already, Thanks For Joining Us.';
                        header("location: freegift_form.php");
                    } else {
                        $date = new DateTime("now", new DateTimeZone('Asia/Singapore') );
                        $created_at = $date->format('Y-m-d H:i:s');

                        $sql = "INSERT INTO 
                        dermaform_dev (full_name, gender, 
                        dateofbirth, phonenumber, 
                        email, states, 
                        postcode, inst_acc_name, address_main, city, created_at)
                        VALUES ('$fullname','$gender',
                        '$dateofbirth','$phonenumber',
                        '$email','$states',
                        '$postcode','$inst_acc_name','$address_main','$city','$created_at')";
                      
                        if ($conn->query($sql) === TRUE) {
                            $_SESSION['success'] = 'Created Successfully !';
                            header("location: freegift_form.php");
                            
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }                       
                    }
                } else {
                    $_SESSION['error'] = 'Please Try Again !';
                    header("location: freegift_form.php");
                }
            }
        }
    }
    $conn->close();
?>