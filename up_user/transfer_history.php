<?php
session_start();
if(!isset($_SESSION['user'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Fund Transfer History';
$user_id = $_SESSION['user']['u_id'];
$user_info = get_user_info_by_id($user_id);
$user_branch=get_branch_info_by_id($user_info['u_branch_id']);
$ex_category='5'; //For Fund Transfer
$expense_history = get_all_expense_history_by_user_id_and_ex_category($user_id,$ex_category);
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
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2><b><img class="img img-thumbnail img-circle" src="assets/img/site_logo.png" width="50" /> <?php echo $WebsiteSiteName; ?> Fund Transfer History</b></h2>
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr/>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default btn-default" style="font-family: monospace;">
                        <div class="panel-heading">
                            <b class="text-primary"><i class="fa fa-info-circle"></i> Expense Category : 
                                <?php 
                                    $ex_cat_info = get_expense_category_info_by_id($ex_category);
                                    echo $ex_cat_info['ec_name'];
                                ?>
                            </b>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed table-hover text-center" id="dataTables-example">
                                    <thead>
                                        <tr class="btn-danger text-center">
                                            <td><b>Sl#</b></td>
                                            <td><b>Transaction Date</b></td>
                                            <td><b>Transfer To</b></td>
                                            <td class="text-right"><b>Amount</b></td>
                                            <td class="text-right"><b>Charge</b></td>
                                            <td class="text-right"><b>Balance</b></td>
                                            <td><b>Status</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i=1;
                                        $total_bdt=0;
                                        foreach ($expense_history as $expense){
                                            $transfer_to=get_user_info_by_id($expense['exp_to_id'])
                                            //$ex_category = get_expense_category_info_by_id($expense['ex_category']);
                                        ?>
                                        <tr>
                                            <td><b><?php echo $i; ?>.</b></td>
                                            <td><b><i class="fa fa-calendar"></i> <?php echo date('d/m/Y',strtotime($expense['ex_date'])); ?></b></td>
                                            <td><b><?php echo $transfer_to['u_userid']; ?></b></td>
                                            <td class="text-right"><b><?php echo number_format($expense['ex_amount'],2); ?></b></td>
                                            <td class="text-right"><b><?php echo number_format($expense['ex_charge'],2); ?></b></td>
                                            <td class="text-right"><b><?php echo number_format($expense['ex_amount']+$expense['ex_charge'],2); ?></b></td>
                                            <td><b><?php if($expense['ex_status']==1){ echo '<span class="label label-success">Success</span>';} else{ echo '<span class="label label-danger">Canceled</span>'; } ?></b></td>
                                        </tr>
                                        <?php 
                                        $total_bdt=$total_bdt+$expense['ex_amount']+$expense['ex_charge'];
                                        $i++; } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="btn-danger text-center">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <h2 class="text-center"><b>Total Expense : <?php echo number_format($total_bdt,2); ?> BDT</b></h2>
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
