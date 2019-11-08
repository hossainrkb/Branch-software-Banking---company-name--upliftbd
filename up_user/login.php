<?php
    session_start();
    if(isset($_SESSION['user'])){
    header("Location: cpanel.php");
}else{
    include './includes/common.php';
    include './includes/functions.php';
    $pageName = 'Member Login';
    $messages = "";
if(isset($_POST['log_in'])){
        $user_id = $_POST['user_id'];
        $password = $_POST['user_pass'];
        $u_password = md5($password);
        $user_info=check_user_info($user_id);
    if($user_info){
        if($user_info['u_status']==0){
            $messages = "Account has been Locked.";
        }else{
        if(is_user_login($user_id,$u_password)){
            $user = is_user_login($user_id,$u_password);
            $_SESSION['user'] = $user;
            header("Location: cpanel.php");
            //echo "<meta http-equiv='refresh' content='.5;url=myaccount.php'>";
        }
        else{
            $messages = "No Match For Password.";
        }
    }
    }else{
        $messages = "No Match For Member ID.";
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
<body class="bg-danger">
    <div class="container">
        <br/><hr/>
        <div class="row text-center ">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <!-- <img class="img" src="logo.png" /> -->
                <h1 class="text-danger"><b><?php echo $WebsiteSiteName; ?></b></h1>
            </div>
            <div class="col-md-4"></div>
        </div>
        
         <div class="row ">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                  <div class="panel panel-default">
                    <table class="table">
                        <thead>
                            <tr class="btn-danger">
                                <td class="text-center"><h1 style="color: white;"><b>Member Login</b></h1></td>
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
                                <b class="text-danger">Member ID</b>
                                <div class="form-group input-group">
                                   <span class="input-group-addon"><i class="fa fa-user"  ></i></span>
                                   <b><input type="text" name="user_id" class="form-control" placeholder="Your Member ID" required="" autocomplete="off" maxlength="11" /></b>
                                </div>
                                <b class="text-danger">Login Password</b>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                    <b><input type="password" name="user_pass" class="form-control"  placeholder="Your Login Password" minlength="6" required=""/></b>
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" /> <b class="text-danger">Remember me</b>
                                    </label>
                                    <span class="pull-right">
                                        <a class="text-danger" href="forgotten.php" ><b>Forget password ?</b></a> 
                                    </span>
                                </div>
                                <button type="submit" name="log_in" class="btn btn-danger btn-block"><i class="fa fa-key"></i> <b>Login Now</b></button>
                            </form>
                      </div>
                      <div class="panel-footer text-center"></div>
                    </div>
              </div>  
            <div class="col-md-4"></div>
        </div>
        <hr/>
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
