<?php
    session_start();
    $conn = new mysqli('localhost','root','', 'freegift_form') or die("Unable To Connect");

    if(isset($_POST['save']) ){
        $firstname = $_POST['first_name'];
        $lastname = $_POST['last_name'];
        $gender = $_POST['gender'];
        $dateofbirth = $_POST['dateofbirth'];
        $phonenumber = $_POST['phonenumber'];
        $email = $_POST['email'];

        $sql = "INSERT INTO freegift_form (first_name, last_name, gender, dateofbirth, phonenumber, email)
        VALUES ('$firstname','$lastname','$gender','$dateofbirth','$phonenumber','$email')";

        if($conn->query($sql) === TRUE){
            //Put Session Messages if true
            $_SESSION['success'] = 'Created Successfully !';
            header("location: freegift_form.php");
        } else {
            //Display false messages if failed
            $_SESSION['error'] = 'Please Try Again !';
            header("location: freegift_form.php");
            
        }  
    }

    $conn->close();
?>