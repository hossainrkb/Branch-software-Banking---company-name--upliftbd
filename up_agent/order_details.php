<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);
if(isset($_REQUEST['txnId'])){
    $order_id=$_REQUEST['txnId'];
    $order = get_order_details_by_order_nd_branch_id($order_id,$branch_id);
}
$pvs_history = get_users_pv_pin_by_order_nd_branch_id($order_id,$branch_id);
$order_emp = get_employee_info_by_id($order['uo_employee_id']);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo 'Invoice_'.$order['uo_order_id']; ?></title>
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
                        <h5><b>BRANCH : <?php echo $branch_info['br_name'].' ('.$branch_info['br_code'].')'; ?></b></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default text-center">
                            <div class="panel-body">
                                <table class="table table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <td class="text-left" colspan="2"><b><i class="fa fa-info-circle"></i> Order Details</b></td>
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
                                <table class="table table-condensed table-bordered">
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
                                <table class="table table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="6"><i class="fa fa-info-circle"></i> Purchase Product Information</th>
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
                                              <td class="text-right" colspan="5"><b>Total PV :</b></td>
                                              <td class="text-right"><b><?php echo number_format($total_pvs,2); ?></b></td>
                                          </tr>
                                          <tr>
                                              <td colspan="5" class="text-right"><b>Total Amount (BDT) :</b></td>
                                              <td class="text-right">
                                                  <b><?php echo number_format($total_amount,2); ?></b>
                                              </td>
                                          </tr>
                                      </tfoot>
                                </table>
                                <?php if(!$order_emp){ ?>
                                <table class="table table-bordered table-condensed text-center">
                                    <thead>
                                        <tr>
                                            <th colspan="6"><i class="fa fa-info-circle"></i> Product PV Pin(s)</th>
                                        </tr>
                                      <tr>
                                          <td><b>SL</b></td>
                                          <td><b>Product Pin</b></td>
                                          <td><b>PV Value</b></td>
                                      </tr>
                                      </thead>
                                    <tbody>
                                        <?php 
                                        $j=1;
                                        foreach ($pvs_history as $pvs_info){
                                        ?>
                                        <tr>
                                            <td><b><?php echo $j; ?>.</b></td>
                                            <td><b><?php echo $pvs_info['upv_pin']; ?></b></td>
                                            <td><b><?php echo $pvs_info['upv_value']; ?></b></td>
                                        </tr>
                                        <?php $j++; } ?>
                                    </tbody>
                                </table>
                                <?php } ?>
                                
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
                                              <b>Employee ID : <?php echo $order_emp['e_userid']; ?></b>
                                          </td>
                                          <td class="text-left">
                                              <b>Employee Name : <?php echo $order_emp['e_name']; ?></b>
                                          </td>
                                      </tr>
                                    </tbody>
                                </table>
                                <?php } ?>
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <td class="text-left">
                                                <br />
                                                <h5><b>Branch Admin Sign</b></h5>
                                            </td>
                                            <td class="text-right">
                                                <br />
                                                <h5><b>Authority Sign</b></h5>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!--End Advanced Tables -->
                    </div>
                </div>
                <!-- /. ROW  -->
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
