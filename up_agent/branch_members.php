<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Agent Members';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);
$sponsor_list= get_all_branch_members($branch_id);
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
                    <div class="col-md-12 text-center">
                        <img class="img img-thumbnail text-center" src="timeline.png" />
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr/>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default btn-default" style="font-family: monospace;">
                        <div class="panel-heading">
                            <h2><b><i class="fa fa-users"></i> <?php echo $pageName; ?></b></h2>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed table-striped table-hover text-center" id="dataTables-example">
                                    <thead>
                                        <tr class="btn-danger text-center">
                                            <td><span class="btn"><b>Image</b></span></td>
                                            <td><span class="btn"><b>Member ID</b></span></td>
                                            <td><span class="btn"><b>Member Name</b></span></td>
                                            <td><span class="btn"><b>Contact No</b></span></td>
                                            <td><span class="btn"><b>Status</b></span></td>
                                            <td><span class="btn"><b>Verification</b></span></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i=1;
                                        foreach ($sponsor_list as $sponsor){
                                            $sponsor_info = get_member_info_by_id($sponsor['u_id']);
                                            $s_user_type=get_member_type_info_by_id($sponsor_info['u_type']);
                                        ?>
                                        <tr>
                                            <td>
                                                <?php
                                                if($sponsor_info['u_picture']){
                                                ?>
                                                <img class="img img-thumbnail img-responsive btn disabled" src="http://ebijoy16.com/assets/img/members/<?php echo $sponsor_info['u_picture']; ?>" alt="No Image" width="100" height="100" />
                                                <?php }else{ ?>
                                                <img class="img img-thumbnail img-responsive btn disabled" src="member.png" width="100" height="100" />
                                                <?php } ?>
                                            </td>
                                            <td><h5><a class="btn" href="member_info.php?m_id=<?php echo $sponsor_info['u_id']; ?>" target="_blank"><b><?php echo $sponsor_info['u_userid']; ?></b></a></h5></td>
                                            <td class="text-left"><h5><b><?php echo $sponsor_info['u_name']; ?></b></h5></td>
                                            <td><h5><b><?php echo $sponsor_info['u_contact']; ?></b></h5></td>
                                            <td><h5><b><?php if($sponsor_info['u_status']==1){ echo '<span class="label label-success">Active</span>';} else{ echo '<span class="label label-danger">Deactive</span>'; } ?></b></h5></td>
                                            <td><h5><b><?php if($sponsor_info['u_verify']==1){ echo '<span class="label label-success">Verified</span>';} else{ echo '<span class="label label-danger">Unverified</span>'; } ?></b></h5></td>
                                        </tr>
                                        <?php $i++; } ?>
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
