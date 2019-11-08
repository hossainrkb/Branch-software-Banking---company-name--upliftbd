<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'add member fund';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);
$updateStatus = "";
$registration_info = "";

if(isset($_POST['br_tpin'])){
    $br_tpin = $_POST['br_tpin'];
if($br_tpin==$branch_info['br_tpin']){
    $dep_cat = 1;
    $exp_cat = 6;
    $dep_from_id=0;
    $total_dep = $_POST['m_t_dep'];
    $sponsor_id = $_POST['sponsor_id'];
    $date = $_POST['m_date'];
    $time = $_POST['m_time'];
    $code = $_POST['code'];
    $a_exp = $_POST['agent_expance'];
    $a_income = $_POST['agent_income'];
    global $connection;
    $branch_info = get_branch_info_by_id($branch_id);
    $sponsor_info = get_user_info_by_id($sponsor_id);
    if($sponsor_info&&$branch_info){
    if(check_user_verify($sponsor_id)){
         $updateStatus .= "<b style='color: red;'>This member isn't verified.</b><a class='btn btn-danger' href='v_member.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
  
        }else{
              if($total_dep>$branch_info['br_amount']){
                     $updateStatus .= "<b style='color: red;'>Agent doesn't have this certain amount of money.</b><a class='btn btn-danger' href='member_fund_add.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
              }
            else{
                             $u_sponsor_id = $sponsor_info['u_id'];
            $results = add_deposite_history($code, $u_sponsor_id,$dep_from_id, $dep_cat, $branch_id, $total_dep, $date, $time);
            if($results){
                add_branch_expance_history($branch_id, $exp_cat, $total_dep, $date, $time, $a_exp);
                $a_commission=$total_dep*0.05;
                add_branch_income_history($branch_id, $u_sponsor_id, $dep_cat, $a_commission, $date, $time, $a_income);
                $total_sum= $sponsor_info['u_balance']+$total_dep;
                mysqli_query($connection,"UPDATE tbl_users_info SET u_balance='".$total_sum."' WHERE u_id='".$u_sponsor_id."'");
                $total_minus=$branch_info['br_amount']-$total_dep;
                mysqli_query($connection,"UPDATE tbl_branch_info SET br_amount='".$total_minus."' WHERE br_id='".$branch_id."'");
                $branch_info1 = get_branch_info_by_id($branch_id);
                $add_commission=$branch_info1['br_amount']+$a_commission;
                mysqli_query($connection,"UPDATE tbl_branch_info SET br_amount='".$add_commission."' WHERE br_id='".$branch_id."'");
                $updateStatus .= "<b style='color: red;'>Fund added successfully.</b>";
             $sponsor_info1 = get_user_info_by_id($sponsor_id);
            }
 else {
     $updateStatus .= "<b style='color: red;'> Failed.</b><a class='btn btn-danger' href='member_fund_add.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
 }   
        }
    }
 
}else{
        $updateStatus .= "<b style='color: red;'>Please Input Corrent Information.</b><a class='btn btn-danger' href='member_fund_add.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
    }
}else{
        $updateStatus .= "<b style='color: red;'>Branch T-Pin Not Match.</b><a class='btn btn-danger' href='member_fund_add.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
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
                    <div class="col-md-12">
                        <h2><b><i class="fa fa-edit"></i> <?php echo $pageName; ?></b></h2> 
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
                                    <div class="x_content">
                                    <table class="table table-condensed text-left">
                                            <thead>
                                                <tr class="btn-danger text-center">
                                                    <td colspan="4"><h3><b>Add member Fund</b></h3></td>
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
                                                                    <h2 style="color: whitesmoke;"><i class="fa fa-user"></i> <b>Member Information</b></h2>
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
                                                                                <td colspan="2" class="text-center"><b>Member ID : <?php echo $sponsor_info['u_userid']; ?></b></td>
                                                                            </tr>
                                                                            <tr></tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                                <td>
                                                                    <table class="table table-striped table-hover">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-right"><b>Member Name :</b></td>
                                                                                <td class="text-left"><b><?php echo $sponsor_info['u_name']; ?></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-right"><b>Mobile Number :</b></td>
                                                                                <td class="text-left"><b><?php echo $sponsor_info['u_contact']; ?></b></td>
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
                                                                                        <?php if($sponsor_info['u_status']==1){ echo '<span class="label label-success">Active</span>';} else{ echo '<span class="label label-danger">Deactive</span>'; } ?>
                                                                                        <?php if($sponsor_info1['u_verify']==1){ echo '<span class="label label-success">Verified</span>';} else{ echo '<span class="label label-danger">Unverified</span>'; } ?>
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
                                                        </tfoot>
                                                    </table>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                 <?php }else if(isset($_REQUEST['m_member'])&&isset($_REQUEST['m_fund'])){ 
                                                    $m_sponsor=$_REQUEST['m_member'];
                                                    $m_fund=$_REQUEST['m_fund'];
                                                         $mem_info = get_user_info_by_id($m_sponsor);
                                                         $dep_cat = get_deposit_cat();
                                                           if(check_user_verify($m_sponsor)){
                                                     ?>
                                                    <tr class="text-center">
                                                    <td class="text-danger" colspan="4">
                                                        <h2><b style='color: red;'>This member isn't verify yet.</b></h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <a class="btn btn-default text-center" href="v_member.php"><b><i class="fa fa-recycle"></i> Click here to verify</b></a>
                                                    </td>
                                                </tr>
                                                <?php }else{
                                                    if($m_fund>$branch_info['br_amount']){
                                                        ?>
                                                     <tr class="text-center">
                                                    <td class="text-danger" colspan="4">
                                                        <h2><b style='color: red;'>Agent doesn't have this certain amount of money.</b></h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <a class="btn btn-default text-center" href="member_fund_add.php"><b><i class="fa fa-recycle"></i> Try again</b></a>
                                                    </td>
                                                </tr>    
                                                    <?php
                                                    }
                                                    else{
                                                    ?>
                                            <form action="" method="post">
                                                <input type="hidden" name="sponsor_id" value="<?php echo $m_sponsor; ?>" required="" />
                                                    <input type="hidden" name="m_cat" value="<?php echo $m_cat; ?>" required="" />
                                                    <input type="hidden" name="m_t_dep" value="<?php echo $m_fund; ?>" required="" />
                                                    <input type="hidden" name="m_date" value="<?php echo date('Y-m-d'); ?>" required="" />
                                                    <input type="hidden" name="m_time" value="<?php echo date('H:m:s');?>" required="" />
                                                    <input type="hidden" name="code" value="<?php echo strtoupper(uniqid('D')); ?>" required="" />
                                                    <input type="hidden" name="agent_expance" value="<?php echo strtoupper(uniqid('AE')); ?>" required="" />
                                                    <input type="hidden" name="agent_income" value="<?php echo strtoupper(uniqid('AI')); ?>" required="" />
                                                    <tr>
                                                        <td colspan="2">
                                                            <table  class=" table table-condensed table-bordered text-center">
                                                                <thead>
                                                                    <tr class="btn-danger">
                                                                        <td colspan="4"><b>Member Information</b></td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan=" 2" class="text-right"><b>Agent info</b></td>
                                                                        <td colspan="2" class="text-left"><b><?php echo $branch_info['br_name'].' ('.$branch_info['br_code'].')'; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Member ID</b></td>
                                                                        <td class="text-left"><b><?php echo $mem_info ['u_userid']; ?></b></td>
                                                                        <td class="text-right"><b>National ID</b></td>
                                                                        <td class="text-left"><b><?php echo $mem_info['u_nid'] ; ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Member Name</b></td>
                                                                        <td class="text-left"><b><?php echo $mem_info ['u_name']; ?></b></td>
                                                                        <td class="text-right"><b>Contact Number</b></td>
                                                                        <td class="text-left"><b><?php echo $mem_info['u_contact']  ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Deposit Category</b></td>
                                                                        <td class="text-left"><b><?php echo $dep_cat['dc_name']; ?></b></td>
                                                                        <td class="text-right"><b>Total Deposit</b></td>
                                                                        <td class="text-left"><b><?php echo $m_fund ?>.00 BDT</b> </td>
                                                                    </tr>     
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                             <label class="btn pull-right text-info"><b><input type="checkbox" required="" /> Confirm</b></label>
                                                        </td>
                                                        <td colspan="" class="text-center">
                                                            <b><input type="password" name="br_tpin" minlength="4" maxlength="4" placeholder="Enter Agent T-Pin" required="" autocomplete="off" autofocus="off"  /></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a class="btn btn-danger pull-left" href="member_fund_add.php"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                                        </td>
                                                        <td class="text-right text-info">
                                                            <button type="submit" class="btn pull-right btn-danger"><b><i class="fa fa-arrow-circle-o-right"></i> Add Fund</b></button>
                                                        </td>
                                                    </tr>
                                                </form>
                                                    <?php } }  }
                                                else { ?>
                                                <form action="" method="post" >
                                                    <tr>
                                                        <td class="text-right text-info"><h5><b>Member ID :</b></h5></td>
                                                        <td colspan="">
                                                            <b>
                                                                <select  class="select2  form-control" name="m_member" data-live-search="true" required="" >
                                                                    <option value="">Select Member</option>
                                                                    <?php 
                                                                        $branch_members= get_all_branch_members($branch_info['br_id']);
                                                                        if(count($branch_members)>0){ 
                                                                        foreach ($branch_members as $br_members){
                                                                        ?>
                                                                        <option value="<?php echo $br_members['u_id']; ?>"><?php echo $br_members['u_userid'].'-'.$br_members['u_name']; ?></option>
                                                                        <?php 
                                                                          } }
                                                                        ?>  
                                                                </select>
                                                            </b>
                                                        </td>
                                                         <td class="text-right text-info"><h5><b>Category :</b></h5></td>
                                                        <td colspan="">
                                                            <b>
                                                                <select  class="select2  form-control" name="m_dep_cat" data-live-search="true" disabled="" >
                                                                    <option value="">Deposit Category</option>
                                                                    <?php 
                                                                        $dep_cat= get_all_deposit_category();
                                                                        if(count($dep_cat)>0){ 
                                                                        foreach ($dep_cat as $cat){
                                                                        ?>
                                                                        <option value="<?php echo $cat['dc_id']; ?>"  <?php if($cat['dc_id']==1){ echo 'selected';} ?>   ><?php echo $cat['dc_name'];?></option>
                                                                           <?php 
                                                                          } }
                                                                        ?>  
                                                                </select>
                                                            </b>
                                                        </td>   
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right text-info"><h5><b>Add Fund:</b></h5></td>
                                                        <td colspan=""><b><input class="form-control" type="number" name="m_fund" placeholder="Enter Fund" required="" autofocus="off" autocomplete="off" /></b></td>
                                                    <td class="text-right text-info"><h5><b>Agent :</b></h5></td>
                                                        <td>
                                                            <b>
                                                                <select class="form-control" name="m_branch" required="" disabled="" >
                                                                    <option value="">Select Agent</option>
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
    
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
    
    
    
    
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