<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Change T-Pin';
$updateStatus = "";

$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);

if(isset($_POST['password'])){
    $o_tpin = $_POST['o_tpin'];
    $n_tpin = $_POST['n_tpin'];
    $c_tpin = $_POST['c_tpin'];
    $password = $_POST['password'];
    $u_password = md5($password);
    $user_password = $branch_info['br_password'];
    $br_old_tpin = $branch_info['br_tpin'];
        
     if($u_password==$user_password){
         if($o_tpin==$br_old_tpin){	
            if($n_tpin==$c_tpin){
                $PasswordTpin = update_branch_tpin($branch_id,$n_tpin);
                if($PasswordTpin){
                    $updateStatus .= "<b class='alert-info'>Successfully Changed Your Branch T-Pin.</b>";
                }else{
                    $updateStatus .= "<b class='alert-info'>T-Pin Changed Failed.</b>";
                }
            }
            else{
                $updateStatus .= "<b>Your New and Confirm T-Pin are Not Match.</b>";
            }
        } 
        else{
        $updateStatus .= "<b>Branch old T-Pin Not Match.</b>";
        }
 }else{
     $updateStatus='Branch Password Not Match.';
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
                    <div class="col-md-12 text-center">
                        <img class="img img-thumbnail text-center" src="timeline.png" />
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default btn-default">
                        <div class="panel-heading">
                           <h2><b><i class="fa fa-lock"></i> Change <?php echo $WebsiteSiteName; ?> T-Pin</b></h2> 
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="form" action="" method="post" >
                                        <table class="table table-condensed text-left table-hover table-striped">
                                            <thead>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="2"><h3><b>Enter Your Information Below</b></h3></td>
                                                </tr>
                                                <?php
                                                if($updateStatus){
                                                ?>
                                                <tr class="btn-default text-center">
                                                    <td class="btn-default" colspan="2">
                                                        <b style="color: red;">Message : <?php echo $updateStatus; ?></b>
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
                                                    <td class="text-right text-info"><h5><b>Old T-Pin :</b></h5></td>
                                                    <td><b><input class="form-control" type="password" name="o_tpin" placeholder="Enter your 4-Digit <?php echo $WebsiteSiteName; ?> Old T-Pin"  minlength="4" maxlength="4" required="" /></b></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right text-info"><h5><b>New T-Pin :</b></h5></td>
                                                    <td><b><input class="form-control" type="password" name="n_tpin" placeholder="Enter your 4-Digit <?php echo $WebsiteSiteName; ?> New T-Pin"  minlength="4" maxlength="4" required="" /></b></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right text-info"><h5><b>Confirm T-Pin :</b></h5></td>
                                                    <td><b><input class="form-control" type="password" name="c_tpin" placeholder="Enter your 4-Digit <?php echo $WebsiteSiteName; ?> Confirm T-Pin"  minlength="4" maxlength="4" required="" /></b></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right text-info"><h5><b>Account Password :</b></h5></td>
                                                    <td><b><input class="form-control" type="password" name="password" placeholder="Enter Your <?php echo $WebsiteSiteName; ?> Password" autocomplete="off" autofocus="off" required="" /></b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="text-right">
                                                        <a href="cpanel.php" class="btn btn-danger pull-left"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                                        <button type="submit" class="btn btn-danger"><b><i class="fa fa-check-circle"></i> Change T-Pin</b></button>
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