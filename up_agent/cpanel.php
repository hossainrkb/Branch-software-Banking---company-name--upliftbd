<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
$pageName = 'Branch Deshboard';
include './includes/functions.php';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);
$ecn_status='2';
$hot_news = get_newsletter_by_status($ecn_status);
$found="";
$not_found="";
if(isset($_REQUEST['member'])){
    $m_id=$_REQUEST['member'];
    $m_contact=$_REQUEST['member'];
    $search_mem= search_member_by_id_or_contact($m_id, $m_contact);
    if($search_mem){
        $found='MEMBER FOUND';
    }
 else {
    $not_found='NOT FOUND';    
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
    <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
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
                    <div class="col-md-12 text-center">
                        <h2 style="font-family: Showcard Gothic;"><b><i class="fa fa-dashboard fa-2x"></i> Agent Dashboard</b></h2>   
                        <h5><b style="color: red;">Welcome <?php echo $branch_info['br_name'].' ('.$branch_info['br_code'].')'; ?> Agent, Love to see you back. Today <?php echo date("d F Y l"); ?></b></h5>
                        <hr/>
                        <div>
                            <marquee>
                                <?php 
                                foreach ($hot_news as $news){
                                ?>
                                <a style="text-decoration: none;" href=""><b><?php echo $news['ecn_body']; ?></b></a>
                                <?php } ?>
                            </marquee>
                        </div>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                <hr />
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="panel-info btn-default">
                            <div class="panel-heading main-text">SEARCH MEMBER</div>
                            <div class="panel-body">
                                <?php 
                            if($found){
                            ?>
                        <span  style="font-family: monospace"><?php echo $found; ?> <a class="text-primary" href="cpanel.php"><b>SEARCH ANOTHER ONE!</b></a></span>
                        <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="panel panel-body panel-info">
                            <table class="table table-condensed table-hover table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <td><b>MEMBER ID</b></td>
                                        <td><b>NAME</b></td>
                                        <td><b>ACTION</b></td>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td><?php echo $search_mem['u_userid'];?></td>
                                        <td><?php echo $search_mem['u_name'];?></td>
                                        <td><a target=”_blank” href="member_info.php?m_id=<?php echo $search_mem['u_id'];?>">VIEW DETAILS</a></td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                            <div class="col-md-2"></div>
                        </div>
                           <?php
                            }
                                elseif ($not_found) {
                                ?>
                            <span><b><?php echo '<span class="text-danger">'.$not_found.'</span>'; ?> <a class="text-primary" href="cpanel.php">Try Again.</b></a></span>
                            <?php }
                            else {
                                ?>
                        <div class="col-md-4 text-right">
                            <div class="text-box" >
                                <span class="main-text text-info">Member ID</span>
                            </div>
                        </div>
                        <form method="post">
                            <div class="col-md-6 ">
                                <div class="form-group input-group">
                                        <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                    <input type="text" name="member" class="form-control" required="">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-example-int">
                                    <button class="btn btn-success  btn-info"><b>SEARCH</b></button>
                                </div>
                            </div>
                            </form>
                        <div class="col-md-1"></div>
                            </div>
                            <div class="panel-footer "></div>
                        </div>
                    </div>
                </div>
                            <?php }?>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default btn-default">
                            <div class="panel-body">
                                <h2 class="text-center"><b>Today's History</b></h2>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="panel panel-primary text-center no-boder bg-color-green">
                                <div class="panel-body">
                                    <i class="fa fa-bank fa-5x"></i>
                                    <h3><b></b></h3>
                                </div>
                                <div class="panel-footer back-footer-green">
                                    <a class="btn btn-success btn-block disabled" href="mbanking.php" ><b>Banking</b></a>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="panel panel-primary text-center no-boder bg-color-red">
                                <div class="panel-body">
                                    <i class="fa fa-mobile fa-5x"></i>
                                    <h3><b></b></h3>
                                </div>
                                <div class="panel-footer back-footer-red">
                                    <a class="btn btn-danger btn-block disabled" href="" ><b>Product Buy</b></a>
                                </div>
                           </div> 
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="panel panel-primary text-center no-boder bg-color-green">
                                <div class="panel-body">
                                    <i class="fa fa-money fa-5x"></i>
                                    <h3></h3>
                                </div>
                                <div class="panel-footer back-footer-green">
                                    <a class="btn btn-success btn-block" href="branch_deposit.php?today" ><b>All Deposit</b></a>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="panel panel-primary text-center no-boder bg-color-red">
                                <div class="panel-body">
                                    <i class="fa fa-money fa-5x"></i>
                                    <h3><b></b></h3>
                                </div>
                                <div class="panel-footer back-footer-red">
                                    <a class="btn btn-danger btn-block" href="branch_expense.php" ><b>All Expense</b></a>
                                </div>
                            </div> 
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <!-- /. ROW  -->
                <hr />                
                 <!-- /. ROW  -->
                <div class="row" >
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-default btn-default">
                            <div class="panel-body">
                                <h1 class="text-center text-primary"><b>Total Deposit Report</b></h1>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-center">
                                        <thead>
                                            <tr class="btn-danger">
                                                <td><b>SL#</b></td>
                                                <td><b>DEPOSIT CATEGORY</b></td>
                                                <td class="text-right"><b>AMOUNT(BDT)</b></td>
                                                <td><b>ACTION</b></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;
                                            $total_dep_amount = 0;
                                            $deposit_category= get_all_deposit_category();
                                            foreach ($deposit_category as $deposit_cat){
                                                $dep_amount = 0;
                                                $user_deposit_history = get_branch_deposit_history_by_branch_id_and_dep_category($branch_id, $deposit_cat['dc_id']);
                                                foreach ($user_deposit_history as $user_deposit){
                                                    $dep_amount=$dep_amount+$user_deposit['bc_amount'];
                                                }
                                            ?>
                                            <tr>
                                                <td><b><?php echo $i; ?>.</b></td>
                                                <td class="text-left"><b><?php echo $deposit_cat['dc_name'].' ('. count($user_deposit_history).')'; ?></b></td>
                                                <td class="text-right"><b><?php echo number_format($dep_amount,2); ?>/=</b></td>
                                                <td><a href="branch_deposit.php?dep_cat=<?php echo $deposit_cat['dc_id']; ?>"><b>[ View All ]</b></a></td>
                                            </tr>
                                            <?php 
                                            $i++ ; 
                                            $total_dep_amount=$total_dep_amount+$dep_amount;
                                            } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">
                                                    <h3><b class="text-primary">Total Deposit Amount : <?php echo number_format($total_dep_amount,2); ?> /=</b></h3>
                                                </td>
                                            </tr>
                                            <tr class="btn-danger">
                                                <td colspan="4"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    <div class="panel panel-default btn-default">
                        <div class="panel-body">
                            <h1 class="text-center text-primary"><b>Total Expense Report</b></h1>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover text-center">
                                    <thead>
                                        <tr class="btn-danger">
                                            <td><b>SL#</b></td>
                                            <td><b>EXPENSE CATEGORY</b></td>
                                            <td class="text-right"><b>AMOUNT(BDT)</b></td>
                                            <td><b>ACTION</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i=1;
                                        $total_expence_amount = 0;
                                        $expense_category= get_all_expense_category();
                                        foreach ($expense_category as $expense_cat){
                                            $expence_amount = 0;
                                            $user_expense_history = get_branch_expense_history_by_branch_id_and_ex_category($branch_id, $expense_cat['ec_id']);
                                            foreach ($user_expense_history as $user_expense){
                                                $expence_amount=$expence_amount+$user_expense['bex_amount']+$user_expense['bex_charge'];
                                            }
                                        ?>
                                        <tr>
                                            <td><b><?php echo $i; ?>.</b></td>
                                            <td class="text-left"><b><?php echo $expense_cat['ec_name'].' ('. count($user_expense_history).')'; ?></b></td>
                                            <td class="text-right"><b><?php echo number_format($expence_amount,2); ?>/=</b></td>
                                            <td><a href="branch_expense.php?ex_cat=<?php echo $expense_cat['ec_id']; ?>"><b>[ View All ]</b></a></td>
                                        </tr>
                                        <?php 
                                        $i++ ; 
                                        $total_expence_amount=$total_expence_amount+$expence_amount;
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <h3><b class="text-primary">Total Expense Amount : <?php echo number_format($total_expence_amount,2); ?> /=</b></h3>
                                            </td>
                                        </tr>
                                        <tr class="btn-danger">
                                            <td colspan="4"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                        
                        
                    
                    </div>
                </div>
                 <!-- /. ROW  -->
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
     <!-- MORRIS CHART SCRIPTS -->
     <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>