<?php
session_start();
if(!isset($_SESSION['user'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Add Product PV';
$user_id = $_SESSION['user']['u_id'];
$user_info = get_user_info_by_id($user_id);
$user_branch=get_branch_info_by_id($user_info['u_branch_id']);

$updateStatus = "";
if(isset($_POST['pv_pin'])){
    $branch_id=$_POST['branch_id'];
    $pv_pin = $_POST['pv_pin'];
    $p_pin= strtoupper($pv_pin);
    if($branch_id==$user_info['u_branch_id']){
    $check_pv_pin = check_branch_user_pv_pin_info_by_id($branch_id,$p_pin);
    if($check_pv_pin){
        $update_pins=update_user_branch_pv_pin_status($p_pin,$branch_id,$user_id);
        if($update_pins){
            update_user_pv_value($user_id,$check_pv_pin['upv_value']);
            $updateStatus .= "<b style='color: green;'>Product Pin Added successful.</b><a class='btn btn-success' href='add_pin.php'><b><i class='fa fa-plus-circle'></i> Add Another</b></a>";
        }
    }else{
        $updateStatus .= "<b style='color: red;'>Branch Pin Not Match.</b><a class='btn btn-danger' href='add_pin.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
    }
    }else{
        $updateStatus .= "<b style='color: red;'>User Branch Not Match.</b><a class='btn btn-danger' href='add_pin.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
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
                        <h2><b><i class="fa fa-lock"></i> Add My Product PV Pin</b></h2> 
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
                                <div class="col-md-12 text-center">
                                    <form id="form" action="" method="post" >
                                        <table class="table table-condensed text-left table-hover table-striped">
                                            <thead>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="3"><h3><b>Enter Your Information</b></h3></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center" colspan="3">
                                                        <img class="img img-thumbnail img-circle btn disabled" src="assets/img/lock.png" alt="Lock" />
                                                    </td>
                                                </tr>
                                                <?php
                                                if($updateStatus){
                                                ?>
                                                <tr class="btn-default text-center">
                                                    <td class="btn-default" colspan="3">
                                                        <h1><b style="color: red;"><?php echo $updateStatus; ?></b></h1>
                                                    </td>
                                                </tr>
                                                <?php }else{ ?>
                                                <tr>
                                                    <td class="text-right text-info"><h5><b>Branch :</b></h5></td>
                                                    <td>
                                                        <b>
                                                            <select class="form-control" name="branch_id" required="">
                                                            <option value="">Select Branch</option>
                                                            <?php 
                                                            $branch_list= get_all_branch_list();
                                                            foreach ($branch_list as $branch){
                                                            ?>
                                                            <option value="<?php echo $branch['br_id']; ?>"><?php echo $branch['br_name'].' ('.$branch['br_code'].')'; ?></option>
                                                            <?php } ?>
                                                            </select>
                                                        </b>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right text-info"><h5><b>Product PV Pin:</b></h5></td>
                                                    <td><b><input class="form-control" type="text" name="pv_pin" placeholder="Enter Your Branch Product Pv Pin" required="" autofocus="off" autocomplete="off" /></b></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="btn pull-left text-info"><b><input type="checkbox" required="" /> Confirmation</b></label>
                                                    </td>
                                                    <td class="text-right text-info">
                                                        <button type="submit" class="btn btn-danger"><b><i class="fa fa-plus-circle"></i> Add Pin</b></button>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <?php } ?>
                                            </thead>
                                            <tfoot>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="3"><b></b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </form>
                                    <a class="btn" href="my_pvs.php"><b>My PV List</b></a>
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