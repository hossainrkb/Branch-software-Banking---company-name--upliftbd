<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: index.php");
}else{           
include './includes/functions.php';
$user_id = $_SESSION['user']['u_id'];
$status = "";
 if(isset($_POST['change_image'])){
        $u_id= $_POST['u_id'];
        $usr_id= $_POST['user_id'];
        $loc="assets/img/members/";
        $p=pathinfo($_FILES['userfile']['name']);
        $ext=$p['extension'];
        $filename=$usr_id.'.'.$ext;
        $tmpName=$_FILES['userfile']['tmp_name'];
        //for images
        $filepath=$loc . $filename;
        $result=move_uploaded_file($tmpName,$filepath);
        if($result)
        {
            $res = mysql_query("UPDATE tbl_users_info SET u_picture='".$filename."' WHERE u_id='".$u_id."' ");
            $status .= 'Picture Successfully Changed.';
        }
        else{
             $status .= "Error File Uploading,File Size Max: 60 kb";
            // header("Location:students_details.php?student_id=$s_id");
        }
}
$user_info = get_user_info_by_id($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Picture</title>
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
    <script>
            function confirm_update() //delete Confirmation
            {
              if (confirm("Are you sure you want to Change Picture?")==true)
                return true;
              else
                return false;
            }

            function active_validate() //status change confirmation
              {
              if(confirm("Are You sure want to status is changed?")==true)
                 return true;
               else  
                return false;
              }//end of status change validation
    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">  
                <h1 class="text-danger text-center"><b><?php echo $WebsiteSiteName; ?></b></h1>
                <hr/>
                <table class="table table-condensed table-striped table-hover text-center">
                    <thead>
                        <tr class="btn-danger">
                            <th colspan="3"><i class="fa fa-info-circle"></i> UPDATE MEMBER'S PICTURE
                                <span class="pull-right">
                                    <?php 
                                        if($user_info['u_status']==1){
                                            echo '<span class="badge"><b class="text-success">Login Status : ACTIVE</b></span>';
                                        }else{
                                            echo '<span class="badge"><b class="text-danger">Login Status : INACTIVE</b></span>';
                                        }
                                        ?>
                                </span>
                            </th>
                        </tr>
                        <tr>
                            <td colspan="3"><b class='text-danger'><i class="fa fa-warning"></i> Please Select a valid picture (.jpg,.png etc image & size must be less then or equal 60 kb).</b></td>
                        </tr>
                        <tr class="btn-info">
                            <th class="text-center" colspan="3"><i class="fa fa-info-circle"></i> MEMBER 'S INFORMATION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!$status){ ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <tr>
                                <td></td>
                                <td class="text-center"><b>NEW PICTURE PREVIEW</b></td>
                                <td class="text-center"><b>CURRENT PICTURE</b></td>
                            </tr>
                            <tr>
                                <td class="text-right"><b></b></td>
                                <td>
                                    <img class="img-thumbnail" id="uploadPreview1" src="assets/img/members/member.jpg" width="100" height="100" /> 
                                </td>
                                <th class="text-center">
                                    <?php
                                    if($user_info['u_picture']){
                                    ?>
                                    <img class="img-thumbnail" src="assets/img/members/<?php echo $user_info['u_picture']; ?>" alt="<?php echo $user_info['u_name'];?>" width="100" height="100" />
                                    <?php }else{ ?>
                                    <img class="img-thumbnail" src="assets/img/members/member.jpg" width="100" height="100" /> 
                                    <?php } ?>
                                </th>
                            </tr>
                                                       
                            <tr>
                                <td class="text-right"><b>NEW PICTURE :</b></td>
                                <td class="text-left" colspan="2">
                                    <input type="hidden" name="u_id" value="<?php echo $user_info['u_id']; ?>" required="" />
                                    <input type="hidden" name="user_id" value="<?php echo $user_info['u_userid']; ?>" required="" />
                                    <input type="hidden" name="MAX_FILE_SIZE" value="63500" />
                                    <input class="btn btn-default" id="uploadImage1" type="file" name="userfile" onchange="PreviewImage(1);" required="" />
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <button type="button" class="btn btn-sm btn-danger pull-left" onClick="window.close();window.opener.location.reload();">
                                        <i class="fa fa-close"> <b>Close</b></i>
                                    </button>
                                </td>
                                <td><b></b></td>
                                <td class="text-right">
                                    <input class="btn btn-sm btn-primary pull-center" type="submit" name="change_image" value="Change Picture" onClick="return confirm_update();">
                                </td>
                            </tr>
                           </form>
                        <?php }else{ ?>
                        <tr>
                            <td colspan="3">
                                <?php echo $status; ?>
                                <button type="button" class="btn btn-sm btn-danger pull-right" onClick="window.close();window.opener.location.reload();">
                                    <i class="fa fa-close"> <b>Close</b></i>
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                            
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="btn-info" colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>  
        </div>   
    </div>
    <script type="text/javascript">
    function PreviewImage(no) {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage"+no).files[0]);
        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview"+no).src = oFREvent.target.result;
        };
    }
    </script>
</body>

</html>
<?php } ?>