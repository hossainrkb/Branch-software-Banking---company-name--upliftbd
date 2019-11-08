<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Withdraw Process';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);
$updateStatus = "";

if(isset($_POST['br_tpin'])){
    $br_tpin = $_POST['br_tpin'];
    $member_id= $_POST['member_id'];
    $w_pin = $_POST['w_pin'];
    $w_amount= $_POST['w_amount'];
    if($br_tpin==$_SESSION['se_branch']['br_tpin']){
    $wdr_info=get_users_withdraw_info_by_branch_user_pin($branch_id,$member_id,$w_pin);
    if($wdr_info){
        $update_withdraw=update_withdraw_info_status($branch_id,$member_id,$w_pin);
        if($update_withdraw){
            $update_b_blance=update_branch_balance_plus($branch_id,$w_amount);
            if($update_b_blance){            
                $branch_income=add_branch_income($member_id,$branch_id,$w_amount);
                $updateStatus .= "<b style='color: green;'>Fund Withdraw Successful.</b><a class='btn btn-success' href='withdraw_request.php'><b><i class='fa fa-plus-circle'></i> View Withdraw Request.</b></a>";
            }
        }else{
            $updateStatus .= "<b style='color: red;'>Already Paid.</b><a class='btn btn-danger' href='withdraw_process.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
        }
    }else{
        $updateStatus .= "<b style='color: red;'>Withdraw Information Not Match.</b><a class='btn btn-danger' href='withdraw_process.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
    }
    }else{
        $updateStatus .= "<b style='color: red;'>Branch T-Pin Not Match.</b><a class='btn btn-danger' href='withdraw_process.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
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
                        <h2><b><i class="fa fa-reply-all"></i> <?php echo $pageName; ?></b></h2> 
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
                                    <div class="x_content">
                                    <table class="table table-condensed text-left">
                                            <thead>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="4"><h3><b>Enter Withdraw Information Below</b></h3></td>
                                                </tr>
                                                <?php
                                                if($updateStatus){
                                                ?>
                                                <tr class="btn-default text-center">
                                                    <td class="btn-default" colspan="4">
                                                        <h1><b style="color: red;"><?php echo $updateStatus; ?></b></h1>
                                                    </td>
                                                </tr>
                                                 <?php }else if(isset($_REQUEST['user'])&&isset($_REQUEST['pin'])){ 
                                                    $user_info = get_user_info_by_uid_or_contact($_REQUEST['user']);
                                                    if($user_info['u_status']=='1'){
                                                    $withdraw_info=get_users_withdraw_info_by_branch_user_pin($branch_id,$user_info['u_id'],$_REQUEST['pin']);
                                                     if($withdraw_info){
                                                     ?>
                                                <form action="" method="post">
                                                    <input type="hidden" name="member_id" value="<?php echo $user_info['u_id']; ?>" required="" />
                                                    <input type="hidden" name="w_pin" value="<?php echo $withdraw_info['uwr_pin']; ?>" required="" />
                                                    <input type="hidden" name="w_amount" value="<?php echo $withdraw_info['uwr_amount']; ?>" required="" />
                                                    <tr>
                                                        <td>
                                                            <table class="table table-condensed table-bordered text-center">
                                                                <thead>
                                                                    <tr class="btn-danger">
                                                                        <td colspan="2"><b>Branch Information</b></td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-right"><b>Branch Code</b></td>
                                                                        <td class="text-left"><b><?php echo $branch_info['br_code']; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Branch Name</b></td>
                                                                        <td class="text-left"><b><?php echo $branch_info['br_name']; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Available Balance</b></td>
                                                                        <td class="text-left"><b><?php $u_balance=$branch_info['br_amount']; echo number_format($u_balance,2); ?> BDT</b></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <table class="table table-condensed table-bordered text-center">
                                                                <thead>
                                                                    <tr class="btn-danger">
                                                                        <td colspan="2"><b>Member Information</b></td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-right"><b>Member ID</b></td>
                                                                        <td class="text-left"><b><?php echo $user_info['u_userid']; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Member Name</b></td>
                                                                        <td class="text-left"><b><?php echo $user_info['u_name']; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Mobile Number</b></td>
                                                                        <td class="text-left"><b><?php echo $user_info['u_contact']; ?></b></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td colspan="2" class="text-center"><b>Withdraw Amount : <?php echo $withdraw_info['uwr_amount']; ?> BDT</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="text-center">
                                                            <b><input type="password" name="br_tpin" minlength="4" maxlength="4" placeholder="Enter Branch T-Pin" required="" autocomplete="off" autofocus="off"  /></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a class="btn btn-danger pull-left" href="withdraw_process.php"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                                            <label class="btn pull-right text-info"><b><input type="checkbox" required="" /> I Agree</b></label>
                                                        </td>
                                                        <td class="text-right text-info">
                                                            <button type="submit" class="btn pull-right btn-danger"><b><i class="fa fa-sign-out"></i> Confirm Withdraw</b></button>
                                                        </td>
                                                    </tr>
                                                </form>
                                                <?php }else{ ?>
                                                <tr class="text-center">
                                                    <td class="text-danger" colspan="4">
                                                        <h2><b style='color: red;'>Withdraw Information Not Match, Please Try Again.</b></h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <a class="btn btn-default text-center" href="withdraw_process.php"><b><i class="fa fa-recycle"></i> Try Again</b></a>
                                                    </td>
                                                </tr>
                                                 <?php } }else{
                                                ?>
                                                <tr class="text-center">
                                                    <td class="text-danger" colspan="4">
                                                        <h2><b style='color: red;'>Member ID Locked.</b></h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <a class="btn btn-default text-center" href="withdraw_process.php"><b><i class="fa fa-recycle"></i> Try Again</b></a>
                                                    </td>
                                                </tr>
                                                <?php
                                                 } }else{ ?>
                                                <form action="" method="post" >
                                                    <tr>
                                                        <td class="text-right text-info"><h5><b>Member ID :</b></h5></td>
                                                        <td><b><input class="form-control" type="text" name="user" placeholder="Enter Member ID" required="" autofocus="off" autocomplete="off" /></b></td>

                                                        <td class="text-right text-info"><h5><b>Wallet Pin :</b></h5></td>
                                                        <td><b><input class="form-control" type="password" name="pin" placeholder="Enter Wallet Pin" required="" min="1" autofocus="off" autocomplete="off" /></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4">
                                                            <a class="btn btn-danger pull-left" href="cpanel.php"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                                            <button type="submit" class="btn pull-right btn-danger"><b>Continue <i class="fa fa-arrow-circle-right"></i></b></button>
                                                        </td>
                                                    </tr>
                                                </form>
                                                <?php } ?>
                                            </thead>
                                            <tfoot>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="4"><b></b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                </div>
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