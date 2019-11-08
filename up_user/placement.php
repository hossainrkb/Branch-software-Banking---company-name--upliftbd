<?php
session_start();
if(!isset($_SESSION['user'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'My Placement List';
$user_id = $_SESSION['user']['u_id'];
$user_info = get_user_info_by_id($user_id);
$user_branch=get_branch_info_by_id($user_info['u_branch_id']);
$reseller_list = get_placement_list_by_user_id($user_id);
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
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2><b><i class="fa fa-list"></i> My Placement List</b></h2>
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr/>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default btn-default" style="font-family: monospace;">
                        <div class="panel-body">
                            <table class="table table-bordered table-condensed table-striped  table-hover text-center">
                                <thead>
                                    <tr class="btn-danger text-center">
                                        <td><span class="btn"><b>IMAGE</b></span></td>
                                        <td><span class="btn"><b>Member ID</b></span></td>
                                        <td><span class="btn"><b>Member Name</b></span></td>
                                        <td><span class="btn"><b>Contact No</b></span></td>
                                        <td><span class="btn"><b>TYPE</b></span></td>
                                        <td><span class="btn"><b>Status</b></span></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if($reseller_list){
                                    $i=1;
                                    foreach ($reseller_list as $reseller){
                                        $reseller_info = get_user_info_by_id($reseller['u_id']);
                                        $user_type=get_users_type_info_by_id($reseller_info['u_type']);
                                    ?>
                                    <tr>
                                        <td>
                                            <?php
                                            if($reseller_info['u_picture']){
                                            ?>
                                            <img class="img img-thumbnail img-responsive btn disabled" src="assets/img/members/<?php echo $reseller_info['u_picture']; ?>" alt="No Image" width="100" height="100" />
                                            <?php }else{ ?>
                                            <img class="img img-thumbnail img-responsive btn disabled" src="assets/img/members/member.jpg" width="100" height="100" />
                                            <?php } ?>
                                        </td>
                                        <td><br/><h5><b><?php echo $reseller_info['u_userid']; ?></b></h5></td>
                                        <td class="text-left"><br/><h5><b><?php echo $reseller_info['u_name']; ?></b></h5></td>
                                        <td><br/><h5><b><?php echo $reseller_info['u_contact']; ?></b></h5></td>
                                        <td><br/><h5><b><?php echo $user_type['ut_type']; ?></b></h5></td>
                                        <td><br/><h5><b><?php if($reseller_info['u_status']==1){ echo '<span class="label label-success">Active</span>';} else{ echo '<span class="label label-danger">Deactive</span>'; } ?></b></h5></td>
                                    </tr>
                                    <?php $i++; } }else{ ?>
                                    <tr>
                                        <td colspan="6"><b>No data available in table</b></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr class="btn-danger text-center">
                                        <td colspan="6"></td>
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
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
