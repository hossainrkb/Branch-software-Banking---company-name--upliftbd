<?php
session_start();
if(!isset($_SESSION['user'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Deposit Details';
$user_id = $_SESSION['user']['u_id'];
$user_info = get_user_info_by_id($user_id);
$user_branch=get_branch_info_by_id($user_info['u_branch_id']);

if(isset($_GET['txnId'])){
    $txnId = $_GET['txnId'];
    $dep_info = get_user_deposit_history_info_by_id($txnId,$user_id);
    $dep_category = get_deposit_category_info_by_id($dep_info['dep_category']); 
} else {
    echo "<meta http-equiv='refresh' content='.5;url=cpanel.php'>";
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
     <!-- MORRIS CHART STYLES-->
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>
<body>
    <div id="wrapper">
        <?php include './navtop.php'; ?>  
        <!-- /. NAV TOP  -->
        <?php include './navside.php'; ?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2><b><i class="fa fa-history"></i> Deposit Details</b></h2>
                    </div>
                </div>
            <!-- /. ROW  -->
            <hr />
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default" style="font-family: monospace;">
                        <div class="panel-body">
                            <table class="table table-condensed table-bordered table-striped table-hover text-center">
                                <thead>
                                    <tr class="btn-danger">
                                        <td colspan="4"><h3><b>Transaction Details</b></h3></td>
                                    </tr>
                                </thead>
                                 <?php if($dep_info){ ?>
                                <tbody>
                                    <tr>
                                        <td class="text-right bg-danger"><b>Transaction Date:</b></td>
                                        <td class="text-left"><b><i class="fa fa-calendar"></i> <?php echo date('d/m/Y',strtotime($dep_info['dep_date'])); ?></b></td>
                                        <td class="text-right bg-danger"><b>Time:</b></td>
                                        <td class="text-left"><b><i class="fa fa-clock-o"></i> <?php echo date('h:i:sA',strtotime($dep_info['dep_time'])); ?></b></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right bg-danger"><b>Deposit Category:</b></td>
                                        <td class="text-left"><b><?php echo $dep_category['dc_name']; ?></b></td>
                                        <td class="text-right bg-danger"><b>Agent:</b></td>
                                        <td class="text-left"><b><?php echo $WebsiteSiteName; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right bg-danger"><b>Source A/C:</b></td>
                                        <td class="text-left"><b>
                                        <?php 
                                        $source_acc = get_user_info_by_id($dep_info['dep_from_id']);
                                        echo $source_acc['u_userid']; ?>
                                        </b></td>
                                        <td class="text-right bg-danger"><b>Destination A/C:</b></td>
                                        <td class="text-left"><b><?php echo $user_info['u_userid']; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right bg-danger"><b>Amount(BDT):</b></td>
                                        <td class="text-left"><b><?php $u_balance=$dep_info['dep_amount']; echo number_format($u_balance,2); ?></b></td>
                                    
                                        <td class="text-right bg-danger"><b>Status:</b></td>
                                        <td class="text-left"><?php if($dep_info['dep_status']==1){ echo '<span class="label label-success">Success</span>';} else{ echo '<span class="label label-danger">Canceled</span>'; } ?></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="btn-danger"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <a class="btn" href="deposit_history.php"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                        </td>
                                    </tr>
                                    <?php }else{ ?>
                                    <tr>
                                        <td colspan="4"><h2 style="color: red;"><b>No Transactions Records are found.</b></h2></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                           <a class="btn" href="deposit_history.php"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
                <!-- /. ROW  -->
                <hr />
        <?php include './footer.php'; ?>
        </div>    
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
