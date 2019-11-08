<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Checkout';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);
$messages="";

if(isset($_POST['checkout'])){
    $customer_mobile=$_POST['customer_mobile'];
    $user_info=get_user_info_by_uid_or_contact($customer_mobile);
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
                        <h2>
                            <b><i class="fa fa-shopping-cart"></i> Checkout - <?php echo $branch_info['br_name'].' ('.$branch_info['br_code'].')'; ?></b>
                            <a class="btn pull-right text-danger" href="shopping_cart.php"><b><i class="fa fa-reply-all"></i> Back</b></a>
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
                                    <form action="confirm_order.php" method="post">
                                        <?php 
                                            if($user_info){
                                                $user_br_info = get_branch_info_by_id($user_info['u_branch_id']);
                                                $customer_id=$user_info['u_id'];
                                                $customer_u_id=$user_info['u_userid'];
                                                $customer_name=$user_info['u_name'];
                                                $customer_mobile=$user_info['u_contact'];
                                                $customer_branch=$user_br_info['br_name'].' ('.$user_br_info['br_code'].')';
                                            }else{
                                                $customer_id='0';
                                                $customer_u_id='N/A';
                                                $customer_branch='N/A';
                                                $customer_name=$_POST['customer_name'];
                                                $customer_mobile=$_POST['customer_mobile'];
                                        }
                                        ?>
                                        <h1 class="text-center text-danger"><b>Order Review</b></h1>
                                        <table class="table table-striped table-bordered table-condensed table-hover text-center">
                                                <thead>
                                                    <tr class="btn-danger text-left">
                                                        <td colspan="7">
                                                            <b><i class="fa fa-user"></i> Customer's Information</b>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-right"><b>Customer ID :</b></td>
                                                    <td class="text-left"><b><?php echo $customer_u_id; ?></b></td>
                                                    <td class="text-right"><b>Branch Name :</b></td>
                                                    <td class="text-left"><b><?php echo $customer_branch; ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><b>Customer Name :</b></td>
                                                    <td class="text-left"><b><?php echo $customer_name; ?></b></td>
                                                    <td class="text-right"><b>Mobile Number :</b></td>
                                                    <td class="text-left"><b><?php echo $customer_mobile; ?></b></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr class="btn-danger">
                                                    <td class="text-right" colspan="4"></td>
                                                </tr>
                                            </tfoot>
                                        </table>  
                                    <table class="table table-striped table-bordered table-condensed table-hover text-center">
                                        <thead>
                                            <tr class="btn-danger text-left">
                                                <td colspan="7">
                                                    <b><i class="fa fa-shopping-cart"></i> Order Details</b>
                                                </td>
                                            </tr>
                                            <tr class="btn-danger text-left">
                                                <td><b>Sl#</b></td>
                                                <td><b>Product Code & Name</b></td>
                                                <td class="text-center"><b>PV</b></td>
                                                <td class="text-center"><b>Qty.</b></td>
                                                <td class="text-right"><b>Unit Price</b></td>
                                                <td class="text-right"><b>Total Price</b></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $order_process = get_order_process_info_by_branch_id($branch_id);
                                            if(count($order_process)>0){
                                            $i=1;  
                                            $total_pvs=0;
                                            $total_amount=0;
                                            foreach ($order_process as $order){
                                                $br_product=get_branch_product_info_by_id($order['op_pi_id']);
                                                $pro_info= ebijoy_get_product_info_by_id($br_product['bp_product']);
                                            ?>
                                            <tr>
                                                <td><b><?php echo $i;?>.</b></td>
                                                <td class="text-left"><?php echo $pro_info['pi_code'].'-'.$pro_info['pi_name']; ?></td>
                                                <td><?php echo $pro_info['pi_point']; ?> </td>
                                                <td class="text-center"><?php echo $order['op_pi_qty']; ?></td>
                                                <td class="text-right"><?php echo number_format($pro_info['pi_sell_price'],2); ?> </td>
                                                <td class="text-right"><?php $sub_total=$pro_info['pi_sell_price']*$order['op_pi_qty']; echo number_format($sub_total,2); ?> </td>
                                            </tr>
                                            <?php 
                                            $product_pv=$pro_info['pi_point']*$order['op_pi_qty'];
                                            $total_pvs=$total_pvs+$product_pv;
                                            $total_amount=$total_amount+$sub_total;
                                            $i++;
                                            } }
                                            ?>  
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" colspan="5"><b>Total Product Value :</b></td>
                                                <td class="text-right"><b><?php echo $total_pvs; ?> PV</b></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" colspan="5"><b>Total Amount (BDT) :</b></td>
                                                <td class="text-right"><b><?php echo number_format($total_amount,2); ?></b></td>
                                            </tr>
                                            <tr class="btn-danger">
                                                <td class="text-right" colspan="6"></td>
                                            </tr>
                                            
                                            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" required="" />
                                            <input type="hidden" name="customer_name" value="<?php echo $customer_name; ?>" required="" />
                                            <input type="hidden" name="customer_mobile" value="<?php echo $customer_mobile; ?>" required="" />
                                            <input type="hidden" name="uo_order_id" value="<?php echo "BO".$branch_id.time(); ?>" required="" />
                                            <input type="hidden" name="total_pvs" value="<?php echo $total_pvs; ?>" required="" />
                                            <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>" required="" />
                                            <tr>
                                                <td colspan="6">
                                                    <a class="btn btn-danger pull-left" href="shopping_cart.php"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                                    <label class="checkbox-inline btn text-center">
                                                        <input type="checkbox" required="" /> <b class="text-danger">Order Confirmation</b>
                                                    </label>
                                                    <b><input class="btn btn-danger pull-right" type="submit" name="confirm_order" value="Confirm Order" /></b>
                                                </td>
                                                <tr class="btn-danger">
                                                    <td colspan="6"></td>
                                                </tr>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </form>
                                        
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

