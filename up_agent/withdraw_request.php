<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
$pageName = 'Withdraw Request';
include './includes/functions.php';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);
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
                        <h2><b><i class="fa fa-history"></i> <?php echo $pageName; ?></b></h2>
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
                                <table class="table table-striped table-bordered table-condensed table-hover text-center" id="withdraw_request">
                                            <thead class="btn-danger">
                                                <tr>
                                                    <td class="text-center" style="font-weight: bold">SL</td>
                                                    <td class="text-center" style="font-weight: bold">TXN DATE</td>
                                                    <td class="text-center" style="font-weight: bold">MEMBER ID</td>
                                                    <td class="text-center" style="font-weight: bold">BRANCH NAME</td>
                                                    <td class="text-right" style="font-weight: bold">AMOUNT</td>      
                                                    <td class="text-center" style="font-weight: bold">STATUS</td>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            <?php 
                                            $withdraw_request = get_all_branch_withdraw_request($branch_id);
                                            if(count($withdraw_request)>0){
                                            $i=1;  
                                            $total_pending=0;
                                            $total_success=0;
                                            foreach ($withdraw_request as $withdraw){
                                            $user_info= get_user_info_by_id($withdraw['uwr_user_id']) ;
                                            $branch_info=get_branch_info_by_id($withdraw['uwr_branch_id']);
                                            ?>
                                            <tr>
                                                <td><b><?php echo $i; ?>.</b></td>
                                                <td><b><i class="fa fa-calendar"></i> <?php echo date('d/m/Y',strtotime($withdraw['uwr_date'])); ?></b></td>
                                                <td><b><a target="_blank" href="member_info.php?m_id=<?php echo $user_info['u_id']; ?>"><?php echo $user_info['u_userid']; ?></a></b></td>
                                                <td><b><?php echo $branch_info['br_name'].' ('.$branch_info['br_code'].')'; ?></b></td>
                                                <td class="text-right"><b><?php echo number_format($withdraw['uwr_amount'],2); ?></b></td>
                                                <td><?php if($withdraw['uwr_status']==2){ $total_pending=$total_pending+$withdraw['uwr_amount']; echo '<span class="label label-danger">Pending</span>';} else if($withdraw['uwr_status']==1){ $total_success=$total_success+$withdraw['uwr_amount']; echo '<span class="label label-success">Success</span>';} else{ echo '<span class="label label-danger">Canceled</span>'; } ?></td>
                                            </tr>
                                        <?php 
                                        $i++; } }
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
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <h2 class="text-center text-danger"><b>Total Pending Withdraw : <?php echo number_format($total_pending,2); ?> BDT</b></h2>
                                    <h2 class="text-center text-success"><b>Total Success Withdraw : <?php echo number_format($total_success,2); ?> BDT</b></h2>
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
                $('#withdraw_request').dataTable();
            });
    </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
