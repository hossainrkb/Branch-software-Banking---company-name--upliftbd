<?php
session_start();
if(!isset($_SESSION['user'])){
header("Location: login.php");
}else{
$pageName = 'Member Profile';
include './includes/functions.php';
$user_id = $_SESSION['user']['u_id'];
$user_info = get_user_info_by_id($user_id);
$user_branch=get_branch_info_by_id($user_info['u_branch_id']);
$user_type=get_users_type_info_by_id($user_info['u_type']);
$user_total_member=get_member_list_by_user_id($user_id);
$user_sponsor_list=get_sponsor_list_by_user_id($user_id);
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
                                <h2><b><i class="fa fa-users"></i> Account Information</b></h2> 
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
                                                            <h2 style="color: whitesmoke;"><i class="fa fa-user"></i> <b>My Profile</b>
                                                            <span class="pull-right">
                                                                <span class="badge"><b class="text-danger">Member Type : <?php echo $user_type['ut_type']; ?></b></span>                                                            </span>
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
                                                                            if($user_info['u_picture']){
                                                                            ?>
                                                                            <img class="img img-thumbnail img-responsive btn disabled" src="assets/img/members/<?php echo $user_info['u_picture']; ?>" alt="No Image" width="100" height="100" />
                                                                            <?php }else{ ?>
                                                                            <img class="img img-thumbnail img-responsive btn disabled" src="assets/img/members/member.jpg" width="100" height="100" />
                                                                            <?php } ?>
                                                                            
                                                                            <?php if($user_info['u_type']=='7'){ ?>
                                                                                <br>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                            <?php }else if($user_info['u_type']=='6'){ ?>
                                                                                <br>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                            <?php }else if($user_info['u_type']=='5'){ ?>
                                                                            <br>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                             <?php }else if($user_info['u_type']=='4'){ ?>
                                                                            <br>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                             <?php }else if($user_info['u_type']=='3'){ ?>
                                                                            <br>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                             <?php }else if($user_info['u_type']=='2'){ ?>
                                                                            <br>
                                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                            <?php }else{ ?>
                                                                            <br>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                                <b><i class="fa fa-star-o"></i></b>
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="text-center"><b>Member ID : <?php echo $user_info['u_userid']; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="text-center"><b>Total Sponsor : <?php echo count($user_sponsor_list); ?> Member(s)</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="text-center">
                                                                            <b>Account Status : <?php if($user_info['u_status']==1){ echo '<span class="label label-success">Active</span>';} else{ echo '<span class="label label-danger">Deactive</span>'; } ?>
                                                                                <?php if($user_info['u_verify']==1){ echo '<span class="label label-success">Verified</span>';} else{ echo '<span class="label label-danger">Unverified</span>'; } ?>
                                                                            </b>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <table class="table table-striped table-condensed table-hover">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-right"><b>Member Name :</b></td>
                                                                        <td><b><?php echo $user_info['u_name']; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Mobile Number :</b></td>
                                                                        <td><b><?php echo $user_info['u_contact']; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Account Balance :</b></td>
                                                                        <td><b><?php $u_balance=$user_info['u_balance']; echo number_format($u_balance,2); ?> BDT</b></td>
                                                                    </tr>
                                                                    
                                                                    <tr>
                                                                        <td class="text-right"><b>National ID :</b></td>
                                                                        <td><b><?php echo $user_info['u_nid']; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Date Of Birth :</b></td>
                                                                        <td><b><i class="fa fa-calendar"></i> <?php echo date('d/m/Y',strtotime($user_info['u_dob'])); ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Branch Name :</b></td>
                                                                        <td><b><?php echo $user_branch['br_name'].' ('.$user_branch['br_code'].')'; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Registration Date :</b></td>
                                                                        <td><b><i class="fa fa-calendar"></i> <?php echo date('d/m/Y',strtotime($user_info['u_reg_date'])); ?></b></td>
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
                                            <!--
                                            <button type="button" class="btn btn-success pull-right btn-block" onClick="window.open('pic_update.php','SearchTip','width=800,height=500,resizable=yes,scrollbars=yes')">
                                                <i class="fa fa-edit"> <b>Update Profile Picture</b></i>
                                            </button>
                                            -->
                                        </div>
                                    </div>
                                    <hr/>
                                    <?php 
                                    if($user_info['u_sponsor_id']!=0){
                                    ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php 
                                            $sponosr_info = get_user_info_by_id($user_info['u_sponsor_id']); 
                                            $sponosr_user_type=get_users_type_info_by_id($sponosr_info['u_type']);
                                            $sponosr_branch=get_branch_info_by_id($sponosr_info['u_branch_id']);
                                            ?>
                                            <table class="table table-bordered table-condensed table-striped text-left">
                                                <thead>
                                                    <tr class="btn-danger text-center">
                                                        <td colspan="2"><h2 style="color: whitesmoke;"><b><i class="fa fa-user"></i> My Sponsor</b></h2></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center" colspan="2">
                                                            <?php
                                                            if($sponosr_info['u_picture']){
                                                            ?>
                                                            <img class="img img-thumbnail img-responsive btn disabled" src="assets/img/members/<?php echo $sponosr_info['u_picture']; ?>" alt="No Image" width="100" height="100" />
                                                            <?php }else{ ?>
                                                            <img class="img img-thumbnail img-responsive btn disabled" src="assets/img/members/member.jpg" width="100" height="100" />
                                                            <?php } ?>
                                                            
                                                            <?php if($sponosr_info['u_type']=='7'){ ?>
                                                                <br>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                            <?php }else if($sponosr_info['u_type']=='6'){ ?>
                                                                <br>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                            <?php }else if($sponosr_info['u_type']=='5'){ ?>
                                                            <br>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                             <?php }else if($sponosr_info['u_type']=='4'){ ?>
                                                            <br>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                             <?php }else if($sponosr_info['u_type']=='3'){ ?>
                                                            <br>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                             <?php }else if($sponosr_info['u_type']=='2'){ ?>
                                                            <br>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                            <?php }else{ ?>
                                                            <br>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                            <?php } ?>
                                                            <h5 style="color: red;"><b><?php echo $sponosr_info['u_name']; ?></b></h5>
                                                            <h5 class="btn-danger"><span class="badge"><b>Member Type : <?php echo $sponosr_user_type['ut_type']; ?></b></span></h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Member ID # :</b></td>
                                                        <td><b><?php echo $sponosr_info['u_userid']; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Mobile Number :</b></td>
                                                        <td><b><?php echo $sponosr_info['u_contact']; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Branch Name :</b></td>
                                                        <td><b><?php echo $sponosr_branch['br_name'].' ('.$sponosr_branch['br_code'].')'; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Registration Date :</b></td>
                                                        <td><b><?php echo date('d/m/Y',strtotime($sponosr_info['u_reg_date'])); ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Account Status :</b></td>
                                                        <td><b>
                                                            <?php if($sponosr_info['u_status']==1){ echo '<span class="label label-success">Active</span>';} else{ echo '<span class="label label-danger">Deactive</span>'; } ?>
                                                            <?php if($sponosr_info['u_verify']==1){ echo '<span class="label label-success">Verified</span>';} else{ echo '<span class="label label-danger">Unverified</span>'; } ?>
                                                            </b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="btn-danger">
                                                        <td colspan="2"><b></b></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <?php 
                                            $placement_info = get_user_info_by_id($user_info['u_placement_id']);
                                            $placement_user_type=get_users_type_info_by_id($placement_info['u_type']);
                                            $placement_branch=get_branch_info_by_id($placement_info['u_branch_id']);
                                            ?>
                                            <table class="table table-bordered table-condensed table-striped text-left">
                                                <thead>
                                                    <tr class="btn-danger text-center">
                                                        <td colspan="2"><h2 style="color: whitesmoke;"><b><i class="fa fa-user"></i> My Parent</b></h2></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center" colspan="2">                                                            
                                                            <?php
                                                            if($placement_info['u_picture']){
                                                            ?>
                                                            <img class="img img-thumbnail img-responsive btn disabled" src="assets/img/members/<?php echo $placement_info['u_picture']; ?>" alt="No Image" width="100" height="100" />
                                                            <?php }else{ ?>
                                                            <img class="img img-thumbnail img-responsive btn disabled" src="assets/img/members/member.jpg" width="100" height="100" />
                                                            <?php } ?>
                                                            
                                                            <?php if($placement_info['u_type']=='7'){ ?>
                                                                <br>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                            <?php }else if($placement_info['u_type']=='6'){ ?>
                                                                <br>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                            <?php }else if($placement_info['u_type']=='5'){ ?>
                                                            <br>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                             <?php }else if($placement_info['u_type']=='4'){ ?>
                                                            <br>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                             <?php }else if($placement_info['u_type']=='3'){ ?>
                                                            <br>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                             <?php }else if($placement_info['u_type']=='2'){ ?>
                                                            <br>
                                                                <b><i class="fa fa-star text-primary"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                            <?php }else{ ?>
                                                            <br>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                                <b><i class="fa fa-star-o"></i></b>
                                                            <?php } ?>
                                                            <h5 style="color: red;"><b><?php echo $placement_info['u_name']; ?></b></h5>
                                                            <h5 class="btn-danger"><span class="badge"><b>Member Type : <?php echo $placement_user_type['ut_type']; ?></b></span></h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Member ID # :</b></td>
                                                        <td><b><?php echo $placement_info['u_userid']; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Mobile Number :</b></td>
                                                        <td><b><?php echo $placement_info['u_contact']; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Branch Name :</b></td>
                                                        <td><b><?php echo $placement_branch['br_name'].' ('.$placement_branch['br_code'].')'; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Registration Date :</b></td>
                                                        <td><b><?php echo date('d/m/Y',strtotime($placement_info['u_reg_date'])); ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Account Status :</b></td>
                                                        <td><b>
                                                            <?php if($placement_info['u_status']==1){ echo '<span class="label label-success">Active</span>';} else{ echo '<span class="label label-danger">Deactive</span>'; } ?>
                                                            <?php if($placement_info['u_verify']==1){ echo '<span class="label label-success">Verified</span>';} else{ echo '<span class="label label-danger">Unverified</span>'; } ?>
                                                            </b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="btn-danger">
                                                        <td colspan="2"><b></b></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <?php } ?>
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
