<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
$pageName = 'Employee Information';
include './includes/functions.php';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);
if(isset($_GET['emp_id'])){
$emp_id = $_GET['emp_id'];
if($emp_id!='1'){
$emp_info = get_employee_info_by_id($emp_id);
$emp_type=get_employee_type_info_by_id($emp_info['e_type']);
$emp_branch=get_branch_info_by_id($emp_info['e_branch']);
if($branch_id==$emp_info['e_branch']){
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
                                <h2><b><i class="fa fa-users"></i> Employee Information</b></h2> 
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
                                                            <h2 style="color: whitesmoke;"><i class="fa fa-user"></i> <b>Employee Profile</b>
                                                            <span class="pull-right">
                                                                <span class="badge"><b class="text-danger">Type : <?php echo $emp_type['et_name'].' ('.$emp_type['et_type'].')'; ?></b></span>                                                            </span>
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
                                                                            if(base64_encode($emp_info['e_image'])){
                                                                            ?>
                                                                            <img class="img img-thumbnail img-responsive btn disabled" src="data:image/jpg;base64,<?php echo base64_encode($emp_info['e_image']); ?>" alt="No Image" width="100" height="100" />
                                                                            <?php }else{ ?>
                                                                            <img class="img img-thumbnail img-responsive btn disabled" src="assets/img/site_logo.jpg" width="100" height="100" />
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="text-center"><b>Employee ID : <?php echo $emp_info['e_userid']; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="text-center">
                                                                            <b>Account Status : <?php if($emp_info['e_status']==1){ echo '<span class="label label-success">Active</span>';} else{ echo '<span class="label label-danger">Deactive</span>'; } ?>
                                                                                <?php if($emp_info['e_verify']==1){ echo '<span class="label label-success">Verified</span>';} else{ echo '<span class="label label-danger">Unverified</span>'; } ?>
                                                                            </b>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <table class="table table-striped table-hover">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-right"><b>Employee Name :</b></td>
                                                                        <td><b><?php echo $emp_info['e_name']; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Contact Number :</b></td>
                                                                        <td><b><?php echo $emp_info['e_contact']; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Account Balance :</b></td>
                                                                        <td><b><?php $u_balance=$emp_info['e_balance']; echo number_format($u_balance,2); ?> BDT</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Branch Name & Code :</b></td>
                                                                        <td><b><?php echo $emp_branch['br_name'].' ('.$emp_branch['br_code'].')'; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Registration Date :</b></td>
                                                                        <td><b><i class="fa fa-calendar"></i> <?php echo date('d/m/Y',strtotime($emp_info['e_reg_date'])); ?></b></td>
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
                                        </div>
                                    </div>
                                    <?php if($emp_info['e_ref_id']!=0){ ?>
                                    <div class="row">
                                        <?php if($emp_info['e_type']==2){ ?>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <?php 
                                            $SalesManager = get_employee_info_by_id($emp_info['e_ref_id']); 
                                            if($SalesManager['e_id']!='1'){
                                            $sm_type=get_employee_type_info_by_id($SalesManager['e_type']);
                                            $sm_branch=get_branch_info_by_id($SalesManager['e_branch']);
                                            ?>
                                            <table class="table table-bordered table-condensed table-striped text-left">
                                                <thead>
                                                    <tr class="btn-danger text-center">
                                                        <td colspan="2"><h2 style="color: whitesmoke;"><b><i class="fa fa-user"></i> Sales Manager</b></h2></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center" colspan="2">
                                                            <?php
                                                            if(base64_encode($SalesManager['e_image'])){
                                                            ?>
                                                            <img class="img img-thumbnail img-responsive btn disabled" src="data:image/jpg;base64,<?php echo base64_encode($SalesManager['e_image']); ?>" alt="No Image" width="100" height="100" />
                                                            <?php }else{ ?>
                                                            <img class="img img-thumbnail img-responsive btn disabled" src="assets/img/site_logo.jpg" width="100" height="100" />
                                                            <?php } ?>
                                                            <h5 style="color: red;"><b><?php echo $SalesManager['e_name']; ?></b></h5>
                                                            <h5 class="btn-danger"><span class="badge"><b>Type : <?php echo $sm_type['et_name'].' ('.$sm_type['et_type'].')'; ?></b></span></h5>
                                                        </td>
                                                    </tr>
                                                     <tr>
                                                        <td class="text-right"><b>Employee ID # :</b></td>
                                                        <td><b><?php echo $SalesManager['e_userid']; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Contact Number :</b></td>
                                                        <td><b><?php echo $SalesManager['e_contact']; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Branch Name & Code :</b></td>
                                                        <td><b><?php echo $sm_branch['br_name'].' ('.$sm_branch['br_code'].')'; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Registration Date & Time :</b></td>
                                                        <td><b><?php echo date('d/m/Y',strtotime($SalesManager['e_reg_date'])); ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Account Status :</b></td>
                                                        <td><b>
                                                            <?php if($SalesManager['e_status']==1){ echo '<span class="label label-success">Active</span>';} else{ echo '<span class="label label-danger">Deactive</span>'; } ?>
                                                            <?php if($SalesManager['e_verify']==1){ echo '<span class="label label-success">Verified</span>';} else{ echo '<span class="label label-danger">Unverified</span>'; } ?>
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
                                        <div class="col-md-2"></div>
                                            <?php }}else{ ?>
                                        <div class="col-md-6">
                                            <?php 
                                            $sales_executive = get_employee_info_by_id($emp_info['e_ref_id']); 
                                            $se_type=get_employee_type_info_by_id($sales_executive['e_type']);
                                            $se_branch=get_branch_info_by_id($sales_executive['e_branch']);
                                            ?>
                                            <table class="table table-bordered table-condensed table-striped text-left">
                                                <thead>
                                                    <tr class="btn-danger text-center">
                                                        <td colspan="2"><h2 style="color: whitesmoke;"><b><i class="fa fa-user"></i> Sales Executive</b></h2></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center" colspan="2">
                                                            <?php
                                                            if(base64_encode($sales_executive['e_image'])){
                                                            ?>
                                                            <img class="img img-thumbnail img-responsive btn disabled" src="data:image/jpg;base64,<?php echo base64_encode($sales_executive['e_image']); ?>" alt="No Image" width="100" height="100" />
                                                            <?php }else{ ?>
                                                            <img class="img img-thumbnail img-responsive btn disabled" src="assets/img/site_logo.jpg" width="100" height="100" />
                                                            <?php } ?>
                                                            <h5 style="color: red;"><b><?php echo $sales_executive['e_name']; ?></b></h5>
                                                            <h5 class="btn-danger"><span class="badge"><b>Type : <?php echo $se_type['et_name'].' ('.$se_type['et_type'].')'; ?></b></span></h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Employee ID # :</b></td>
                                                        <td><b><?php echo $sales_executive['e_userid']; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Contact Number :</b></td>
                                                        <td><b><?php echo $sales_executive['e_contact']; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Branch Name & Code :</b></td>
                                                        <td><b><?php echo $se_branch['br_name'].' ('.$se_branch['br_code'].')'; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Registration Date & Time :</b></td>
                                                        <td><b><?php echo date('d/m/Y',strtotime($sales_executive['e_reg_date'])); ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Account Status :</b></td>
                                                        <td><b>
                                                            <?php if($sales_executive['e_status']==1){ echo '<span class="label label-success">Active</span>';} else{ echo '<span class="label label-danger">Deactive</span>'; } ?>
                                                            <?php if($sales_executive['e_verify']==1){ echo '<span class="label label-success">Verified</span>';} else{ echo '<span class="label label-danger">Unverified</span>'; } ?>
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
                                            $SalesManager = get_employee_info_by_id($sales_executive['e_ref_id']); 
                                            $sm_type=get_employee_type_info_by_id($SalesManager['e_type']);
                                            $sm_branch=get_branch_info_by_id($SalesManager['e_branch']);
                                            ?>
                                            <table class="table table-bordered table-condensed table-striped text-left">
                                                <thead>
                                                    <tr class="btn-danger text-center">
                                                        <td colspan="2"><h2 style="color: whitesmoke;"><b><i class="fa fa-user"></i> Sales Manager</b></h2></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center" colspan="2">
                                                            <?php
                                                            if(base64_encode($SalesManager['e_image'])){
                                                            ?>
                                                            <img class="img img-thumbnail img-responsive btn disabled" src="data:image/jpg;base64,<?php echo base64_encode($SalesManager['e_image']); ?>" alt="No Image" width="100" height="100" />
                                                            <?php }else{ ?>
                                                            <img class="img img-thumbnail img-responsive btn disabled" src="assets/img/site_logo.jpg" width="100" height="100" />
                                                            <?php } ?>
                                                            <h5 style="color: red;"><b><?php echo $SalesManager['e_name']; ?></b></h5>
                                                            <h5 class="btn-danger"><span class="badge"><b>Type : <?php echo $sm_type['et_name'].' ('.$sm_type['et_type'].')'; ?></b></span></h5>
                                                        </td>
                                                    </tr>
                                                     <tr>
                                                        <td class="text-right"><b>Employee ID # :</b></td>
                                                        <td><b><?php echo $SalesManager['e_userid']; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Contact Number :</b></td>
                                                        <td><b><?php echo $SalesManager['e_contact']; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Branch Name & Code :</b></td>
                                                        <td><b><?php echo $sm_branch['br_name'].' ('.$sm_branch['br_code'].')'; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Registration Date & Time :</b></td>
                                                        <td><b><?php echo date('d/m/Y',strtotime($SalesManager['e_reg_date'])); ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><b>Account Status :</b></td>
                                                        <td><b>
                                                            <?php if($SalesManager['e_status']==1){ echo '<span class="label label-success">Active</span>';} else{ echo '<span class="label label-danger">Deactive</span>'; } ?>
                                                            <?php if($SalesManager['e_verify']==1){ echo '<span class="label label-success">Verified</span>';} else{ echo '<span class="label label-danger">Unverified</span>'; } ?>
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
                                        <?php } ?>
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
<?php }else{
    echo "<meta http-equiv='refresh' content='.5;url=cpanel.php'>";
}
}else{
    echo "<meta http-equiv='refresh' content='.5;url=cpanel.php'>";
}}else{
echo "<meta http-equiv='refresh' content='.5;url=cpanel.php'>";
} } ?>
