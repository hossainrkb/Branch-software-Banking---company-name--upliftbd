<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
$pageName = 'Member Information';
include './includes/functions.php';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);

if(isset($_GET['m_id'])){
$user_id = $_GET['m_id'];
$user_info = get_member_info_by_id($user_id);
$user_branch=get_branch_info_by_id($user_info['u_branch_id']);
$user_type=get_member_type_info_by_id($user_info['u_type']);
$user_total_member=get_member_list_by_user_id($user_id);
$user_sponsor_list=get_sponsor_list_by_user_id($user_id);
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
                                <h2><b><i class="fa fa-home"></i> Member Information</b></h2> 
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
                                                            <h2 style="color: whitesmoke;"><i class="fa fa-user"></i> <b>Member Profile</b>
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
                                                                            <img class="img img-thumbnail img-responsive btn disabled" src="<?php echo $user_info['u_picture']; ?>" alt="No Image" width="100" height="100" />
                                                                            <?php }else{ ?>
                                                                            <img class="img img-thumbnail img-responsive btn disabled" src="member.png" width="100" height="100" />
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
                                                                        <td><b><?php echo date('d/m/Y',strtotime($user_info['u_dob'])); ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Agent Name :</b></td>
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
                                            </table
                                        </div>
                                        <div class="row">
                                    <div class="col-md-12">     
                                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                                                    <li role="presentation" class="active"><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>User DPS List</b></a></li>
                                                                    <li role="presentation" ><a href="#tab_content5" role="tab" id="home-tab" data-toggle="tab" aria-expanded="true"><b>User FDR List</b></a></li>

                                                                </ul>
                                                                <div id="myTabContent" class="tab-content">
                                                                    <div role="tabpanel" class="tab-pane fade in active" id="tab_content3" aria-labelledby="profile-tab">
                                                                    <div class="panel panel-danger">
                                                                         <div class="text-center  panel-heading">                                                           
                                                                             <span class=""><b style="color: ">DPS List</b></span>

                                                                            </div>
                                                                        <div class="panel-body">  
                                                                            <div class="table-responsive">
                                                                                    <table class="table table-bordered table-condensed table-striped table-hover text-center" id="abc">
                                                                                        <thead>
                                                                                            <tr class="btn-danger text-center">

                                                                                                <td><span class="btn"><b>SL.</b></span></td>
                                                                                                <td><span class="btn"><b>DPS Number.</b></span></td>
                                                                                                <td><span class="btn"><b>Date</b></span></td>
                                                                                                <td><span class="btn"><b>DPS Package</b></span></td>
                                                                                                <td><span class="btn"><b>DPS Installment Fee</b></span></td>
                                                                                                <td><span class="btn"><b>Open Amount</b></span></td>
                                                                                                <td><span class="btn"><b>Close Amount</b></span></td>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php 
                                                                                            $i=1;
                                                                                            $dps_info= get_dps_info_by_user_id_status($user_id);
                                                                                            foreach ($dps_info as $dps){
                                                                                                $get_user = get_member_info_by_id($dps['udi_user_id']);
                                                                                                $get_pack_info= get_dps_package_info_by_id($dps['udi_dps_id']);
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td><h5><?php echo $i;?></h5></td>     
                                                                                                <td class="text-center"><h5><b><a href="#" onclick="window.open('dps_monthly_payment_info.php?info=<?php echo $user_id.$dps['udi_id']?>', 'newwindow','width=600,height=500'); return false;"  href="#"><?php echo $dps['udi_dps_no']; ?></a></b></h5></td>
                                                                                                <td><h5><b>
                                                                                                            <i class="fa fa-calendar"></i><?php echo "  ".$dps['udi_open_date'];?> <span class="text-primary">To</span>
                                                                                                           <?php echo $dps['udi_close_date'];?> 
                                                                                                        </b></h5></td>
                                                                                                <td><h5><b><?php echo $get_pack_info['dpi_month']." Month". " <br/> ".'('.$get_pack_info['dpi_min_amount'].' - '.$get_pack_info['dpi_max_amount'].')'." BDT"; ?></b></h5></td>
                                                                                            <td class="text-center"><h5><b><?php echo $dps['udi_installment']; ?></b></h5></td>
                                                                                            <td class="text-center"><h5><b><?php echo $dps['udi_open_amount']; ?></b></h5></td>
                                                                                            <td class="text-center"><h5><b><?php echo $dps['udi_close_amount']; ?></b></h5></td>
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
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tfoot>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                    </div>
                                                                    </div>
                                                                        <div role="tabpanel" class="tab-pane fade in" id="tab_content5" aria-labelledby="profile-tab">      
                                                                            <div class="panel panel-danger"> 
                                                                                <div class="text-center  panel-heading">
                                                                                    <span class=""><b>FDR List</b></span>
                                                                                </div>
                                                                                <div class="panel-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-condensed table-striped table-hover text-center" id="xyz">
                                                                                            <thead>
                                                                                                <tr class="btn-danger text-center">
                                                                                                    <td><span class="btn"><b>SL.</b></span></td>
                                                                                                    <td><span class="btn"><b>FDR Number.</b></span></td>
                                                                                                    <td><span class="btn"><b>Date</b></span></td>
                                                                                                    <td><span class="btn"><b>FDR Package</b></span></td>
                                                                                                    <td><span class="btn"><b>Open Amount</b></span></td>
                                                                                                    <td><span class="btn"><b>Close Amount</b></span></td>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php 
                                                                                                $i=1;
                                                                                                $fdr_info= get_fdr_info_by_user_id($user_id);
                                                                                                foreach ($fdr_info as $fdr){
                                                                                                    $get_user = get_member_info_by_id($fdr['ufi_user_id']);
                                                                                                    $get_pack_info= get_fdr_package_info_by_id($fdr['ufi_fdr_id']);
                                                                                                ?>
                                                                                                <tr>
                                                                                                    <td><h5><?php echo $i;?></h5></td>     
                                                                                                    <td class="text-center"><h5><b><?php echo $fdr['ufi_fdr_no']; ?></b></h5></td>
                                                                                                    <td><h5><b>
                                                                                                                <i class="fa fa-calendar"></i><?php echo "  ".$fdr['ufi_open_date'];?> <span class="text-primary">To</span>
                                                                                                               <?php echo $fdr['ufi_close_date'];?> 
                                                                                                            </b></h5></td>
                                                                                                    <td><h5><b><?php echo $get_pack_info['fi_month']." Month". " - ".$get_pack_info['fi_amount']." BDT"; ?></b></h5></td>
                                                                                                <td class="text-center"><h5><b><?php echo $fdr['ufi_open_amount']; ?></b></h5></td>
                                                                                                <td class="text-center"><h5><b><?php echo $fdr['ufi_close_amount']; ?></b></h5></td>
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
                                                                                <hr/>    
                                                                            </div>
                                                                        </div>                                                   
                                                                    </div>
                                                                    <div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="profile-tab">
                                                                    <div class="panel panel-default"> 
                                                                        <div class="panel-body">                
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr />
                                                        
                                                        <?php 
                                                        if($user_info['u_sponsor_id']!=0){
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <?php 
                                                                $placement_info = get_member_info_by_id($user_info['u_placement_id']);
                                                                $placement_user_type=get_member_type_info_by_id($placement_info['u_type']);
                                                                $placement_branch=get_branch_info_by_id($placement_info['u_branch_id']);
                                                                ?>
                                                                <table class="table table-bordered table-condensed table-striped text-left">
                                                                    <thead>
                                                                        <tr class="btn-danger text-center">
                                                                            <td colspan="2"><h2 style="color: whitesmoke;"><b><i class="fa fa-user"></i> Member Parent</b></h2></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="text-center" colspan="2">                                                            
                                                                                <?php
                                                                                if($placement_info['u_picture']){
                                                                                ?>
                                                                                <img class="img img-thumbnail img-responsive btn disabled" src="<?php echo $placement_info['u_picture']; ?>" alt="No Image" width="100" height="100" />
                                                                                <?php }else{ ?>
                                                                                <img class="img img-thumbnail img-responsive btn disabled" src="member.png" width="100" height="100" />
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
                                                                            <td class="text-right"><b>Agent Name :</b></td>
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
                                                            <div class="col-md-6">
                                                                <?php 
                                                                $sponosr_info = get_member_info_by_id($user_info['u_sponsor_id']); 
                                                                $sponosr_user_type=get_member_type_info_by_id($sponosr_info['u_type']);
                                                                $sponosr_branch=get_branch_info_by_id($sponosr_info['u_branch_id']);
                                                                ?>
                                                                <table class="table table-bordered table-condensed table-striped text-left">
                                                                    <thead>
                                                                        <tr class="btn-danger text-center">
                                                                            <td colspan="2"><h2 style="color: whitesmoke;"><b><i class="fa fa-user"></i> Member Sponsor</b></h2></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="text-center" colspan="2">
                                                                                <?php
                                                                                if($sponosr_info['u_picture']){
                                                                                ?>
                                                                                <img class="img img-thumbnail img-responsive btn disabled" src="<?php echo $sponosr_info['u_picture']; ?>" alt="No Image" width="100" height="100" />
                                                                                <?php }else{ ?>
                                                                                <img class="img img-thumbnail img-responsive btn disabled" src="member.png" width="100" height="100" />
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
                                                                            <td class="text-right"><b>Agent Name :</b></td>
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
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    //
        <!-- JQUERY SCRIPTS -->
        <script src="d_table/js/jquery.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->

     <!-- DATA TABLE SCRIPTS -->
     <script src="d_table/js/jquery.dataTables.js"></script>
    <script src="d_table/js/dataTables.bootstrap.js"></script>

    <!-- TABLE STYLES-->
    <link href="d_table/css/dataTables.bootstrap.css" rel="stylesheet" />
    <script>
        $(document).ready(function () {
            $('#xyz').dataTable();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#abc').dataTable();
        });
    </script>
</body>
</html>
<?php } ?>
