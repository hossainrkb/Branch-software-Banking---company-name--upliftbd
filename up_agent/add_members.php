<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Member Registration';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);
$updateStatus = "";
$registration_info = "";

if(isset($_POST['br_tpin'])){
    $br_tpin = $_POST['br_tpin'];
if($br_tpin==$branch_info['br_tpin']){
    $contact = $_POST['user_contact'];
    $name = strtoupper($_POST['user_name']);
    $sponsor_id = $_POST['sponsor_id'];
    $password= rand(111111,999999);
    $mo_code = substr($contact,0,3);
    $m_operator_info = get_mobile_operator_info_by_code($mo_code);
    $branch_info = get_branch_info_by_id($branch_id);
    $sponsor_info = get_user_info_by_id($sponsor_id);
    if($sponsor_info&&$branch_info){
    if($m_operator_info){
    if(check_user_info($contact)){
            $updateStatus .= "<b style='color: red;'>User already exists,please try again.</b><a class='btn btn-danger' href='add_members.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
        }else{
            $u_sponsor_id = $sponsor_info['u_id'];
            $u_placement_id = $sponsor_info['u_id'];
            $u_password = md5($password);
            if(add_users_info($name,$contact,$u_password,$branch_id,$u_sponsor_id,$u_placement_id)){
            if(check_user_info($contact)){
                $customer_info=check_user_info($contact);
                $id_date = date("ym");
                $customer_id = 'M'.$branch_id.$id_date.$customer_info['u_id'];
                $updateCustomer= update_members_userid($customer_info['u_id'],$customer_id);
                if($updateCustomer){
                    $updateStatus .= "Registration Success.";
                    $registration_info.=  "Registration Success.";
                    /////////////////SMS///////////////////////////
                    if(!$registration_info){
                        $to=$contact;
                        $sms_message = "Congratulations,\n$name($customer_id),\nYou have successfully registered.\n@$webUrl";
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
                }
            }
        }
        }
    }else{
        $updateStatus .= "<b style='color: red;'>Please Input a valid mobile Number.</b><a class='btn btn-danger' href='add_members.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
    }
}else{
        $updateStatus .= "<b style='color: red;'>Please Input Corrent Information.</b><a class='btn btn-danger' href='add_members.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
    }
}else{
        $updateStatus .= "<b style='color: red;'>Agent T-Pin Not Match.</b><a class='btn btn-danger' href='add_members.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
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
    <?php include './live_search.php';?>
    
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
                    <div class="col-md-12 text-center">
                        <img class="img img-thumbnail text-center" src="timeline.png" />
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default btn-default">
                        <div class="panel-heading">
                            <h2><b><i class="fa fa-edit"></i> <?php echo $pageName; ?></b></h2> 
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="x_content">
                                    <table class="table table-condensed text-left">
                                            <thead>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="4"><h3><b>New Member's Information</b></h3></td>
                                                </tr>
                                                <?php if($updateStatus){ ?>
                                                <tr class="btn-default text-center">
                                                    <td class="btn-default" colspan="4">
                                                        <h1><b style="color: red;"><?php echo $updateStatus; ?></b></h1>
                                                    </td>
                                                </tr>
                                                <tr class="btn-default text-center">
                                                    <td class="btn-default" colspan="4">
                                                        <?php if($registration_info){ ?>
                                                        <table class="table table-bordered table-condensed table-striped">
                                                        <thead>
                                                            <tr class="btn-success">
                                                                <th colspan="4"> 
                                                                    <h2 style="color: whitesmoke;"><i class="fa fa-user"></i> <b>Registration Information</b></h2>
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
                                                                                    if(base64_encode($customer_info['u_image'])){
                                                                                    ?>
                                                                                    <img class="img img-thumbnail img-responsive img-circle" src="data:image/jpg;base64,<?php echo base64_encode($customer_info['u_image']); ?>" alt="No Image" width="100" height="100" />
                                                                                    <?php }else{ ?>
                                                                                    <img class="img img-thumbnail img-responsive btn disabled" src="assets/img/member.png" width="100" height="100" />
                                                                                    <?php } ?>
                                                                                    <br>
                                                                                    <b><i class="fa fa-star-o"></i></b>
                                                                                    <b><i class="fa fa-star-o"></i></b>
                                                                                    <b><i class="fa fa-star-o"></i></b>
                                                                                    <b><i class="fa fa-star-o"></i></b>
                                                                                    <b><i class="fa fa-star-o"></i></b>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" class="text-center"><b>Member ID : <?php echo $customer_id; ?></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" class="text-center"><b>Sponsor ID : <?php echo $sponsor_info['u_userid']; ?></b></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                                <td>
                                                                    <table class="table table-striped table-hover">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-right"><b>Member Name :</b></td>
                                                                                <td class="text-left"><b><?php echo $customer_info['u_name']; ?></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-right"><b>Mobile Number :</b></td>
                                                                                <td class="text-left"><b><?php echo $customer_info['u_contact']; ?></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-right"><b>Agent Name :</b></td>
                                                                                <td class="text-left"><b><?php echo $branch_info['br_name'].' ('.$branch_info['br_code'].')'; ?></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-right"><b>Registration Date :</b></td>
                                                                                <td class="text-left"><b><?php echo date('d/m/Y',strtotime($customer_info['u_reg_date'])); ?></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-right"><b>Account Status :</b></td>
                                                                                <td class="text-left"><b>
                                                                                        <?php if($customer_info['u_status']==1){ echo '<span class="label label-success">Active</span>';} else{ echo '<span class="label label-danger">Deactive</span>'; } ?>
                                                                                        <?php if($customer_info['u_verify']==1){ echo '<span class="label label-success">Verified</span>';} else{ echo '<span class="label label-danger">Unverified</span>'; } ?>
                                                                                </b></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>

                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2" class="btn-success"></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" class="text-center">
                                                                    <h2><a href="branch_members.php"><b>View Member List</b></a></h2>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                 <?php }else if(isset($_REQUEST['m_sponsor'])&&isset($_REQUEST['m_contact'])){ 
                                                    $m_sponsor=$_REQUEST['m_sponsor'];
                                                    $m_name= strtoupper($_REQUEST['m_name']);
                                                    $m_contact=$_REQUEST['m_contact'];
                                                    $mo_code = substr($m_contact,0,3);
                                                    $m_operator_info = get_mobile_operator_info_by_code($mo_code);
                                                    if($m_operator_info){
                                                    $user_info = get_user_info_by_uid_or_contact($m_contact);
                                                     if(!$user_info){
                                                         $sponsor_info = get_user_info_by_id($m_sponsor);
                                                     ?>
                                                <form action="" method="post">
                                                    <input type="hidden" name="sponsor_id" value="<?php echo $m_sponsor; ?>" required="" />
                                                    <input type="hidden" name="user_name" value="<?php echo $m_name; ?>" required="" />
                                                    <input type="hidden" name="user_contact" value="<?php echo $m_contact; ?>" required="" />
                                                    <tr>
                                                        <td>
                                                            <table class="table table-condensed table-bordered text-center">
                                                                <thead>
                                                                    <tr class="btn-danger">
                                                                        <td colspan="2"><b>New Member Information</b></td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-right"><b>Agent info</b></td>
                                                                        <td class="text-left"><b><?php echo $branch_info['br_name'].' ('.$branch_info['br_code'].')'; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Member Name</b></td>
                                                                        <td class="text-left"><b><?php echo $m_name; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Contact Number</b></td>
                                                                        <td class="text-left"><b><?php echo $m_contact; ?></b></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <table class="table table-condensed table-bordered text-center">
                                                                <thead>
                                                                    <tr class="btn-danger">
                                                                        <td colspan="2"><b>Sponsor Information</b></td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-right"><b>ID #</b></td>
                                                                        <td class="text-left"><b><?php echo $sponsor_info['u_userid']; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Name</b></td>
                                                                        <td class="text-left"><b><?php echo $sponsor_info['u_name']; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Contact</b></td>
                                                                        <td class="text-left"><b><?php echo $sponsor_info['u_contact']; ?></b></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="text-center">
                                                            <b><input type="password" name="br_tpin" minlength="4" maxlength="4" placeholder="Enter Agent T-Pin" required="" autocomplete="off" autofocus="off"  /></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a class="btn btn-danger pull-left" href="add_members.php"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                                            <label class="btn pull-right text-info"><b><input type="checkbox" required="" /> Confirm Registration</b></label>
                                                        </td>
                                                        <td class="text-right text-info">
                                                            <button type="submit" class="btn pull-right btn-danger"><b><i class="fa fa-arrow-circle-o-right"></i> Register</b></button>
                                                        </td>
                                                    </tr>
                                                </form>
                                                <?php }else{ ?>
                                                <tr class="text-center">
                                                    <td class="text-danger" colspan="4">
                                                        <h2><b style='color: red;'>Member Already Registered.</b></h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <a class="btn btn-default text-center" href="add_members.php"><b><i class="fa fa-recycle"></i> Try Again</b></a>
                                                    </td>
                                                </tr>
                                                 <?php } }else{
                                                ?>
                                                <tr class="text-center">
                                                    <td class="text-danger" colspan="4">
                                                        <h2><b style='color: red;'>Please Input a Valid Mobile Number.</b></h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <a class="btn btn-default text-center" href="add_members.php"><b><i class="fa fa-recycle"></i> Try Again</b></a>
                                                    </td>
                                                </tr>
                                                <?php
                                                 } }else{ ?>
                                                <form action="" method="post" >
                                                    <tr>
                                                        <td class="text-right text-info"><h5><b>Sponsor ID :</b></h5></td>
                                                        <td colspan="3">
                                                            <b>
                                                                <select  class="select2 form-control" name="m_sponsor" data-live-search="true" required="" >
                                                                    <option value="">Select Member's Sponsor</option>
                                                                    <?php 
                                                                        $branch_members= get_all_branch_members($branch_info['br_id']);
                                                                        if(count($branch_members)>0){ 
                                                                        foreach ($branch_members as $br_members){
                                                                            //$m_info = get_member_info_by_id($br_members['u_id']);
                                                                        ?>
                                                                        <option value="<?php echo $br_members['u_id']; ?>"><?php echo $br_members['u_userid'].'-'.$br_members['u_name']; ?></option>
                                                                        <?php 
                                                                          } }
                                                                        ?>  
                                                                </select>
                                                            </b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right text-info"><h5><b>Member Name :</b></h5></td>
                                                        <td colspan="3"><b><input class="form-control" type="text" name="m_name" placeholder="Enter Member Name" required="" autofocus="off" autocomplete="off" /></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right text-info"><h5><b>Contact Number :</b></h5></td>
                                                        <td><b><input class="form-control" type="text" name="m_contact" placeholder="Enter Contact No" required="" autofocus="off" autocomplete="off" minlength="11" maxlength="11" /></b></td>
                                                        <td class="text-right text-info"><h5><b>Agent :</b></h5></td>
                                                        <td>
                                                            <b>
                                                                <select class="form-control" name="m_branch" required="" disabled="" >
                                                                    <option value="">Select Branch</option>
                                                                    <?php 
                                                                        $branch_list = get_all_branch_list();
                                                                        if(count($branch_list)>0){
                                                                        $i=1;  
                                                                        foreach ($branch_list as $br_list){
                                                                            $br_info= get_branch_info_by_id($br_list['br_id']);
                                                                        ?>
                                                                        <option value="<?php echo $br_info['br_id']; ?>" <?php if($br_info['br_id']==$branch_info['br_id']){ echo 'selected';} ?> ><?php echo $br_info['br_name'].' ('.$br_info['br_code'].')'; ?></option>
                                                                        <?php 
                                                                            $i++;} }
                                                                        ?>  
                                                                </select>
                                                            </b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4">
                                                            <a class="btn btn-danger pull-left" href="cpanel.php"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                                            <button type="submit" class="btn pull-right btn-danger"><b>Continue <i class="fa fa-arrow-circle-right"></i></b></button>
                                                        </td>
                                                    </tr>
                                                </form>
                                                <?php } ?>
                                            </thead>
                                            <tfoot>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="4"><b></b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                </div>
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
    <script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>
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
   
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-select.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>

</body>
</html>
<?php } ?>