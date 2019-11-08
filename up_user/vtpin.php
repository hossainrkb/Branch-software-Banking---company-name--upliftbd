<?php
session_start();
if(!isset($_SESSION['user'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'View T-Pin';
$updateStatus = "";

$user_id = $_SESSION['user']['u_id'];
$user_info = get_user_info_by_id($user_id);
$user_branch=get_branch_info_by_id($user_info['u_branch_id']);

if(isset($_POST['password'])){
    $password = $_POST['password'];
    $u_password = md5($password);
    $user_password = $user_info['u_password'];
    $user_tpin = $user_info['u_tpin'];
    
if($u_password==$user_password){
         $updateStatus .= "<b>Your Account T-Pin is : [ $user_tpin ]</b>";
 }else{
     $updateStatus .=$WebsiteSiteName.' Password Problem.';
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
                        <h2><b><i class="fa fa-lock"></i> View <?php echo $WebsiteSiteName; ?> T-Pin</b></h2> 
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
                                        <table class="table table-condensed text-left">
                                            <thead>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="3"><h3><b>Enter Your Information</b></h3></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center" colspan="3">
                                                        <img class="img img-thumbnail img-circle btn disabled" src="assets/img/lock.png" alt="Lock" />
                                                    </td>
                                                </tr>
                                                <?php
                                                if($updateStatus){
                                                ?>
                                                <tr class="btn-default text-center">
                                                    <td class="btn-default" colspan="3">
                                                        <h1><b style="color: red;"><?php echo $updateStatus; ?></b> <a class="btn btn-default" href="vtpin.php"><b>Try Again</b></a></h1>
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td colspan="3"><b></b></td>
                                                </tr>
                                                <?php }else{ ?>
                                                <tr>
                                                    <td class="text-right"><h5 class="text-danger"><b>Account Password</b></h5></td>
                                                    <td><b><input class="form-control" type="password" name="password" placeholder="Enter Your Password" autocomplete="off" autofocus="off" required="" /></b></td>
                                                    <td class="text-left">
                                                        <button type="submit" class="btn btn-danger"><b><i class="fa fa-eye"></i> View T-Pin</b></button>
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td colspan="3"><b></b></td>
                                                </tr>
                                                <?php } ?>
                                            </thead>
                                            <tfoot>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="3"><b></b></td>
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