<?php
session_start();
if(!isset($_SESSION['user'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Withdraw Funds';
$user_id = $_SESSION['user']['u_id'];
$user_info = get_user_info_by_id($user_id);
$user_branch=get_branch_info_by_id($user_info['u_branch_id']);
$updateStatus = "";
$sms_sent="";
if(isset($_POST['w_tpin'])){
    $a_tpin = $_POST['w_tpin'];
    $w_tnxId = $_POST['w_tnxId'];
    $w_branch=$_POST['w_branch'];
    $w_amount = $_POST['w_amount'];
    $w_charge = $_POST['w_charge'];
    $w_balance=$w_amount+$w_charge;
    if($a_tpin==$user_info['u_tpin']){
    if($user_info['u_balance']>=$w_balance){
        $ex_category='3'; //Withdraw Funds
        $ex_charge=$w_charge;
        $ex_to_ac='0';
        $ex_tnxId=$w_tnxId;
        $expense_history=add_user_expense_history($user_id,$ex_to_ac,$ex_category,$w_amount,$ex_charge,$ex_tnxId);
        if($expense_history){
            $w_pin=$user_info['u_id'].generatePIN(4).$user_info['u_branch_id'];
            $withdraw_request=add_users_withdraw_request($w_branch,$w_amount,$w_pin,$w_tnxId,$user_id);
        $update_user_blance=update_user_balance_minus($user_id,$w_balance);
        if($update_user_blance){             
            $updateStatus .= "<b style='color: green;'>Request Success.</b><a class='btn btn-success' href='withdraw_history.php'><b><i class='fa fa-history'></i> Withdraw History</b></a>";
            //$sms_token = "7d66f247b0f370bab46681c906fd58f5"; //robi
            $br_info= get_branch_info_by_id($w_branch);
            $branchInfo=$br_info['br_name'].'('.$br_info['br_code'].')';
            $userId=$user_info['u_userid'];
            $userName=$user_info['u_name'];
            $to=$user_info['u_contact'];
            $sms_message = "Dear $userName,\nYour Withdraw Info.\nMember ID:$userId\nAmount:$w_amount BDT\nWallet Pin:$w_pin\nBranch:$branchInfo\n@$webUrl";
            $sms_url = "http://api.smscpanel.net/api.php";
            $sms_data= array(
            'to'=>"$to",
            'message'=>"$sms_message",
            'token'=>"$sms_token"
            ); // Add parameters in key value
            $chr = curl_init(); // Initialize cURL
            curl_setopt($chr,CURLOPT_URL,$sms_url);
            curl_setopt($chr,CURLOPT_POSTFIELDS, http_build_query($sms_data));
            curl_setopt($chr,CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($chr);
            if($smsresult){
                $sms_sent.="Message Sent Successfully.";
            }
            else{
               $sms_sent.='Message Sent Failed.';
            }
            }
        }else{
            $updateStatus .= "<b style='color: red;'>Session Expired.</b><a class='btn btn-danger' href='withdraw_funds.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
        }
    }else{
        $updateStatus .= "<b style='color: red;'>Insufficient Balance.</b><a class='btn btn-danger' href='withdraw_funds.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
    }
    }else{
        $updateStatus .= "<b style='color: red;'>T-Pin Not Match.</b><a class='btn btn-danger' href='withdraw_funds.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
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
                        <h2><b><i class="fa fa-money"></i> Withdraw Funds</b></h2> 
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
                                <div class="col-md-12 text-center">
                                        <table class="table table-condensed text-left">
                                            <thead>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="2"><h3><b>Withdraw Information</b></h3></td>
                                                </tr>
                                                <?php
                                                if($updateStatus){
                                                ?>
                                                <tr class="btn-default text-center">
                                                    <td class="btn-default" colspan="2">
                                                        <h1><b style="color: red;"><?php echo $updateStatus; ?></b></h1>
                                                    </td>
                                                </tr>
                                                 <?php }else if(isset($_REQUEST['branch'])&&isset($_REQUEST['amount'])){ 
                                                     $branch_info= get_branch_info_by_id($_REQUEST['branch']);
                                                     $r_amount=$_REQUEST['amount'];
                                                     $r_charge=$r_amount*0.03;
                                                     $r_balance=$r_amount+$r_charge;
                                                     ?>
                                                <form action="" method="post" >
                                                    <tr>
                                                        <tr>
                                                            <td class="text-right text-info"><b>Branch Name & Code :</b></td>
                                                            <td class="text-left text-info"><b><?php echo $branch_info['br_name'].' ('.$branch_info['br_code'].')'; ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right text-info"><b>Withdraw Amount :</b></td>
                                                            <td class="text-left text-info"><b><?php echo number_format($r_amount,2); ?> BDT</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right text-info"><b>VAT & Tax (3%) :</b></td>
                                                            <td class="text-left text-info"><b><?php echo number_format($r_charge,2); ?> BDT</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right text-info"><b>Total Balance :</b></td>
                                                            <td class="text-left text-info"><b><?php echo number_format($r_balance,2); ?> BDT</b></td>
                                                        </tr>
                                                        <?php 
                                                        if(($user_info['u_balance']>=$r_balance)&&($user_info['u_status']=='1')){
                                                        ?>
                                                        <input type="hidden" name="w_branch" value="<?php echo $_REQUEST['branch']; ?>" required="" />
                                                        <input type="hidden" name="w_amount" value="<?php echo $r_amount; ?>" required="" />
                                                        <input type="hidden" name="w_charge" value="<?php echo $r_charge; ?>" required="" />
                                                        <input type="hidden" name="w_tnxId" value="<?php echo strtoupper(uniqid('E')); ?>" required="" />
                                                        <tr>
                                                            <td class="text-right text-info"><h5><b>Enter Your T-Pin :</b></h5></td>
                                                            <td colspan="2">
                                                                <b><input class="form-control" type="password" name="w_tpin" minlength="4" maxlength="4" placeholder="Enter Your T-Pin" required="" autocomplete="off" autofocus="off"  /></b>
                                                            </td>
                                                        </tr>
                                                        <?php }else{ ?>
                                                        <tr class="text-center"><td class="text-danger" colspan="2"><b>Insufficient Balance.</b></td></tr>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a class="btn btn-danger pull-left" href="withdraw_funds.php"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                                            <label class="btn pull-right text-info"><b><input type="checkbox" required="" /> Confirmation</b></label>
                                                        </td>
                                                        <td class="text-right text-info">
                                                            <?php 
                                                            if(($user_info['u_balance']>=$r_balance)&&($user_info['u_status']=='1')){
                                                            ?>
                                                            <button type="submit" class="btn btn-danger"><b><i class="fa fa-sign-out"></i> Confirm Withdraw</b></button>
                                                            <?php }else{ ?>
                                                            <button class="btn btn-danger disabled"><b><i class="fa fa-sign-out"></i> Confirm Withdraw</b></button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                </form>
                                                <?php }else{ ?>
                                                <form action="" method="post" >
                                                <tr>
                                                    <td class="text-right text-info"><h5><b>Branch :</b></h5></td>
                                                    <td>
                                                        <b>
                                                            <select class="form-control" name="branch" required="">
                                                            <option value="">Select Withdraw Branch</option>
                                                            <?php 
                                                            $branch_list= get_all_branch_list();
                                                            foreach ($branch_list as $branch){
                                                            ?>
                                                            <option value="<?php echo $branch['br_id']; ?>"><?php echo $branch['br_name'].' ('.$branch['br_code'].')'; ?></option>
                                                            <?php } ?>
                                                            </select>
                                                        </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right text-info"><h5><b>Amount :</b></h5></td>
                                                    <td><b><input class="form-control" type="number" name="amount" placeholder="Enter Withdraw Amount" required="" min="100" max="<?php echo $user_info['u_balance']; ?>" autofocus="off" autocomplete="off" /></b></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a class="btn btn-danger pull-left" href="cpanel.php"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                                    </td>
                                                    <td class="text-right text-info">
                                                        <button type="submit" class="btn btn-danger"><b>Continue <i class="fa fa-arrow-circle-right"></i></b></button>
                                                    </td>
                                                </tr>
                                                </form>
                                                <?php } ?>
                                            </thead>
                                            <tfoot>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="2"><b></b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    
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