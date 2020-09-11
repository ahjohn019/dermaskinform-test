
<?php 
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS only -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  
  <!-- JS, Popper.js, and jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">

  <?php if(isset($_SESSION['success'])){ ?>
    <div class="alert alert-success">Submitted Successfully!!</div>
  <?php unset($_SESSION['success']); } ?>

  <h1>Free Gift Form</h1>
  <form method="post" action="freegiftdatabase.php">
    <div class="form-group">
      <label for="text">First Name:</label>
      <input type="text" class="form-control" id="first_name" placeholder="Enter First Name" name="first_name" required>
    </div>

    <div class="form-group">
      <label for="text">Last Name:</label>
      <input type="text" class="form-control" id="last_name" placeholder="Enter Last Name" name="last_name" required>
    </div>

    <div class="form-group">
        <label for="gender">Gender:</label>
        <select class="form-control" id="gender-select" name="gender" required>
          <option selected>Choose...</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
        </select>
    </div>

    <div class="form-group">
        <label for="text">Date Of Birth</label>
        <input type="text" class="form-control" id="dateofbirth" placeholder="Enter Date Of Birth" name="dateofbirth" required>
    </div>

    <div class="form-group">
        <label for="text">Phone Number: </label>
        <input type="text" class="form-control" id="phonenumber" placeholder="Enter Phone Number" name="phonenumber" required>
    </div>

    <div class="form-group">
        <label for="email">Email: </label>
        <input type="email" class="form-control" id="email" placeholder="Enter Your Email" name="email" required>
    </div>

    <!--<div class="form-group">
       <p>Choose File: </p>
       <input type="file" id="chooseFile" name="choosefilename">
    </div>  -->
    
    <button type="submit" class="btn btn-primary" name="save">Submit</button>
  </form>
</div>
</body>

<!--datepicker-->
<script>
    $(document).ready(function(){
      $('#dateofbirth').datepicker({
        format: 'mm/dd/yyyy',
        changeMonth : true,
        changeYear : true,
        yearRange : "1930:2020"
      });
    });
</script>
</html>


    
