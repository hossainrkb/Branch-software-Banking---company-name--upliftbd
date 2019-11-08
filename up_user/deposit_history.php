<?php
session_start();
if(!isset($_SESSION['user'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Deposit History';
$user_id = $_SESSION['user']['u_id'];
$user_info = get_user_info_by_id($user_id);
$user_branch=get_branch_info_by_id($user_info['u_branch_id']);
if(isset($_GET['dep_cat'])){
    $dep_category=$_GET['dep_cat'];
    $deposit_history = get_all_deposit_history_by_user_id_and_dep_category($user_id,$dep_category);
}else{
    $deposit_history = get_all_deposit_history_by_user_id($user_id);
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
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2><b><i class="fa fa-history"></i> Deposit History</b></h2>
                        <a class="btn" href="deposit_history.php"><b>All Deposit</b></a>|
                        <?php 
                            $deposit_category=get_all_deposit_category();
                            foreach ($deposit_category as $deposit_cat){
                            ?>
                            <a class="btn" href="deposit_history.php?dep_cat=<?php echo $deposit_cat['dc_id']; ?>"><b><?php echo $deposit_cat['dc_name']; ?></b></a>|
                        <?php } ?>
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr/>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default btn-default" style="font-family: monospace;">
                        <div class="panel-heading">
                            <b class="text-primary"><i class="fa fa-info-circle"></i> Category:<?php 
                                if(isset($_GET['dep_cat'])){
                                    $dep_cat_info = get_deposit_category_info_by_id($_GET['dep_cat']);
                                    echo $dep_cat_info['dc_name'];
                                }else {
                                    echo 'All';
                                }
                                ?>
                            </b>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed table-hover text-center" id="dataTables-example">
                                    <thead>
                                        <tr class="btn-danger text-center">
                                            <td><b>SL</b></td>
                                            <td><b>DATE</b></td>
                                            <td><b>DEPOSIT CATEGORY</b></td>
                                            <td class="text-right"><b>AMOUNT</b></td>
                                            <td><b>MEMBER</b></td>
                                            <td><b>STATUS</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i=1;
                                        $total_bdt=0;
                                        foreach ($deposit_history as $deposit){
                                            $member_info = get_user_info_by_id($deposit['dep_from_id']);
                                            $d_category = get_deposit_category_info_by_id($deposit['dep_category']);
                                        ?>
                                        <tr>
                                            <td><b><?php echo $i; ?>.</b></td>
                                            <td><b><?php echo date('d/m/Y',strtotime($deposit['dep_date'])); ?></td>
                                            <td><b><?php echo $d_category['dc_name']; ?></b></td>
                                            <td class="text-right"><b><?php $u_balance=$deposit['dep_amount']; echo number_format($u_balance,2); ?></b></td>
                                            <td><b><?php if($member_info){ echo $member_info['u_userid'];}else{ echo 'N/A';} ?></b></td>
                                            <td><b><?php if($deposit['dep_status']==1){ echo '<span class="label label-success">Success</span>';} else{ echo '<span class="label label-danger">Canceled</span>'; } ?></b></td>
                                        </tr>
                                        <?php 
                                        $total_bdt=$total_bdt+$deposit['dep_amount'];
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
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <h2 class="text-center"><b>Total:<?php echo number_format($total_bdt,2); ?>BDT</b></h2>
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
