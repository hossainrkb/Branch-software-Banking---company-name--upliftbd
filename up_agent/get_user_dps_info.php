<?php  
include './includes/functions.php';
    if(isset($_POST["user_id"])){
    $user_id=$_POST["user_id"];
      }
    ?>  
<html>
<head>
</head>
<body class="text-center">
   <select class="form-control select2" name="" required="">
       <option value="">Select DPS</option>
        <?php 
        $get_uni= get_dps_info_by_user_id($user_id);
        foreach ($get_uni as $uni){
        ?>
        <option value="<?php echo $uni['udi_id']; ?>"><?php echo $uni['udi_dps_no']; ?></option>
        <?php }?>
</select>
</body>
</html>