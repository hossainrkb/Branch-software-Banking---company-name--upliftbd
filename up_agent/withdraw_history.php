<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Withdraw history';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);
$withdraw_history = get_all_branch_withdraw($branch_id);
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
                        <h2><b><i class="fa fa-history"></i> Withdraw History</b></h2>
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
                                            <td><b>SL</b></td>
                                            <td><b>DATE</b></td>
                                            <td><b>ADMIN</b></td>
                                            <td><b>Wallet Pin</b></td>
                                            <td class="text-right"><b>AMOUNT</b></td>
                                            <td><b>STATUS</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i=1;
                                        foreach ($withdraw_history as $withdraw){
                                            $admin_info= get_admin_info_by_id($withdraw['awr_admin']);                                            
                                        ?>
                                        <tr>
                                            <td><b><?php echo $i; ?>.</b></td>
                                            <td><b><?php echo date('d/m/Y',strtotime($withdraw['awr_date'])); ?></b></td>
                                            <td><b><?php echo $admin_info['a_name'].' ('.$admin_info['a_email'].')'; ?></b></td>
                                        <td><b><?php echo $withdraw['awr_pin']; ?></b></td>
                                            <td class="text-right"><b><?php echo number_format($withdraw['awr_amount'],2); ?></b></td>
                                            <td><?php if($withdraw['awr_status']==2){ echo '<span class="label label-primary">Pending</span>';} else if($withdraw['awr_status']==1){ echo '<span class="label label-success">Success</span>';} else{ echo '<span class="label label-danger">Canceled</span>'; } ?></td>
                                        </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="btn-danger text-center">
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
