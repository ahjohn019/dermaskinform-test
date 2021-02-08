<?php 
    include 'connect_dermasgsamplingdb.php' ;
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="static/css/derma_sgsamplingform.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="static/js/bannermapping.js"></script>
</head>

<body>
    <div class="container">
        <div class="derma-formcontainer">
            <?php if(isset($_SESSION['success'])){ ?>
                <div class="alert alert-success"><?php echo $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); } ?>
            <?php if(isset($_SESSION['email_duplicate'])) { ?>
                <div class="alert alert-danger"><?php echo $_SESSION['email_duplicate'] ?></div>
            <?php unset($_SESSION['email_duplicate']); }?>

            
            <img src="static/assets/biretix_banner.jpg" alt="" class="biretix_banner">
            <h1>Registration</h1>
            <p class="derma-formsubtitle">Register as Dermaskinshop SG sampling program to receive free gifts!*</p>
            <p class="derma-alertmessages">*Fields are compulsory!</p>

            <form method="post" action="connect_dermasgsamplingdb.php" enctype="multipart/form-data" id="dermaskin_form">
                <div class="column">
                    <div class="derma-halfcolumn">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="derma_firstname" name="derma_firstname" maxlength="20" required>
                        </div>
                    </div>
                    <div class="derma-halfcolumn">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="derma_lastname" name="derma_lastname" maxlength="20" required>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="derma-halfcolumn">
                        <div class="form-group">
                            <label for="dateofbirth">Date Of Birth</label>
                            <input type="text" class="form-control" id="derma_dateofbirth" name="derma_dateofbirth" pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[13-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" title="Must Follow Date Format(dd/mm/yyyy)" required>
                        </div>
                    </div>
                    <div class="derma-halfcolumn">
                        <div >
                            <label for="gender">Gender</label>
                        </div>
                        <div class="form-check-inline">
                            <input type="radio" class="form-check-input" name="derma_gender" value="male">
                            <label class="form-check-label">
                                Male
                            </label>
                            <input type="radio" class="form-check-input" name="derma_gender" value="female">
                            <label class="form-check-label">
                                Female
                            </label>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="derma-halfcolumn">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="derma_email" name="derma_email"></input>
                        </div>
                    </div>
                    <div class="derma-halfcolumn">
                        <div class="form-group">
                            <label for="phonenumber">Phone Number</label>
                            <input type="text" class="form-control" id="derma_phonenumber" name="derma_phonenumber"></input>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address_main">Address</label>
                    <input type="text" class="form-control" id="derma_address_main" name="derma_address_main" required>
                </div>
                <div class="form-group">
                    <label for="postcode">Postcode</label>
                    <input type="text" class="form-control" id="derma_postcode" name="derma_postcode" required>
                </div>

                <div class="term-conditions">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="termconditions" required>
                        <label class="form-check-label" for="termconditions">
                        <strong>Agree to terms and conditions</strong>
                        </label>
                        <p>I agree to the processing of my personal data in accordance with <a href="https://dermaskinshop.com.my/privacy-policy">Privacy policy</a>.</p>
                    
                    </div>
                    </div>                 
                    <button type="button" class="btn btn-primary" onclick="chooseItem()" style="position:absolute; left:50%;">Choose Items</button>                 
                </div>

                <div id="rewardWinMessage" class="modal">
                    <div class="modal-content">
                        <p style="text-align:center;">Please Select Your Welcome Gift</p>   
                        <div class="column">
                            <div class="img-content" >
                                <img src="static/assets/exv_vespera_thumbnails.png" alt="" class="imgselection">
                                <div id="selection_one" class="img-content-redeem" value="exuviance_vespera">REDEEM</div>
                                <div class="img-content-box-text">
                                    <p style="text-align:center;">
                                        <input type="checkbox" name="derma_select_item[]" value="exuviance_vespera">
                                            Exuviance Vespera
                                    </p>
                                </div>
                            </div>
                            <div class="img-content">
                                <img src="static/assets/exuviancesample-removebg.png" alt="" class="imgselection">
                                <div id="selection_two" class="img-content-redeem" value="exuviance_clay_masque">REDEEM</div>
                                <div class="img-content-redemption"></div>
                                <div class="img-content-box-text">
                                    <p style="text-align:center;">
                                        <input type="checkbox" name="derma_select_item[]" value="exuviance_clay_masque"> 
                                            Exuviance Clay Masque                                                                   
                                    </p>
                                </div>
                            </div>

                            <!-- <div class="img-content-redemption"></div> -->
                        </div>
                        <button onclick="onSelect()" type="submit" class="btn btn-primary" name="save" style="position:relative;left:42%;">Sign Up</button>
                    </div>
                </div>
            </form>
                <!-- <button type="submit" class="btn btn-primary" onclick="chooseItem()" style="position:absolute; left:50%;">Choose Items</button> -->
        </div>
    </div>

</body>

<script>
    $(document).ready(function(){
      $('#derma_dateofbirth').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth : true,
        changeYear : true,
        yearRange : "1930:2020"
      });
    });
</script>
</html>