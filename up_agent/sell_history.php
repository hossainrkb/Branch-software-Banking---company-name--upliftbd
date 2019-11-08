<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Sell History';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);
$br_order_history = get_all_branch_order_history($branch_id);
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
                        <h2><b><i class="fa fa-history"></i> Branch Products Sell History</b></h2>
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr/>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default btn-default" style="font-family: monospace;">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed table-hover text-center" id="dataTables-example">
                                    <thead>
                                        <tr class="btn-danger text-center">
                                            <td><b>Sl#</b></td>
                                            <td><b>Date</b></td>
                                            <td><b>Order No</b></td>
                                            <td><b>Mobile No</b></td>
                                            <td><b>PV</b></td>
                                            <td class="text-right"><b>Amount</b></td>
                                            <td><b>Employee</b></td>
                                            <td ><b>Action</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if(count($br_order_history)>0){
                                        $i=1;
                                        $total_bdt=0;
                                        foreach ($br_order_history as $sell_history){
                                            $employee_info=get_employee_info_by_id($sell_history['uo_employee_id']);
                                            $pv_info = get_pvs_info_by_invoice_id($sell_history['uo_id']);
                                            $total_pvs=0;
                                            foreach ($pv_info as $pvs){
                                                $total_pvs=$total_pvs+$pvs['upv_value'];
                                            }
                                        ?>
                                        <tr>
                                            <td><b><?php echo $i;?>.</b></td>
                                            <td><b><?php echo date('d/m/Y',strtotime($sell_history['uo_order_date'])); ?></b></td>
                                            <td><b><?php echo $sell_history['uo_order_id']; ?></b></td>
                                            <td><b><?php echo $sell_history['uo_customer_mobile']; ?></b></td>
                                            <td><b><?php echo number_format($total_pvs,2); ?></b></td>
                                            <td class="text-right"><b><?php echo number_format($sell_history['uo_total_amount'],2); ?></b></td>
                                            <td><a href="employee_info.php?emp_id=<?php echo $employee_info['e_id'];?>" target="_blank"><b><?php echo $employee_info['e_userid'];?></b></a></td>
                                           <td><a href="invoice.php?ref_id=<?php echo $sell_history['uo_id']; ?>"><b>Details</b></a></td>
                                        </tr>
                                        <?php 
                                            $total_bdt=$total_bdt+$sell_history['uo_total_amount'];
                                            $i++; }}
                                        ?>  
                                    </tbody>
                                    <tfoot class="btn-danger">
                                        <tr>
                                            <td></td>
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
                            <h2 class="text-center"><b>Total Sell : <?php echo number_format($total_bdt,2); ?> BDT</b></h2>
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
