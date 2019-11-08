<?php
session_start();
if(!isset($_SESSION['se_branch'])){
header("Location: login.php");
}else{
$pageName = 'Member Information';
include './includes/functions.php';
$branch_id = $_SESSION['se_branch']['br_id'];
$branch_info = get_branch_info_by_id($branch_id);

if(isset($_GET['info'])){
$info = $_GET['info'];
$dps_month_info = get_all_dps_list_by_ck($info);
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
       
        <!-- /. NAV SIDE  -->
                <div id="page-wrapper" >
                    <div id="page-inner">
                   
                         <!-- /. ROW  -->
                         <hr />
                       <div class="row">
                        <div class="col-md-12">
                            <!-- Form Elements -->
                            <div class="panel panel-default btn-default">
                                <div class="panel-body">
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-12">     
                                                     <div class="text-center  panel-heading">                                                           
                                                         <span class=""><b style="color: ">Total Month: <?php echo count($dps_month_info);?></b></span>
                                                        </div>
                                                    <div class="panel-body">  
                                                        <div class="table-responsive">
                                                                <table class="table table-bordered table-condensed table-striped table-hover text-center" id="abc">
                                                                    <thead>
                                                                        <tr class="btn-danger text-center">
                                                                            <td><span class="btn"><b>SL.</b></span></td>
                                                                            <td><span class="btn"><b>Month</b></span></td>
                                                                            <td><span class="btn"><b>Year</b></span></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                        $i=1;
                                                                        foreach ($dps_month_info as $d_info){
                                                                            $get_month = get_dps_month_info_by_id($d_info['udl_month']);
                                                                            $get_pack_info= get_dps_package_info_by_id($dps['udi_dps_id']);
                                                                        ?>
                                                                        <tr>
                                                                            <td><h5><?php echo $i;?></h5></td>     
                                                                            <td class="text-center"><h5><b><?php echo $get_month['dps_month_name']; ?></b></h5></td>
                                                                        <td class="text-center"><h5><b><?php echo $d_info['udl_year']; ?></b></h5></td>
                                                                        </tr>
                                                                        <?php $i++; } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr class="btn-danger text-center">
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
