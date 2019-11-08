<?php
    session_start();
    if(isset($_SESSION['se_branch'])){
    header("Location: cpanel.php");
}else{
    include './includes/common.php';
    include './includes/functions.php';
    $pageName = 'Agent Login';
    $messages = "";
if(isset($_POST['log_in'])){
        $br_code = $_POST['branch_code'];
        $password = $_POST['branch_pass'];
        $br_password = md5($password);
        $branch_info=check_branch_info_by_br_code($br_code);
    if($branch_info){
        if($branch_info['br_status']==0){
            $messages = "Branch Account Disabled.";
        }else{
        if(is_branch_login($br_code,$br_password)){
            $br_info = is_branch_login($br_code,$br_password);
            $_SESSION['se_branch'] = $br_info;
            header("Location: cpanel.php");
            //echo "<meta http-equiv='refresh' content='.5;url=myaccount.php'>";
        }else{
            $messages = "No Match For Agent Password.";
        }
    }
    }else{
        $messages = "No Match For Agent Code.";
    }
}
?>
﻿<!DOCTYPE html>
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
<body class="bg-danger">
    <div class="container">
        <br/><br/><hr/>
        <div class="row text-center ">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <!-- <img class="img" src="logo.png" /> -->
                <img class="img" src="logo.png" width="295" />
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row text-center ">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
        </div>
        
         <div class="row ">
             <div class="col-md-4">
                
             </div>
            <div class="col-md-4">
                  <div class="panel panel-default">
                    <table class="table">
                        <thead>
                            <tr class="btn-danger">
                                <td class="text-center"><h1 style="color: white;"><b>Agent Login</b></h1></td>
                            </tr>
                        </thead>
                    </table>
                    <div class="panel-body">
                      <?php 
                      if($messages){
                      ?>
                      <div class="row">
                          <div class="col-md-12">
                              <div class="alert alert-danger">
                                  <b><i class="fa fa-exclamation-circle"></i> <?php echo $messages; ?></b>
                              <button type="button" class="close" data-dismiss="alert">x</button>
                          </div>
                          </div>
                      </div>
                      <?php }?>
                            <form role="form" action="" method="post" enctype="multipart/form-data">
                                <b class="text-danger">Agent Code</b>
                                <div class="form-group input-group">
                                   <span class="input-group-addon"><i class="fa fa-user"  ></i></span>
                                   <b><input type="text" name="branch_code" class="form-control" placeholder="Your Branch Code" required="" autocomplete="off" /></b>
                                </div>
                                <b class="text-danger">Login Password</b>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                    <b><input type="password" name="branch_pass" class="form-control"  placeholder="Your Login Password" minlength="6" required=""/></b>
                                </div>
                                <button type="submit" name="log_in" class="btn btn-danger btn-block"><i class="fa fa-key"></i> <b>Login Now</b></button>
                            </form>
                      </div>
                      <div class="panel-footer text-center">
                          <b class="text-danger"><i class="fa fa-info-circle"></i> Forget password ?</b> <a href=""><span class="badge btn-danger"><b>Click Here</b></span></a>
                      </div>
                    </div>
                </div>     
                <div class="col-md-4">
                 
                </div>
        </div>
        <hr />
        <?php include './footer.php'; ?>
    </div>
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
