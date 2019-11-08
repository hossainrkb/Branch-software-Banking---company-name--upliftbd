<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Invoice';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);
if(isset($_REQUEST['ref_id'])){
    $order_id=$_REQUEST['ref_id'];
    $order = get_users_order_by_id($order_id);
}
$order_emp = get_employee_info_by_id($order['uo_employee_id']);
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
                        <h2><b><i class="fa fa-list-alt"></i> Invoice Details</b></h2>
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
                <div class="row">
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default btn-default text-center">
                            <div class="panel-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left" colspan="2"><i class="fa fa-info-circle"></i> <b>Order Details</b></td>
                                        </tr>
                                    </thead>
                                <tbody>
                                  <tr>
                                    <td class="text-left">              
                                        <b>Order ID # :</b> <?php echo $order['uo_order_id'];?><br>
                                        <b>Order Date :</b> <i class="fa fa-calendar"></i> <?php echo date('d/m/Y',strtotime($order['uo_order_date'])); ?> <i class="fa fa-clock-o"></i> <?php echo date('h:i:sA',strtotime($order['uo_order_time'])); ?>
                                    </td>
                                    <td class="text-left">              
                                        <b>Payment Method :</b> Cash<br>
                                        <b>Shipping Method :</b> Standard              
                                    </td>
                                  </tr>
                                </tbody>
                          </table>
                                
                             <table class="table table-bordered table-hover">
                                <?php 
                                    $user_info=get_user_info_by_id($order['uo_customer_id']);
                                    if($user_info){
                                        $user_br_info = get_branch_info_by_id($user_info['u_branch_id']);
                                        $customer_u_id=$user_info['u_userid'];
                                        $customer_name=$user_info['u_name'];
                                        $customer_mobile=$user_info['u_contact'];
                                        $customer_branch=$user_br_info['br_name'].' ('.$user_br_info['br_code'].')';
                                    }else{
                                        $customer_u_id='N/A';
                                        $customer_branch='N/A';
                                        $customer_name=$order['uo_customer_name'];
                                        $customer_mobile=$order['uo_customer_mobile'];
                                }
                                ?>
                                <thead>
                                    <tr class="text-left">
                                        <td colspan="7">
                                            <b><i class="fa fa-user"></i> Customer / Member Information</b>
                                        </td>
                                    </tr>
                                </thead>
                            <tbody>
                                <tr>
                                    <td class="text-right"><b>Member ID :</b></td>
                                    <td class="text-left"><b><?php echo $customer_u_id; ?></b></td>
                                    <td class="text-right"><b>Branch Name :</b></td>
                                    <td class="text-left"><b><?php echo $customer_branch; ?></b></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><b>Name :</b></td>
                                    <td class="text-left"><b><?php echo $customer_name; ?></b></td>
                                    <td class="text-right"><b>Mobile Number :</b></td>
                                    <td class="text-left"><b><?php echo $customer_mobile; ?></b></td>
                                </tr>
                            </tbody>
                        </table>  
                      <table class="table table-bordered text-left">
                          <thead>
                            <tr>
                                <td class="text-left" colspan="6"><i class="fa fa-info-circle"></i> <b>Order Details</b></td>
                            </tr>
                            <tr>
                                <th>SL</th>
                                <th>Product Name</th>
                                <th class="text-center">PV</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-right">Unit Price</th>
                                <th class="text-right">Total Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            $product_ids =  explode(",",$order['uo_product_ids']);
                            $product_quantities =  explode(",",$order['uo_product_quantities']);
                            $product_unit_prices =  explode(",",$order['uo_product_unit_prices']);
                            $product_pvs =  explode(",",$order['uo_total_pvs']);
                            $total_amount = 0;
                            $total_pvs=0;
                            foreach($product_ids as $product_id){
                            $product_info = get_product_info_by_id($product_id);
                            ?>
                                    <tr>
                                        <td><b><?php echo $i; ?>.</b></td>
                                        <td class="text-left"><b><?php echo $product_info['pi_code'].'-'.$product_info['pi_name']; ?></b></td>
                                        <td class="text-center"><b><?php echo $product_pvs[$i-1]; ?></b></td>
                                        <td class="text-center">
                                            <b><?php echo $product_quantities[$i-1]; ?></b>
                                        </td>

                                        <td class="text-right">
                                            <b><?php echo number_format($product_unit_prices[$i-1],2); ?></b>
                                        </td>

                                        <td class="text-right">
                                            <b><?php echo number_format($product_quantities[$i-1]*$product_unit_prices[$i-1],2); ?></b>
                                            <?php $total_amount += $product_quantities[$i-1]*$product_unit_prices[$i-1]; ?>
                                        </td>
                                    </tr>
                                <?php
                                $product_pv=$product_pvs[$i-1]*$product_quantities[$i-1];
                                $total_pvs=$total_pvs+$product_pv;
                                $i++;
                            }
                            ?>
                            </tbody>   
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="5"><b>Total Product Value :</b></td>
                                    <td class="text-right"><b><?php echo number_format($total_pvs,2);; ?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><b>Total Amount (BDT) :</b></td>
                                    <td class="text-right">
                                        <b><?php echo number_format($total_amount,2); ?></b>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                                <?php if($order_emp){ ?>
                                <table class="table table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <td class="text-left" colspan="2"><b><i class="fa fa-info-circle"></i> Order By</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                          <td class="text-left">
                                              <b>Employee ID : <a href="employee_info.php?emp_id=<?php echo $order_emp['e_id'];?>" target="_blank"><b><?php echo $order_emp['e_userid'];?></b></a></b>
                                          </td>
                                          <td class="text-left">
                                              <b>Employee Name : <?php echo $order_emp['e_name']; ?></b>
                                          </td>
                                      </tr>
                                    </tbody>
                                </table>
                                <?php } ?>
                                
                                <table class="table table-bordered table-hover">
                                    <thead>
                                      <tr>
                                          <td class="text-left"><b>Order Comments</b></td>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td class="text-left">No Comments</td>
                                      </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                               <a class="btn pull-left" href="sell_history.php"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                               <a class="btn pull-right" onClick="window.open('order_details.php?txnId=<?php echo $order_id;?>','SearchTip','width=700,height=650,resizable=yes,scrollbars=yes')">
                                                    <b><i class="fa fa-print"></i> Print Preview</b>
                                                </a>
                                            </td>
                                        </tr>
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
                $('#support').dataTable();
            });
    </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
