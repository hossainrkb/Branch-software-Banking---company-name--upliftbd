<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'Add Sales Officer';
$updateStatus = "";
$registration_info = "";
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);

if(isset($_POST['tpin'])){
    $tpin = $_POST['tpin'];
    $e_name = strtoupper($_POST['ename']);
    $e_contact = $_POST['econtact'];
    $ref_id = $_POST['ref_id'];
    $br_old_tpin = $branch_info['br_tpin'];
    
     if($br_old_tpin==$tpin){
        $mo_code = substr($e_contact,0,3);
        $m_operator_info = get_mobile_operator_info_by_code($mo_code);
         if($m_operator_info){	
            if(check_employee_info_by_contact_no($e_contact)){
                $updateStatus .= "<b>Employee already exists,Please try again.</b>";
            }else{
                $e_ref_id=$ref_id;
                $e_type='3';//Sales Officer   
                $password = generatePIN(8);
                $e_password = md5($password);
                $e_branch_id=$branch_id;
                $e_userid='SO'.$e_branch_id.$e_type.$e_ref_id.generatePIN(2).generatePIN(1);
                $add_employee=add_employee_info($e_userid,$e_name,$e_contact,$e_password,$e_branch_id,$e_type,$e_ref_id);
                if($add_employee){
                    $updateStatus .= "<b>Registration Success.</b>";
                    $registration_info.=  "Registration Success.";
                 }
            }
        }else{
            $updateStatus .= "<b>Please Input a valid mobile Number.</b>";
        }
 }else{
     $updateStatus .= 'Branch T-Pin Not Match.';
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
                        <h2><b><i class="fa fa-user"></i> <?php echo $pageName; ?> (SO)</b></h2> 
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
                                    <form id="form" action="" method="post" >
                                        <table class="table table-condensed text-left table-hover table-striped">
                                            <thead>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="4"><h3><b>Enter Employee Information Below</b></h3></td>
                                                </tr>
                                                <?php
                                                if($updateStatus){
                                                ?>
                                                <tr class="btn-default text-center">
                                                    <td class="btn-default" colspan="4">
                                                        <b style="color: red;">Message : <?php echo $updateStatus; ?></b>
                                                    </td>
                                                </tr>
                                                <?php }else{ ?>
                                                <tr class="text-center">
                                                    <td colspan="4">
                                                        <b style="color: #0088cc;">Please input the current information.</b>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if($registration_info){
                                                ?>
                                                <tr class="btn-default text-center">
                                                    <td class="btn-default" colspan="2">
                                                        <table class="table table-bordered table-condensed text-left table-hover table-striped">
                                                            <thead></thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-right"><b>Employee ID # :</b></td>
                                                                    <td class="text-left"><b><?php echo $e_userid; ?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right"><b>Employee Name :</b></td>
                                                                    <td class="text-left"><b><?php echo $e_name; ?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-right"><b>Contact Number :</b></td>
                                                                    <td class="text-left"><b><?php echo $e_contact; ?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2" class="text-center">
                                                                        <a href="add_so.php"><b><i class="fa fa-reply-all"></i> Add Another</b></a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr class="btn-danger">
                                                                    <td colspan="2"></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <?php 
                                                    //$sms_token = "c7236d9be5aa469ecd1ddae8e2856"; //teletalk
                                                    $to=$e_contact;
                                                    $sms_message = "Congratulations $e_name,Your Registration Success.\nLogin Info:\nEmployee ID: $e_userid\nPassword: $password \nVisit:$webUrl";
                                                    $sms_url = "http://sms.greenweb.com.bd/api.php";
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
                                                ?>
                                                <?php }else{ ?>
                                                
                                                <tr>
                                                    <td class="text-right text-info"><h5><b>Name :</b></h5></td>
                                                    <td><b><input class="form-control" type="text" name="ename" placeholder="Enter Employee Name" autocomplete="off" autofocus="off" required="" /></b></td>
                                                
                                                    <td class="text-right text-info"><h5><b>Contact :</b></h5></td>
                                                    <td><b><input class="form-control" type="text" name="econtact" placeholder="Enter Employee Contact"  minlength="11" maxlength="11" required="" /></b></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="text-right text-info"><h5><b>S.Executive :</b></h5></td>
                                                    <td><b>
                                                        <select class="form-control" name="ref_id" required="">
                                                            <option value="">Select Sales Executive</option>
                                                            <?php 
                                                                $type='2';
                                                                $branch_employee = get_branch_employee_by_type($type,$branch_id);
                                                                foreach ($branch_employee as $br_employee){
                                                                ?>
                                                                <option value="<?php echo $br_employee['e_id']; ?>"><?php echo $br_employee['e_userid'].' ('.$br_employee['e_name'].')'; ?></option>
                                                                <?php 
                                                                } 
                                                                ?>  
                                                        </select>
                                                        </b>
                                                    </td>
                                                    <td class="text-right text-info"><h5><b>Branch T-Pin :</b></h5></td>
                                                    <td><b><input class="form-control" type="password" name="tpin" placeholder="Enter 4-Digit Branch T-Pin"  minlength="4" maxlength="4" required="" /></b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-right">
                                                        <a href="cpanel.php" class="btn btn-danger pull-left"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                                        <button type="submit" class="btn btn-danger"><b><i class="fa fa-check-circle"></i> Register</b></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <?php } ?>
                                            <tfoot>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="4"><b></b></td>
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