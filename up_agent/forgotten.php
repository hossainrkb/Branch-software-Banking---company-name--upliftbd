<?php
    session_start();
    if(isset($_SESSION['user'])){
    header("Location: cpanel.php");
}else{
    include './includes/functions.php';
    $pageName = 'Forgot Password';
    $messages = "";
    $sms='';
if(isset($_POST['reset_pass'])){
    $contact = $_POST['contact_no'];
    $mo_code = substr($contact,0,3);
    $m_operator_info = get_mobile_operator_info_by_code($mo_code);
    if($m_operator_info){
        if(check_branch_info_by_br_code($contact)){
            $resetuser=check_branch_info_by_br_code($contact);
            $user_name=$resetuser['e_name'];
            $userId=$resetuser['e_userid'];
            $restepass=generatePIN(8);
            $user_pass = md5($restepass);
            $results = mysql_query("UPDATE tbl_employee_info SET e_password='".$user_pass."' WHERE e_contact='".$contact."'");
            $messages = "<div class='alert alert-success'>
                <button class='close' data-dismiss='alert'>&times;</button>
                We've sent a password to your Mobile Number $contact
                </div>";
            if($results){
                $sms_to=$contact;
                $sms_message = "Dear $user_name,\nYour Login Info.\nEmployee ID: $userId\nReset Password: $restepass\nVisit: emp.$webUrl";
                $sms_url = "http://sms.greenweb.com.bd/api.php";
                $sms_data= array(
                'to'=>"$sms_to",
                'message'=>"$sms_message",
                'token'=>"$sms_token"
                ); // Add parameters in key value
                $chr = curl_init(); // Initialize cURL
                curl_setopt($chr,CURLOPT_URL,$sms_url);
                curl_setopt($chr,CURLOPT_POSTFIELDS, http_build_query($sms_data));
                curl_setopt($chr,CURLOPT_RETURNTRANSFER, true);
                $smsresult = curl_exec($chr);
            }
	}
	else{
            $messages = "<div class='alert alert-danger'>
            <button class='close' data-dismiss='alert'>&times;</button>
            Contact Number Not Found.
            </div>";
	}
    }else{
        $messages .=  "<div class='alert alert-danger'>Please Input a valid Mobile Number.</div>";
    }  
}
?>
﻿<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $pageName.'-'.$WebsiteSiteName; ?></title>
    <link rel="shortcut icon" href="favicon.ico">
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body class="bg-success">
    <div class="container">
        <br /> <br /> <hr/>
        <div class="row text-center ">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <img class="img img-thumbnail" src="logo.png" />
            </div>
            <div class="col-md-4"></div>
        </div>
        
         <div class="row ">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                  <div class="panel panel-default">
                        <table class="table">
                            <thead>
                                <tr class="btn-primary">
                                    <td class="text-center"><h2 style="color: white;"><b>Forgot Password</b></h2></td>
                                </tr>
                            </thead>
                        </table>
                      <div class="panel-body">
                      <?php 
                      if($messages){
                      ?>
                      <div class="row">
                          <div class="col-md-12">
                                <b><?php echo $messages; ?></b>
                          </div>
                      </div>
                      <?php }?>
                          <form role="form" action="" method="post" enctype="multipart/form-data">
                                <b class="text-primary">Mobile Number</b>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <b><input type="text" name="contact_no" class="form-control" placeholder="Enter Your Mobile No" minlength="11" maxlength="11" autocomplete="off" autofocus="off" required="" /></b>
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" required="" /> <b class="text-primary">Confirmation</b>
                                    </label>
                                </div>
                              <button type="submit" name="reset_pass" class="btn btn-primary btn-block"><i class="fa fa-recycle"></i> <b>Reset Password</b></button>
                          </form>
                      </div>
                      <div class="panel-footer text-center">
                          <b class="text-info"><i class="fa fa-info-circle"></i> Already Registered ?</b> <a href="login.php"><span class="badge btn-success"><b>Click Here</b></span></a>
                      </div>
                  </div>
              </div>
         </div>
        <hr />
        <?php include './footer.php'; ?>
    </div>
     <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
   
</body>
</html>
<?php
}
?>
