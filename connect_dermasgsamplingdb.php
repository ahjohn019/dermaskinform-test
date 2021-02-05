<?php 
    session_start();
    //test server
    $conn = new mysqli('remotemysql.com','z3UPYAictr','5zZxKj7wNZ','z3UPYAictr') or die("Unable To Connect");

    // $conn = new mysqli('localhost','root','', 'freegift_form') or die("Unable To Connect");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    if(isset($_POST['save'])){
        $firstname = $_POST['derma_firstname'];
        $lastname = $_POST['derma_lastname'];
        $dateofbirth = $_POST['derma_dateofbirth'];
        $phonenumber = $_POST['derma_phonenumber'];
        $email = $_POST['derma_email'];
        $gender = $_POST['derma_gender'];
        $address = $_POST['derma_address_main'];
        $postcode = $_POST['derma_postcode'];
        $selectitem = $_POST['derma_select_item'];
        $selectmultipleitem = "";

        $selectwholesql = "SELECT * FROM freegift_sgform";

        foreach($selectitem as $select){
            if(count($selectitem) == 1){
                $selectmultipleitem .= $select;
            } else {
                $selectmultipleitem .= $select.',';
            }
        }

        //select email data from db
        $selectemailsql = "SELECT * FROM freegift_sgform WHERE email='$email'";

        if($emailresult=mysqli_query($conn,$selectemailsql)){
            //Return number rows in result set
            $rowcount = mysqli_num_rows($emailresult);

            //Check Duplication For Email, If Detected Dont Save (Throw Message Ask User Retry Again) Else Save It.
            if($rowcount > 0){
                $_SESSION['email_duplicate'] = "Cannot Input Same Email With Previous One, Please Retry Again.";
                header("location: derma_sgsamplingform.php");
            } else {
                //limit database in live server db
                $selectwholesql = "SELECT * FROM freegift_sgform";

                if($wholeresult=mysqli_query($conn,$selectwholesql)){
                    $wholerowcount = mysqli_num_rows($wholeresult);
                    if($wholerowcount >= 1){ //1534
                        $_SESSION['stop_insert'] = 'Reached Maximum 500 Already, Thanks For Joining Us.';
                        header("location: derma_sgsamplingform.php");
                    } else {
                        $sql = "INSERT INTO
                        freegift_sgform (first_name, last_name, dob,
                        gender,email,address_main,postcode,phonenumber,free_gift)
                        VALUES ('$firstname','$lastname','$dateofbirth',
                        '$gender','$email','$address','$postcode','$phonenumber','$selectmultipleitem')";

                        if ($conn->query($sql) === TRUE) {
                            $_SESSION['success'] = 'Created Successfully !';
                            header("location: derma_sgsamplingform.php");
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        } 
                    }
                } 
            }    
        }
    }

    $conn -> close();

?>