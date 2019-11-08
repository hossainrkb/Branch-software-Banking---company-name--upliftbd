<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
$pageName = 'Branch Profile';
include './includes/functions.php';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);
$branch_owner = get_branch_owner_info_by_branch_id($branch_id); 
$br_creator_info = get_member_info_by_id($branch_info['br_ref_member']);
$member_type=get_member_type_info_by_id($br_creator_info['u_type']);
$total_br_member= get_all_branch_members($branch_id);
$total_br_employee= get_all_branch_employee($branch_id);
$br_creator_income=get_branch_creator_income($br_creator_info['u_id'], $branch_id);
$commission = '0';
foreach ($br_creator_income as $incomes){
    $commission=$commission+$incomes['dep_amount'];
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
                            <div class="col-md-12 text-center">
                                <img class="img img-thumbnail text-center" src="timeline.png" /><hr/>
                            </div>
                        </div>
                       <div class="row">
                        <div class="col-md-12">
                            <!-- Form Elements -->
                            <div class="panel panel-default btn-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr class="btn-danger text-center">
                                                        <td colspan="2"><h2 style="color: whitesmoke;"><b><i class="fa fa-info-circle"></i> Agent Details</b></h2></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <table class="table table-bordered table-striped text-left">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-center" colspan="2">
                                                                            <?php
                                                                            if(base64_encode($branch_info['br_image'])){
                                                                            ?>
                                                                            <img class="img img-thumbnail img-responsive btn disabled" src="data:image/jpg;base64,<?php echo base64_encode($branch_info['br_image']); ?>" alt="No Image" width="100" height="100" />
                                                                            <?php }else{ ?>
                                                                            <img class="img img-thumbnail img-responsive btn disabled" src="branch.png" width="100" height="100" />
                                                                            <?php } ?>
                                                                            <h5 style="color: red;"><b><?php echo $branch_info['br_name']; ?> Agent</b></h5>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="text-center" style="color: red;"><b>Agent Code # <?php echo $branch_info['br_code']; ?></b></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <table class="table table-bordered table-condensed table-striped text-left">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="2"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Agent eMoney :</b></td>
                                                                        <td><b><?php echo number_format($branch_info['br_amount'],2); ?> BDT</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Total Member :</b></td>
                                                                        <td><b><?php echo count($total_br_member); ?></b> <a href="branch_members.php" target="_blank"><b>[ View All ]</b></a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Total Employee :</b></td>
                                                                        <td><b><?php echo count($total_br_employee); ?></b> <a href="branch_employee.php" target="_blank"><b>[ View All ]</b></a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Registration Date :</b></td>
                                                                        <td><b><?php echo date('d/m/Y',strtotime($branch_info['br_reg_date'])); ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Account Status :</b></td>
                                                                        <td><b>
                                                                            <?php if($branch_info['br_status']==1){ echo '<span class="label label-success">Active</span>';} else{ echo '<span class="label label-danger">Deactive</span>'; } ?>
                                                                            <?php if($branch_info['br_verify']==1){ echo '<span class="label label-success">Verified</span>';} else{ echo '<span class="label label-danger">Unverified</span>'; } ?>
                                                                            </b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                <tfoot>
                                                    <tr class="btn-danger">
                                                        <td colspan="2"><b></b></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        
                                        
                                    </div>
                                    
                                    <div class="row">
                                        <?php 
                                            if($br_creator_info){
                                        ?>
                                        <div class="col-md-6">
                                                <table class="table table-bordered table-condensed table-striped text-left">
                                                    <thead>
                                                        <tr class="btn-danger text-center">
                                                            <td colspan="2"><h2 style="color: whitesmoke;"><b><i class="fa fa-info-circle"></i> Branch Creator</b></h2></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center" colspan="2">
                                                                <?php
                                                                if($br_creator_info['u_picture']){
                                                                ?>
                                                                <img class="img img-thumbnail img-responsive btn disabled" src="http://ebijoy16.com/assets/img/members/<?php echo $br_creator_info['u_picture']; ?>" alt="No Image" width="100" height="100" />
                                                                <?php }else{ ?>
                                                                <img class="img img-thumbnail img-responsive btn disabled" src="member.png" width="100" height="100" />
                                                                <?php } ?>
                                                                <span class="badge btn-danger"><b><small>ID # <?php echo $br_creator_info['u_userid']; ?></small></b></span> 
                                                                <h5 style="color: red;"><b><?php echo $br_creator_info['u_name']; ?></b> <small><i><b></b></i></small></h5>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right"><b>Contact No :</b></td>
                                                            <td><b><?php echo $br_creator_info['u_contact']; ?></b></td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="btn-danger">
                                                            <td colspan="2"><b></b></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        <?php } ?>
                                        
                                        <?php 
                                            if($branch_owner){
                                        ?>
                                        <div class="col-md-6">
                                                <table class="table table-bordered table-condensed table-striped text-left">
                                                    <thead>
                                                        <tr class="btn-danger text-center">
                                                            <td colspan="2"><h2 style="color: whitesmoke;"><b><i class="fa fa-info-circle"></i> Branch Owner</b></h2></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center" colspan="2">
                                                                <?php
                                                                if(base64_encode($branch_owner['bwi_image'])){
                                                                ?>
                                                                <img class="img img-thumbnail img-responsive btn disabled" src="data:image/jpg;base64,<?php echo base64_encode($branch_owner['bwi_image']); ?>" alt="No Image" width="100" height="100" />
                                                                <?php }else{ ?>
                                                                <img class="img img-thumbnail img-responsive btn disabled" src="member.png" width="100" height="100" />
                                                                <?php } ?>
                                                                <h5 style="color: red;"><b><?php echo $branch_owner['bwi_name']; ?></b></h5>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right"><b>Contact No :</b></td>
                                                            <td><b><?php echo $branch_owner['bwi_contact']; ?></b></td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="btn-danger">
                                                            <td colspan="2"><b></b></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        <?php } ?>
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
