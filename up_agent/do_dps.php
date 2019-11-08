<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'do dps';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);
$updateStatus = "";
$registration_info = "";

if(isset($_POST['br_tpin'])){
    $br_tpin = $_POST['br_tpin'];
if($br_tpin==$branch_info['br_tpin']){
    $amount = $_POST['amount'];
    $sponsor_id = $_POST['sponsor_id'];
    $package = $_POST['package'];
    $package_month = $_POST['package_month'];
    $open_date = $_POST['open_date'];
    $close_date = $_POST['close_date'];
    $code = $_POST['code'];
     $pac_info = get_dps_package_info_by_id($package);
    $branch_info = get_branch_info_by_id($branch_id);
    $sponsor_info = get_user_info_by_id($sponsor_id);
    if($sponsor_info&&$branch_info){
    if(check_user_verify($sponsor_id)){
         $updateStatus .= "<b style='color: red;'>This member isn't verified.</b><a class='btn btn-danger' href='v_member.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
  
        }else{
             if( ($amount < $pac_info['dpi_min_amount'] )  || ($amount > $pac_info['dpi_max_amount'] )){
                     $updateStatus .= "<b style='color: red;'>You have to put minimum TO maximum amount.</b><a class='btn btn-danger' href='do_dps.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
              }
            else{
                             $u_sponsor_id = $sponsor_info['u_id'];
            $results = add_dps($code, $sponsor_id, $package, $package_month, $amount, $open_date, $close_date, $branch_id) ;
            if($results){
                $updateStatus .= "<b style='color: red;'>DPS Done.</b>";
                $sponsor_info1 = get_user_info_by_id($sponsor_id);
            }
 else {
     $updateStatus .= "<b style='color: red;'> Failed.</b><a class='btn btn-danger' href='do_dps.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
 }   
        }
    }
 
}else{
        $updateStatus .= "<b style='color: red;'>Please Input Corrent Information.</b><a class='btn btn-danger' href='do_dps.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
    }
}else{
        $updateStatus .= "<b style='color: red;'>Agent T-Pin Not Match.</b><a class='btn btn-danger' href='do_dps.php'><b><i class='fa fa-recycle'></i> Try Again</b></a>";
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
                                                    <td colspan="4"><h3><b>Do DPS</b></h3></td>
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
                                                                                <td class="text-right"><b>Branch Name :</b></td>
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
                                                 <?php }else if(isset($_REQUEST['m_member'])&&isset($_REQUEST['dps_o_amount'])){ 
                                                    $m_sponsor=$_REQUEST['m_member'];
                                                    $dps_o_amount=$_REQUEST['dps_o_amount'];
                                                    $dps_pac=$_REQUEST['dps_pac'];
                                                    $d_o=$_REQUEST['open'];
                                                    $d_c=$_REQUEST['close'];
                                                    //$mo_code = substr($m_contact,0,3);
                                                    $today = time();
                                                    $twoMonthsLater = strtotime("+2 months", $today);
                                                         $mem_info = get_user_info_by_id($m_sponsor);
                                                         $package_info = get_dps_package_info_by_id($dps_pac);
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
                                                <?php }else{ ?>
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
                                                                        <td class="text-left"><b><?php echo $mem_info ['u_nid'];  ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Member Name</b></td>
                                                                        <td class="text-left"><b><?php echo $mem_info ['u_name']; ?></b></td>
                                                                        <td class="text-right"><b>Contact Number</b></td>
                                                                        <td class="text-left"><b><?php echo $mem_info['u_contact']  ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Installment Fee</b></td>
                                                                        <td class="text-left"><b><?php echo $dps_o_amount.".00 "?> BDT</b></td>
                                                                        <td class="text-right"><b>Your Balance</b></td>
                                                                        <td class="text-left"><b><?php echo $mem_info['u_balance'];?> BDT</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-right"><b>Open date</b></td>
                                                                        <td class="text-left"><b><?php echo $d_o ;?></b></td>
                                                                        <td class="text-right"><b>Close date</b></td>
                                                                        <td class="text-left"><b><?php echo $d_c;?></b></td>
                                                                    </tr>   
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <?php if( ($dps_o_amount < $package_info['dpi_min_amount'] )  || ($dps_o_amount > $package_info['dpi_max_amount'] )){
                                                        ?>
                                                <tr class="text-center">
                                                    <td class="text-danger" colspan="4">
                                                        <h2><b style='color: red;'>You have to put minimum TO maximum amount.</b></h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <a class="btn btn-default text-center" href="do_dps.php"><b><i class="fa fa-recycle"></i> Try again</b></a>
                                                    </td>
                                                </tr>   
                                                    <?php }
                                                    else{
                                                    ?>
                                            <form action="" method="post">
                                                    <input type="hidden" name="sponsor_id" value="<?php echo $m_sponsor; ?>" required="" />
                                                    <input type="hidden" name="amount" value="<?php echo $dps_o_amount; ?>" required="" />
                                                    <input type="hidden" name="package" value="<?php echo $dps_pac; ?>" required="" />
                                                    <input type="hidden" name="package_month" value="<?php echo $package_info['dpi_month']; ?>" required="" />
                                                    <input type="hidden" name="open_date" value="<?php echo $d_o; ?>" required="" />
                                                    <input type="hidden" name="close_date" value="<?php echo $d_c;?>" required="" />
                                                    <input type="hidden" name="code" value="<?php echo strtoupper(uniqid('DPS')); ?>" required="" />
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
                                                            <a class="btn btn-danger pull-left" href="do_dps.php"><b><i class="fa fa-reply-all"></i> Back</b></a>
                                                        </td>
                                                        <td class="text-right text-info">
                                                            <button type="submit" class="btn pull-right btn-danger"><b><i class="fa fa-arrow-circle-o-right"></i> Do DPS</b></button>
                                                        </td>
                                                    </tr>
                                                </form>
                                                    <?php  } } }
                                                else { ?>
                                                <form action="" method="post" >
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right" colspan="2">
                                                            <div id="get_amount"></div>
                                                        </td>
                                                    </tr>
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
                                                                            //$m_info = get_member_info_by_id($br_members['u_id']);
                                                                        ?>
                                                                        <option value="<?php echo $br_members['u_id']; ?>"><?php echo $br_members['u_userid'].'-'.$br_members['u_name']; ?></option>
                                                                        <?php 
                                                                          } }
                                                                        ?>  
                                                                </select>
                                                            </b><br>
                                                        </td>
                                                         <td class="text-right text-info"><h5><b>DPS Packages :</b></h5></td>
                                                        <td colspan="">
                                                            <b>
                                                                <select  class="select2  form-control" name="dps_pac" data-live-search="true" onChange="getamount(this.value);"  >
                                                                    <option value="">Select package</option>
                                                                    <?php 
                                                                        $dps_packages= get_all_dps_packages_by_status();
                                                                        if(count($dps_packages)>0){ 
                                                                        foreach ($dps_packages as $d_pac){
                                                                            //$m_info = get_member_info_by_id($br_members['u_id']);
                                                                        ?>
                                                                        <option value="<?php echo $d_pac['dpi_id']; ?>" ><?php echo $d_pac['dpi_month']." Months";?></option>
                                                                           <?php 
                                                                          } }
                                                                        ?>  
                                                                </select>
                                                            </b>
                                                        </td>   
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right text-info"><h5><b>DPS Amount:</b></h5></td>
                                                        <td colspan=""><b><input class="form-control" type="number" name="dps_o_amount" placeholder="Enter Amount" required="" autofocus="off" autocomplete="off" /></b></td>
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
                                                        <td class="text-right text-info"><h5><b>Open Date :</b></h5></td>
                                                        <td><b> 
                                                                <input type="text" placeholder="DPS open Date" name="open" class="form-control pull-right" id="datepicker"  data-date-format="yyyy-mm-dd" >
                                                            </b></td>
                                                        <td class="text-right text-info"><h5><b>Close Date :</b></h5></td>
                                                        <td><b>   
                                                                <input type="text" placeholder="DPS close date" name="close" class="form-control pull-right" id="datepicker1"  data-date-format="yyyy-mm-dd"  >
                                                            </b></td>
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
function getamount(val){
        $.ajax({
        type: "POST",
        url: "get_dps_package_info.php",
        data:'dps_package_id='+val,
        success: function(data){
                $("#get_amount").html(data);
        }
        });
}            
        </script>
    
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
    $('#datepicker1').datepicker({
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