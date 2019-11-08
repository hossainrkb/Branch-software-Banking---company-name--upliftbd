<?php
session_start();
if(!isset($_SESSION['user'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Expence Details';
$user_id = $_SESSION['user']['u_id'];
$user_info = get_user_info_by_id($user_id);
$user_branch=get_branch_info_by_id($user_info['u_branch_id']);
if(isset($_GET['txnId'])){
    $ex_id = $_GET['txnId'];
    $exp_info = get_user_expense_history_info_by_id($ex_id,$user_id);
    $ex_type = get_expense_type_info_by_id($exp_info['ex_type']);
    $ex_category = get_expense_category_info_by_id($exp_info['ex_category']);
} else {
    echo "<meta http-equiv='refresh' content='.5;url=cpanel.php'>";
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $exp_info['ex_tnxId']; ?></title>
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
    <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2><b><?php echo $WebsiteSiteName; ?></b></h2>
                </div>
            </div>
            <!-- /. ROW  -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default btn-default" style="font-family: monospace;">
                        <div class="panel-body">
                            <table class="table table-condensed table-bordered table-striped table-hover text-center">
                                <thead>
                                    <tr class="btn-danger">
                                        <td colspan="4"><h3><b>Transaction Details</b></h3></td>
                                    </tr>
                                </thead>
                                <?php if($exp_info){ ?>
                                <tbody>
                                    <tr>
                                        <td class="text-right bg-danger"><b>Transaction Date:</b></td>
                                        <td class="text-left"><b><i class="fa fa-calendar"></i> <?php echo date('d/m/Y',strtotime($exp_info['ex_date'])); ?></b></td>
                                        <td class="text-right bg-danger"><b>Time:</b></td>
                                        <td class="text-left"><b><i class="fa fa-clock-o"></i> <?php echo date('h:i:sA',strtotime($exp_info['exp_time'])); ?></b></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right bg-danger"><b>Expense Category :</b></td>
                                        <td class="text-left"><b><?php echo $ex_category['ec_name']; ?></b></td>
                                        <td class="text-right bg-danger"><b>Agent:</b></td>
                                        <td class="text-left"><b><?php echo $WebsiteSiteName; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right bg-danger"><b>Total Amount:</b></td>
                                        <td class="text-left"><b><?php echo number_format($exp_info['ex_amount'],2); ?></b></td>
                                        <td class="text-right bg-danger"><b>Charge:</b></td>
                                        <td class="text-left"><b><?php echo number_format($exp_info['ex_charge'],2); ?></b></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right bg-danger"><h5><b>Total Amount:</b></h5></td>
                                        <td class="text-left"><h5><b><?php $balance=$exp_info['ex_amount']+$exp_info['ex_charge']; echo number_format($balance,2); ?></b></h5></td>
                                        <td class="text-right bg-danger"><h5><b>Status:</b></h5></td>
                                        <td class="text-left"><h5><b><?php if($exp_info['ex_status']==1){ echo '<span class="label label-success">Success</span>';} else{ echo '<span class="label label-danger">Canceled</span>'; } ?></b></h5></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="btn-danger"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <button type="button" class="btn btn-sm btn pull-left" onClick="window.close()">
                                                <i class="fa fa-close"> <b>Close</b></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn pull-right" onClick="window.print()">
                                                <i class="fa fa-print"> <b>Print</b></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="4"><h2 style="color: red;"><b>No Transactions Records are found.</b></h2></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <button type="button" class="btn btn-sm btn-default" onClick="window.close()">
                                                <i class="fa fa-close"> <b>Close</b></i>
                                            </button>
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
        <?php include './footer.php'; ?>
        </div>
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
