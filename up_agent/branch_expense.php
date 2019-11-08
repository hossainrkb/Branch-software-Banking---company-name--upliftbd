<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
$pageName = 'Branch Expense';
include './includes/functions.php';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);

if(isset($_GET['ex_cat'])){
    $ex_category=$_GET['ex_cat'];
    $expense_history = get_branch_expense_history_by_branch_id_and_ex_category($branch_id,$ex_category);
}else{
    $expense_history = get_branch_expense_history_by_branch_id($branch_id);
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
                        <h2><b><i class="fa fa-history"></i> Agent Expense History</b></h2>
                        <a class="btn" href="branch_expense.php"><b>All Expense</b></a>|
                        <?php 
                            $expense_category=get_all_expense_category();
                            foreach ($expense_category as $expense_cat){
                            ?>
                            <a class="btn" href="branch_expense.php?ex_cat=<?php echo $expense_cat['ec_id']; ?>"><b><?php echo $expense_cat['ec_name']; ?></b></a>|
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
                            <b class="text-primary"><i class="fa fa-info-circle"></i> Expense Category : 
                                <?php 
                                if(isset($_GET['ex_cat'])){
                                    $ex_cat_info = get_expense_category_info_by_id($_GET['ex_cat']);
                                    echo $ex_cat_info['ec_name'];
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
                                            <td><b>Sl#</b></td>
                                            <td><b>Transaction Date</b></td>
                                            <td><b>Expense Category</b></td>
                                            <td class="text-right"><b>Amount</b></td>
                                            <td class="text-right"><b>Charge</b></td>
                                            <td class="text-right"><b>Balance</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i=1;
                                        $total_bdt=0;
                                        foreach ($expense_history as $expense){
                                            $ex_category = get_expense_category_info_by_id($expense['bex_category']);
                                        ?>
                                        <tr>
                                            <td><b><?php echo $i; ?>.</b></td>
                                            <td><b><i class="fa fa-calendar"></i> <?php echo date('d/m/Y',strtotime($expense['bex_date'])); ?></td>
                                            <td><b><?php echo $ex_category['ec_name']; ?></b></h5></td>
                                            <td class="text-right"><b><?php echo number_format($expense['bex_amount'],2); ?></b></td>
                                            <td class="text-right"><b><?php echo number_format($expense['bex_charge'],2); ?></b></td>
                                            <td class="text-right"><b><?php echo number_format($expense['bex_amount']+$expense['bex_charge'],2); ?></b></td>
                                        </tr>
                                        <?php 
                                        $total_bdt=$total_bdt+$expense['bex_amount']+$expense['bex_charge'];
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
