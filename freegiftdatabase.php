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
        $firstname = $_POST['first_name'];
        $lastname = $_POST['last_name'];
        $gender = $_POST['gender'];
        $dateofbirth = $_POST['dateofbirth'];
        $phonenumber = $_POST['phonenumber'];
        $email = $_POST['email'];

        //Additional Details
        $address_line_one = $_POST['addr1'];
        $address_line_two = $_POST['addr2'];
        $states = $_POST['states'];
        $postcode = $_POST['postcode'];
        $inst_acc_name = $_POST['inst_acc_name'];
        
        //image part

        //select data from db
        $selectsql = "SELECT * FROM freegift_form WHERE email='$email'";
        
        if($result=mysqli_query($conn,$selectsql)){
            //Return number rows in result set
            $rowcount = mysqli_num_rows($result);

            //Check Duplication For Email, If Detected Dont Save (Throw Message Ask User Retry Again) Else Save It.
            if($rowcount > 0){
                $_SESSION['email_duplicate'] = "Cannot Input Same Email With Previous One, Please Retry Again.";
                header("location: freegift_form.php");
            } else {
                //limit database in live server db
                $selectwholesql = "SELECT * FROM freegift_form";

                // if($conn->query($sql) === TRUE){
                //     $_SESSION['success'] = 'Created Successfully !';
                //     header("location: freegift_form.php");
                // } else 
                if($wholeresult=mysqli_query($conn,$selectwholesql)){
                    $wholerowcount = mysqli_num_rows($wholeresult);
                    if($wholerowcount >= 750){ //750
                        $_SESSION['stop_insert'] = 'Full Redemptions, Thanks For Joining Us.';
                        header("location: freegift_form.php");
                    } else {
                        $sql = "INSERT INTO 
                        freegift_form (first_name, last_name, gender, 
                        dateofbirth, phonenumber, 
                        email, address_line_one, 
                        address_line_two, states, 
                        postcode, inst_acc_name)
                        VALUES ('$firstname','$lastname','$gender',
                        '$dateofbirth','$phonenumber',
                        '$email','$address_line_one',
                        '$address_line_two','$states',
                        '$postcode','$inst_acc_name')";

                        $_SESSION['success'] = 'Created Successfully !';
                        header("location: freegift_form.php");
                        
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