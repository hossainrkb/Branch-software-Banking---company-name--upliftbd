<?php
session_start();
if(!isset($_SESSION['user'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Change Password';
$updateStatus = "";

$user_id = $_SESSION['user']['u_id'];
$user_info = get_user_info_by_id($user_id);
$user_branch=get_branch_info_by_id($user_info['u_branch_id']);

if(isset($_POST['tpin'])){
    $tpin = $_POST['tpin'];
    $opass = $_POST['opass'];
    $npass = $_POST['npass'];
    $cpass = $_POST['cpass'];
    
    $old_password = md5($opass);
    $user_password = $user_info['u_password'];
    
    $check_tpin = check_user_tpin($user_id,$tpin);
    
     if($check_tpin){
         if($old_password==$user_password){	
            if($npass==$cpass){
                $new_password=md5($npass);
                $PasswordUpdate = update_user_password($user_id,$new_password);
                $updateStatus .= "<b class='alert-info'>Successfully Changed Your Password .</b>";
            }
            else{
                $updateStatus .= "<b>Your New Password and Confirm not match.</b>";
            }
        } 
        else{
        $updateStatus .= "<b>Your old password not match.</b>";
        }
 }else{
     $updateStatus=$WebsiteSiteName.' T-Pin Problem.';
 }
}
?>
<!DOCTYPE html>
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
<body>
    <div id="wrapper">
        <?php include './navtop.php'; ?>  
        <!-- /. NAV TOP  -->
        <?php include './navside.php'; ?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2><b><i class="fa fa-lock"></i> Change Password</b></h2> 
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default btn-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="form" action="" method="post" >
                                        <table class="table table-condensed text-left table-hover table-striped">
                                            <thead>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="2"><h3><b>Enter Your Information</b></h3></td>
                                                </tr>
                                                <?php
                                                if($updateStatus){
                                                ?>
                                                <tr class="btn-default text-center">
                                                    <td class="btn-default" colspan="2">
                                                        <b style="color: red;">Message: <?php echo $updateStatus; ?></b>
                                                    </td>
                                                </tr>
                                                <?php }else{ ?>
                                                <tr class="text-center">
                                                    <td colspan="2">
                                                        <b style="color: #0088cc;">Please input the current information.</b>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-right text-info"><h5><b>Old Password</b></h5></td>
                                                    <td><b><input class="form-control" type="password" name="opass" placeholder="Enter Old Password" autocomplete="off" autofocus="off" required="" /></b></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right text-info"><h5><b>New Password</b></h5></td>
                                                    <td><b><input class="form-control" type="password" name="npass" placeholder="Enter New Password" autocomplete="off" autofocus="off" required="" /></b></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right text-info"><h5><b>Confirm Password</b></h5></td>
                                                    <td><b><input class="form-control" type="password" name="cpass" placeholder="Enter Confirm Password" autocomplete="off" autofocus="off" required="" /></b></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right text-info"><h5><b>Account T-Pin</b></h5></td>
                                                    <td><b><input class="form-control" type="password" name="tpin" placeholder="Enter Your 4-Digit T-Pin"  minlength="4" maxlength="4" required="" /></b></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">
                                                        <a href="cpanel.php" class="btn btn-danger pull-left"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                                    </td>
                                                    <td class="text-right">
                                                        <button type="submit" class="btn btn-danger"><b><i class="fa fa-check-circle"></i> Change Password</b></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="2"><b></b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>
            <hr />
            <?php include './footer.php'; ?>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
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
<?php } ?>