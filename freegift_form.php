
<?php 
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Free Gift Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS only -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="static/dermaskinform.css">


  <!-- JS, Popper.js, and jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

  <script src="static/js/validationform.js"></script>
</head>
<body>

<div class="container">
  <?php if(isset($_SESSION['success'])){ ?>
    <div class="alert alert-success"><?php echo $_SESSION['success'] ?></div>
  <?php unset($_SESSION['success']); } ?>

  <?php if(isset($_SESSION['email_duplicate'])){ ?>
     <div class="alert alert-danger"><?php echo $_SESSION['email_duplicate'] ?></div>
  <?php unset($_SESSION['email_duplicate']); }?>

  <?php if(isset($_SESSION['stop_insert'])){ ?>
    <div class="alert alert-danger"><?php echo $_SESSION['stop_insert'] ?></div>
  <?php unset($_SESSION['stop_insert']); } ?>

  <!--Put Background Banner Here-->
  <div class="banner-header">
      <img src="static/assets/banner-heliocare-final.jpg" alt="" class="img-class"/>
  </div>

  <!--Title text here-->
  <div class="dermaskin-form">
    <div class="dermaskin-form-box">
      <h3>Follow us NOW to redeem your FREE samples!</h3>
      <p style="text-decoration: underline; font-size:20px;">2 simple steps to redeem!</p>
      <p>1. Follow our Instagram accounts:</p>
      <p>@dermaskinshopmy: <a href="https://www.instagram.com/dermaskinshopmy/">https://www.instagram.com/dermaskinshopmy/</a></p>
      <p>@Exuviancemy: <a href=" https://www.instagram.com/exuviancemy/"> https://www.instagram.com/exuviancemy/</a></p>
      <p class="custom-paragraph"><strong>Both accounts have to be followed to be entitled for the free samples!</strong></p>
      <p>2. Fill in the details below and you are done!</p>
      
      <span class="custom-paragraph"><span>**</span><strong>while stock last</strong><br /></span>
      <span class="custom-paragraph"><span>**</span><strong>only applicable for NEW Dermaskinshop customers</strong></span>
      
    </div>
  </div> 
  
  <div class="select-product-header">
    <h4><strong>PLEASE SELECT THE SAMPLE PRODUCT YOU WOULD LIKE TO RECEIVE</strong></h4>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="sampleProduct1" id="sampleProduct1" value="option1" checked>
      <label class="form-check-label" for="sampleProduct1">
        <strong>Exuviance Purifying Cleansing Gel (2ml) & Exuviance Evening Restorative Complex (2ml)</strong>
      </label>
    </div>
  </div>

  <form method="post" action="freegiftdatabase.php" enctype="multipart/form-data" id="dermaskin_form">
    <h4>Part 1: Basic Information</h4>
    <div class="form-group">
        <label for="text">Instagram Account Name : </label>
        <input type="text" class="form-control" id="inst_acc_name" name="inst_acc_name" >
    </div>

    <div class="form-group">
      <label for="text">First Name :</label>
      <input type="text" class="form-control" id="first_name" name="first_name" >
    </div>

    <div class="form-group">
      <label for="text">Last Name :</label>
      <input type="text" class="form-control" id="last_name" name="last_name" >
    </div>

    <div class="form-group">
        <label for="gender">Gender :</label>
        <select class="form-control" id="gender-select" name="gender" >
          <option selected>Choose...</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
        </select>
    </div>

    <div class="form-group">
        <label for="text">Date Of Birth :</label>
        <input type="text" class="form-control" id="dateofbirth" name="dateofbirth" required>
    </div>

    <div class="form-group">
        <label for="text">Phone Number :</label>
        <input type="text" class="form-control" id="phonenumber" name="phonenumber" required>
    </div>

    <div class="form-group">
        <label for="email">Email : </label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <h4>Part 2: Where should we deliver your sample?</h4>
    <div class="form-group">
          <label for="text">Address Line 1 :</label>
          <input type="text" class="form-control" id="addr1" name="addr1" required>
    </div>

    <div class="form-group">
          <label for="text">Address Line 2 :</label>
          <input type="text" class="form-control" id="addr2" name="addr2" required>
    </div>

    <div class="form-group">
        <label for="text">City :</label>
        <input type="text" class="form-control" id="city" name="city" required>
    </div>

    <div class="form-group">
        <label for="text">State :</label>
        <input type="text" class="form-control" id="states" name="states" required>
    </div>

    <div class="form-group">
        <label for="text">PostCode :</label>
        <input type="text" class="form-control" id="postcode" name="postcode">
    </div>

    <div class="terms-conditions">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="termconditions">
        <label class="form-check-label" for="termconditions">
          <strong>Agree to terms and conditions</strong>
        </label>
        <p>I agree to the processing of my personal data in accordance with <a href="https://dermaskinshop.com.my/privacy-policy">Privacy policy</a>.</p>
      </div>
    </div>
    
    <button type="submit" class="btn btn-primary" name="save" onclick="validation_test()">Submit</button>
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


    
