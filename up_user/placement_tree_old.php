<?php
session_start();
if(!isset($_SESSION['user'])){
header("Location: login.php");
}else{
include './includes/functions.php';
$pageName = 'My Placement Tree';
$user_id = $_SESSION['user']['u_id'];
$user_info = get_user_info_by_id($user_id);
$user_type=get_users_type_info_by_id($user_info['u_type']);
$user_branch=get_branch_info_by_id($user_info['u_branch_id']);
$reseller_list = get_placement_list_by_user_id($user_id);
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
    <link rel="stylesheet" href="assets/css/hierarchy-view.css">
</head>
<body>
    <?php include './navtop.php'; ?> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2><b><i class="fa fa-tree"></i> My Placement Tree</b></h2>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default bg-color-red" style="font-family: monospace;">
                    <div class="panel-body">
                        <!--Management Hierarchy-->
                        <section class="management-hierarchy">
                            <div class="hv-container">
                                <div class="hv-wrapper">
                                    <!-- Key component -->
                                    <div class="hv-item">
                                        <div class="hv-item-parent">
                                            <div class="person btn btn-default">
                                                <?php
                                                if(base64_encode($user_info['u_image'])){
                                                ?>
                                                <img class="img img-thumbnail img-circle" src="data:image/jpg;base64,<?php echo base64_encode($user_info['u_image']); ?>" alt="No Image" width="100" height="100" />
                                                <?php }else{ ?>
                                                <img class="img img-thumbnail img-circle" src="user.png" width="100" height="100" />
                                                <?php } ?>
                                                <br/>
                                                <?php 
                                                if($user_id==1){
                                                ?>
                                                <a class="btn" href="p_tree.php?u_id=<?php echo $user_info['u_id']; ?>"><b><?php echo $user_info['u_userid']; ?></b> </a>
                                                <?php }else{ ?>
                                                <b><?php echo $user_info['u_userid']; ?></b> 
                                                <?php } ?>
                                                <br/>
                                                <b class="text-success"><?php echo $user_type['ut_type']; ?></b>
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
                                            </div>
                                        </div>
                                        <div class="hv-item-children">
                                            <?php 
                                            $placement_tree=get_placement_list_by_user_id($user_info['u_id']);
                                            foreach ($placement_tree as $placement){
                                                $member_type=get_users_type_info_by_id($placement['u_type']);
                                            ?>
                                            <div class="hv-item-child">
                                                <div class="person">
                                                    <?php
                                                    if(base64_encode($placement['u_image'])){
                                                    ?>
                                                    <img class="img img-thumbnail img-circle" src="data:image/jpg;base64,<?php echo base64_encode($placement['u_image']); ?>" alt="No Image"  width="70" height="70" />
                                                    <?php }else{ ?>
                                                    <img class="img img-thumbnail img-circle" src="user.png" width="70" height="70" />
                                                    <?php } ?>
                                                    <br/>
                                                    <p class="btn btn-default">
                                                        <?php 
                                                        if($user_id==1){
                                                        ?>
                                                        <a class="btn" href="p_tree.php?u_id=<?php echo $placement['u_id']; ?>"><b><?php echo $placement['u_userid']; ?></b> </a>
                                                        <?php }else{ ?>
                                                        <b><?php echo $placement['u_userid']; ?></b> 
                                                        <?php } ?>
                                                        <br/>
                                                        <b class="text-success"><?php echo $member_type['ut_type']; ?></b>
                                                    </p>
                                                </div>
                                            </div>
                                            <?php } ?>                                            
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <?php include './footer.php'; ?>
        </div>
    </div>
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
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
