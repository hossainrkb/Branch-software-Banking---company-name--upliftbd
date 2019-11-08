<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Order Confirmation';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);
$branch_code = $branch_info['br_code'];
$messages="";
if(isset($_POST['confirm_order'])){
    $uo_order_id = $_POST['uo_order_id'];
    $uo_total_amount = $_POST['total_amount'];
    $total_pvs = $_POST['total_pvs'];
    $uo_branch_id=$branch_id;
    $uo_employee_id='0';
    $uo_customer_id=$_POST['customer_id'];
    $uo_customer_name=$_POST['customer_name'];
    $uo_customer_mobile=$_POST['customer_mobile'];
    $order_process = get_order_process_info_by_branch_id($branch_id);
    $uo_product_ids = "";
    $uo_product_quantities = "";
    $uo_product_unit_prices = "";
    $uo_product_pvs="";
    $sell_commission='0';
    $check = 0;
    foreach($order_process as $product){
        $br_product=get_branch_product_info_by_id($product['op_pi_id']);
        $pro_info= ebijoy_get_product_info_by_id($br_product['bp_product']);
        if($check == 0){
            $uo_product_ids .= $pro_info['pi_id'];
            $uo_product_quantities .= $product['op_pi_qty'];
            $uo_product_unit_prices .= $pro_info['pi_sell_price']; 
            $uo_product_pvs .= $pro_info['pi_point']; 
            $check = 1;
        }else{
            $uo_product_ids .= ",".$pro_info['pi_id'];
            $uo_product_quantities .= ",".$product['op_pi_qty'];
            $uo_product_unit_prices .= ",".$pro_info['pi_sell_price'];
            $uo_product_pvs .= ",".$pro_info['pi_point'];
        }
    }
    
    if($branch_info['br_ref_member']=='0'){
        $isOrderPlaced = setOrder($uo_order_id,$uo_branch_id,$uo_employee_id,$uo_customer_id,$uo_customer_name,$uo_customer_mobile,$uo_product_ids,$uo_product_quantities,$uo_product_unit_prices,$uo_product_pvs,$uo_total_amount,$sell_commission);
        if($isOrderPlaced){
            $order_info=get_user_order_by_order_id($uo_order_id);
            if($total_pvs>100){
                //$remainder=$total_pvs%100;
                $remainder = fmod($total_pvs,100);
                if($remainder!=0){
                    $pv_value=$remainder;
                    $upv_pin= 'P'.generatePIN(4).$branch_id.generatePIN(4);
                    $add_pvs=add_users_pv_pin($upv_pin,$pv_value,$branch_id,$order_info['uo_id']);
                }
                $rem_pvs=$total_pvs-$remainder;
                $div=$rem_pvs/100;
                for($i=1;$i<=$div;$i++){
                    $total_pvs='100';
                    $upv_pin= 'P'.generatePIN(4).$branch_id.generatePIN(4);
                    $add_pvs=add_users_pv_pin($upv_pin,$total_pvs,$branch_id,$order_info['uo_id']);
                }
            }else{
                $upv_pin= 'P'.generatePIN(4).$branch_id.generatePIN(4);
                $add_pvs=add_users_pv_pin($upv_pin,$total_pvs,$branch_id,$order_info['uo_id']);
            }
        }
    }else{
        $sell_commission=($uo_total_amount*0.02);
        $isOrderPlaced = setOrder($uo_order_id,$uo_branch_id,$uo_employee_id,$uo_customer_id,$uo_customer_name,$uo_customer_mobile,$uo_product_ids,$uo_product_quantities,$uo_product_unit_prices,$uo_product_pvs,$uo_total_amount,$sell_commission);
        if($isOrderPlaced){
            $order_info=get_user_order_by_order_id($uo_order_id);
            $user_sell_commission=add_users_branch_sell_commission($branch_info['br_ref_member'],$branch_id,$sell_commission);
            if($user_sell_commission){
                $update_user_balance=update_user_balance_plus($branch_info['br_ref_member'],$sell_commission);
            }
            if($total_pvs>100){
                //$remainder=$total_pvs%100;
                $remainder = fmod($total_pvs,100);
                if($remainder!=0){
                    $pv_value=$remainder;
                    $upv_pin= 'P'.generatePIN(4).$branch_id.generatePIN(4);
                    $add_pvs=add_users_pv_pin($upv_pin,$pv_value,$branch_id,$order_info['uo_id']);
                }
                $rem_pvs=$total_pvs-$remainder;
                $div=$rem_pvs/100;
                for($i=1;$i<=$div;$i++){
                    $total_pvs='100';
                    $upv_pin= 'P'.generatePIN(4).$branch_id.generatePIN(4);
                    $add_pvs=add_users_pv_pin($upv_pin,$total_pvs,$branch_id,$order_info['uo_id']);
                }
            }else{
                $upv_pin= 'P'.generatePIN(4).$branch_id.generatePIN(4);
                $add_pvs=add_users_pv_pin($upv_pin,$total_pvs,$branch_id,$order_info['uo_id']);
            }
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
    <!-- BOOTSTRAP SELECT-->
    <link href="assets/css/bootstrap-select.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
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
                    <div class="col-md-12">
                        <h2 class="text-primary">
                            <b><i class="fa fa-shopping-cart"></i> Order Confirmation - <?php echo $branch_info['br_name'].' ('.$branch_info['br_code'].')'; ?></b>
                            <a class="btn pull-right text-primary" href="shopping_cart.php"><b><i class="fa fa-reply-all"></i> Back</b></a>
                        </h2> 
                    </div>
                </div>
                 <!-- /. ROW  -->
                <hr />
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default btn-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                  <?php
                                    if($isOrderPlaced){
                                        $clear_shopping_cart = clear_branch_shopping_cart($branch_id);
                                        $order=get_users_order_info_by_branch_nd_order_id($branch_id,$uo_order_id);
                                    ?>
                                    <h2><b>Order Placed Successful,Order ID : <a href="invoice.php?ref_id=<?php echo $order['uo_id']; ?>"><?php echo $uo_order_id;?></a></b></h2>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Advanced Tables -->
                                            <div class="panel panel-default btn-default text-center">
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <td class="text-left" colspan="2"><b>Order Details</b></td>
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
                                          <table class="table table-bordered text-left">
                                              <thead>
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
                                                        <td class="text-right"><b><?php echo $total_pvs; ?> PV</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" class="text-right"><b>Total Amount (BDT) :</b></td>
                                                        <td class="text-right">
                                                            <b><?php echo number_format($total_amount,2); ?></b>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
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
                                                                   <a class="btn pull-left" href="sell_history.php"><b><i class="fa fa-eye"></i> Sell History</b></a>
                                                                   <a class="btn pull-right" onClick="window.open('order_details.php?txnId=<?php echo $order['uo_id'];?>','SearchTip','width=700,height=650,resizable=yes,scrollbars=yes')">
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
                                    <?php
                                     if($isOrderPlaced){
                                        //$sms_token = "c7236d9be5aa469ecd1ddae8e25d0856"; //teletalk
                                        $to=$uo_customer_mobile;
                                        $sms_message = "Dear $uo_customer_name,\nYour Order Info.\nOrder ID:$uo_order_id\nAmount:$uo_total_amount BDT\nTotal Value:$total_pvs PV\nBranch:$branch_code\n@$webUrl";
                                        $sms_url = "http://api.smscpanel.net/api.php";
                                        $sms_data= array(
                                        'to'=>"$to",
                                        'message'=>"$sms_message",
                                        'token'=>"$sms_token"
                                        ); // Add parameters in key value
                                        $chr = curl_init(); // Initialize cURL
                                        curl_setopt($chr,CURLOPT_URL,$sms_url);
                                        curl_setopt($chr,CURLOPT_POSTFIELDS, http_build_query($sms_data));
                                        curl_setopt($chr,CURLOPT_RETURNTRANSFER, true);
                                        $smsresult = curl_exec($chr);
                                        if($smsresult){
                                            $sms_sent.="Message Sent Successfully";
                                        }
                                        else{
                                           $sms_sent.='Message Sent Failed';
                                        }
                                     }
                                    }else{ ?>
                                    <h2 class="text-center"><b>Something is wrong,Please Try Again.</b></h2>
                                    <?php 
                                    }
                                    ?>      
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>
                <hr />
        <?php include './footer.php'; ?>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <script type="text/javascript">
    $(document).ready(function(){
    // this part disables the right click
    $('img').on('contextmenu', function(e){
    return false;
    });
    //this part disables dragging of image
    $('img').on('dragstart', function(e) {
    return false;
    });

    $('body').on('contextmenu', function(e){
    return false;
    });

    });
</script>
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-select.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } } ?>