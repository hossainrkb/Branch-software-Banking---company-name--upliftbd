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
if(isset($_REQUEST['tpin'])){
    $mbt_tpin=$_REQUEST['tpin'];
    $mbt_ac_no=$_REQUEST['ft_userid'];
    $mbt_amount=$_REQUEST['ft_amount'];
    $mbt_charge=$_REQUEST['ft_charge'];
    $ft_amount=$mbt_amount+$mbt_charge;
    $check_tpin = check_user_tpin($user_id,$mbt_tpin);
    $check_balance = get_user_info_by_id($user_id);
    $user_balance = $check_balance['u_balance'];
    $ft_tnxId = $_REQUEST['ft_tnxId'];
    $member_info=check_user_info($mbt_ac_no);
    if($check_tpin){
        if($user_balance>=$ft_amount){
            $ex_category='5'; //Funds Transfer
            $ex_user=$user_id;
            $ex_to_ac=$member_info['u_id'];
            $ex_amount=$mbt_amount;
            $ex_charge=$mbt_charge;
            $ex_tnxId=$ft_tnxId;
            $add_expense = add_user_expense_history($ex_user,$ex_to_ac,$ex_category,$ex_amount,$ex_charge,$ex_tnxId);
            if($add_expense){
                    $mbt_balance=($mbt_amount+$mbt_charge);
                    $update_balance = update_user_balance_minus($user_id,$mbt_balance);
                if($update_balance){
                        //$com_type='4'; //Fund Received
                        //$company_fund=add_company_funds($user_id,$com_type,$mbt_charge);
                        //$member_info=check_user_info($ex_to_ac);
                        $dep_user=$member_info['u_id'];
                        $dep_from_id=$user_id;
                        $dep_category='4'; //Fund Received
                        $dep_agent='0';
                        $dep_amount=$ex_amount;
                        $dep_package='0';
                        $dep_level='0';
                        $dep_status='1';
                        $dep_tnxId=strtoupper(uniqid('D'));
                        $add_deposit=add_user_deposit_history($dep_user,$dep_from_id,$dep_category,$dep_amount,$dep_status,$dep_tnxId);
                        if($add_deposit){
                           $d_balance = $dep_amount;
                           $update_balance = update_user_balance_plus($dep_user,$d_balance);
                           $updateStatus .= "<b style='color: green;'>Transfer Request Success.</b><a class='btn btn-success' href='transfer_history.php'><b> <i class='fa fa-history'></i> View History</b></a>";
                           //$exp_info = get_expense_history_info_by_txnId($ex_tnxId);
                        }
                    }
                }
        } else {
            $updateStatus = "<b style='color: red;'>Insufficient Balance.</b><a class='btn btn-danger' href='fund_transfer.php'><b> <i class='fa fa-recycle'></i> Try Again</b></a>";
        }
    }else{
        $updateStatus = "<b style='color: red;'>T-Pin Problem.</b><a class='btn btn-danger' href='fund_transfer.php'><b> <i class='fa fa-recycle'></i> Try Again</b></a>";
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
    <!-- BOOTSTRAP SELECT-->
    <link href="assets/css/bootstrap-select.css" rel="stylesheet" />
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
                        <h2><b><img class="img img-thumbnail img-circle" src="assets/img/site_logo.png" width="50" /> Member to Member Fund Transfer</b></h2> 
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
                                    <?php
                                    if($updateStatus){
                                    ?>
                                    <table class="table text-center">
                                        <tr class="btn-default text-center">
                                            <td class="btn-default" colspan="2">
                                                <h1><b style="color: red;"><?php echo $updateStatus; ?></b></h1>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php } ?>
                                    
                                    <?php
                                    if(isset($_POST['member']) && isset($_POST['amount'])){
                                        $member=$_POST['member'];
                                        $btd_amount=$_POST['amount'];
                                        $member_info=check_user_info($member);
                                        $check_balance = get_user_info_by_id($user_id);
                                        //$service_charge = '1';
                                        $service_charge=$btd_amount*0.10;
                                        $total_amount = $btd_amount+$service_charge;
                                     if($member_info){ 
                                         if(($member==$check_balance['u_userid'])||($member==$check_balance['u_userid'])){
                                        ?>
                                        <table class="table table-bordered">
                                            <tr class="btn-default text-center">
                                                <td colspan="2">
                                                    <h2 class="text-center"><b style="color: red;">You can't transfer to your own account.</b><br/>
                                                    <a class="btn btn-danger" href="fund_transfer.php"><b><i class="fa fa-recycle"></i> Try Again</b></a></h2>
                                                </td>
                                            </tr>
                                        </table>
                                    <?php
                                    }else{
                                    if($check_balance['u_balance']<$total_amount){
                                    ?>
                                    <tr class="btn-default text-center">
                                        <td colspan="2">
                                            <h2 class="text-center">
                                                <b style="color: red;">Insufficient balance in your account.</b><br/>
                                                <a style="color: #0088cc;" class="btn btn-default pull-right" href="fund_transfer.php"><b><i class="fa fa-recycle"></i> Try Again</b></a>
                                            </h2>
                                        </td>
                                    </tr>
                                    <?php }else{ ?>
                                    <form method="post" action="" id="form">
                                        <table class="table table-condensed text-left">
                                            <thead>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="2"><h3><b>FUND TRANSFER DETAILS</b></h3></td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td colspan="2">
                                                        <b style="color: #0088cc; font-size: 20px;">Fund Transfer , Are You Sure?</b>
                                                        <a style="color: red;" class="btn btn-default pull-right" href="fund_transfer.php"><b><i class="fa fa-close"></i> Cancel</b></a>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>  
                                                <tr>
                                                    <td class="text-right"><b class="text-primary">Fund Transfer To :</b></td>
                                                    <td>
                                                        <input type="hidden" name="member_id" value="<?php echo $member_info['u_id']; ?>" required="" readonly="" />
                                                        <b><input type="hidden" name="ft_userid" class="form-control" value="<?php echo $member_info['u_userid']; ?>" required="" readonly="" /></b>
                                                        <b style="color: #0088cc;"><?php echo $member_info['u_userid'].' ('.$member_info['u_name'].')'; ?></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><b class="text-primary">Transfer Amount :</b></td>
                                                    <td>
                                                        <b><input class="form-control" type="hidden" name="ft_amount" value="<?php echo $btd_amount; ?>" required="" readonly="" /></b>
                                                        <b style="color: #0088cc;"><?php echo number_format($btd_amount,2); ?> BDT</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><b class="text-primary">Transfer Charge :</b></td>
                                                    <td>
                                                        <b><input class="form-control" type="hidden" name="ft_charge" value="<?php echo $service_charge; ?>" required="" readonly="" /></b>
                                                        <b style="color: #0088cc;"><?php echo number_format($service_charge,2); ?> BDT</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><h5><b class="text-primary">Total Amount :</b></h5></td>
                                                    <td>
                                                        <h5><b style="color: #0088cc;"><?php echo number_format($total_amount,2); ?> BDT</b></h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><h5><b class="text-primary">Transaction PIN :</b></h5></td>
                                                    <td>
                                                        <b><input class="form-control" type="password" name="tpin" <?php if($check_balance['u_balance']<$total_amount){ echo 'disabled=""';} ?> placeholder="Enter your 4-Digit TPIN"  minlength="4" maxlength="4" required="" /></b>
                                                    </td>
                                                </tr>
                                                <input type="hidden" name="ft_tnxId" value="E<?php echo $check_balance['u_id'].time(); ?>" required="" />
                                                <tr>
                                                    <td colspan="2" class="text-right">
                                                        <a href="fund_transfer.php" class="btn btn-danger pull-left"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                                        <button type="submit" class="btn btn-danger"><b><i class="fa fa-check-circle"></i> Confirm</b></button>
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
                                    <?php    
                                        } } }else{ ?>
                                    <table class="table table-bordered">
                                        <tr class="btn-default text-center">
                                            <td colspan="2">
                                                <h2>
                                                    <b style="color: red;">No Member Found.</b>
                                                    <a class="btn btn-danger pull-right" href="fund_transfer.php"><b><i class="fa fa-recycle"></i> Try Again</b></a>
                                                </h2>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php
                                    } }else{
                                    ?>
                                    <form action="" method="post">
                                        <table class="table table-condensed text-left">
                                            <thead>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="2"><h3><b>ENTER TRANSFER INFORMATION</b></h3></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center" colspan="2"><b class="text-danger"><i class="fa fa-info-circle"></i> <i> Member to Member Fund Transfer Charge 10% For Per Transaction</i></b></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-right text-info"><h5><b>MEMBER ID :</b></h5></td>
                                                    <td>
                                                        <b><input type="text" name="member" class="form-control" placeholder="Example : M21820" required="" /></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right text-info"><h5><b>AMOUNT (BDT) :</b></h5></td>
                                                    <td>
                                                        <b>
                                                            <div class="input-group">
                                                                <input class="form-control" type="number" name="amount" placeholder="Example : 100 (Min: 100, Max: 50000)" min="100" max="50000" required="" />
                                                                <span class="input-group-addon"><b>.00</b></span>
                                                            </div>
                                                        </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><a class="btn btn-danger" href="cpanel.php"><i class="fa fa-reply-all"></i> <b>Back</b></a></td>
                                                    <td class="text-right">
                                                        <button type="submit" class="btn btn-danger"><b><i class="fa fa-send"></i> Transfer</b></button>
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
                                    <?php } ?>
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

