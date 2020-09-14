<?php
    session_start();

    //live server
    // $conn = new mysqli('remotemysql.com','z3UPYAictr','5zZxKj7wNZ','z3UPYAictr') or die("Unable To Connect");

    //test server
    $conn = new mysqli('localhost','root','', 'freegift_form') or die("Unable To Connect");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
    
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
        $city = $_POST['city'];
        $states = $_POST['states'];
        $postcode = $_POST['postcode'];
        $countries = $_POST['countries'];
        $inst_acc_name = $_POST['inst_acc_name'];
        $attachment_name = $_POST['attachment_name'];
        
        //image part
        //file error message init
        $attacherrors = array();
        //file name with random number so that similiar dont get replaced
        $attachfile = rand(1000,10000)."-".$_FILES["image"]["name"];
        //get the file size
        $attachfilesize = $_FILES['image']['size'];
        //temp file name to store file
        $tempfile = $_FILES["image"]["tmp_name"];
        //upload dir path
        $uploads_dir = 'static/images';
        //restrict the file size
        if($attachfilesize > 2097152){
            $attacherrors[] = "File Size Must Be Not More Than 2 MB";
        }

        if(empty($attacherrors)==true){
            //move upload file to specify location
            move_uploaded_file($tempfile, $uploads_dir.'/'.$attachfile);
        }else{
            //print error messages if image was invalidated
            print_r($attacherrors);
        }

        //insert sql file to db
        $sql = "INSERT INTO 
        freegift_form (first_name, last_name, gender, dateofbirth, 
        phonenumber, email, address_line_one, address_line_two,
        city, states, postcode, countries, inst_acc_name, attachment_name, attachment)
        VALUES ('$firstname','$lastname','$gender','$dateofbirth','$phonenumber','$email',
        '$address_line_one','$address_line_two','$city','$states','$postcode',
        '$countries','$inst_acc_name','$attachment_name','$attachfile')";

        //select data from db
        // $selectsql = "SELECT * FROM freegift_form WHERE email='$email'";
        
        // if($result=mysqli_query($conn,$selectsql)){
        //     //Return number rows in result set
        //     $rowcount = mysqli_num_rows($result);
        //     print_r($rowcount);

        //     //Check Duplication For Email
        //     if($rowcount > 0){
        //         echo "Previous Email Was Detected, Please Try With New Email !!";
        //     }
        //     else {
        //         echo "Invalid Function Happened";
        //     }
        // }


        //Test SQL All Column First
        // print_r($attachment_name);

        // //Success Can Direct To Save The Data
        if($conn->query($sql) === TRUE){
            //Put Session Messages if true
            $_SESSION['success'] = 'Created Successfully !';

            //Test The DB Message If Success
            // echo 'Created Successfully !';
            header("location: freegift_form.php");
        } else {
            //Display false messages if failed
            $_SESSION['error'] = 'Please Try Again !';
            //Test The DB Message If Failed
            // echo 'Submitted Failed !';
            header("location: freegift_form.php");    
        }  
    }
    $conn->close();
?>