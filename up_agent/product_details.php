<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
$pageName = 'Employee Profile';
include './includes/functions.php';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);

if(isset($_GET['bp_id'])){
    $pro_id=$_GET['bp_id'];
    $branch_product_info= get_branch_product_info_by_id($pro_id);
    $get_product_info= ebijoy_get_product_info_by_id($branch_product_info['bp_product']);
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
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
                                <h2><b><i class="fa fa-shopping-cart"></i> Product Information</b></h2> 
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
                                             <table class="table table-bordered table-condensed table-striped">
                                                <thead>
                                                    <tr class="btn-danger">
                                                        <th colspan="4"> 
                                                            <h2 style="color: whitesmoke;"><i class="fa fa-user"></i> <b>Product Details</b>
                                                            <span class="pull-right">
                                                                <span class="badge"><b class="text-primary">Category : <?php echo $user_type['et_name'].' ('.$user_type['et_type'].')'; ?></b></span>                                                            </span>
                                                            </h2>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <table class="table table-bordered table-condensed table-striped table-hover">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-center" colspan="2">
                                                                            <?php
                                                                            if(base64_encode($get_product_info['pi_image'])){
                                                                            ?>
                                                                            <img class="img img-thumbnail img-responsive img-circle" src="data:image/jpg;base64,<?php echo base64_encode($get_product_info['pi_image']); ?>" alt="No Image" width="100" height="100" />
                                                                            <?php }else{ ?>
                                                                            <img class="img img-thumbnail img-responsive img-circle" src="product.png" width="100" height="100" />
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="text-center"><b>Product Code : <?php echo $get_product_info['pi_code']; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="text-center">
                                                                            <b>Product Status : <?php if($get_product_info['pi_status']==1){ echo '<span class="label label-success">Active</span>';} else{ echo '<span class="label label-danger">Deactive</span>'; } ?></b>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <table class="table table-striped table-hover">
                                                                    <tbody class="text-primary">
                                                                        <tr>
                                                                            <td class="text-right"><b>Product Name :</b></td>
                                                                              <td id="pro_name"><?php echo $get_product_info['pi_name']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-right"><b>Product Price :</b></td>
                                                                            <td id="p_s_p"><?php echo number_format($get_product_info['pi_sell_price'],2); ?> BDT</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-right"><b>Product Point :</b></td>
                                                                              <td id="pro_point"><?php echo $get_product_info['pi_point']; ?> PV</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-right"><b>Quantity :</b></td>
                                                                            <td class="text-<?php if($branch_product_info['bp_quantity']<=10){echo 'danger';}else{ echo 'primary'; } ?>"><?php echo $branch_product_info['bp_quantity']; ?> Pcs.</td>
                                                                        </tr>
                                                                        
                                                                        <tr>
                                                                            <td class="text-right"><b>Product Details :</b></td>
                                                                            <td> <?php echo $get_product_info['pi_details']; ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2" class="btn-danger"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <a class="btn" href="branch_product.php"><b><i class="fa fa-reply-all"></i> Back</b></a>
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
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
