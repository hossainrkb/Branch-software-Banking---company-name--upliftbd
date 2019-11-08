<?php
include './includes/functions.php';
if(isset($_POST["sponsor_id"])){
    $sponsor_id=$_POST["sponsor_id"];
    $sponsor_info = get_user_info_by_user_id($sponsor_id);
    if($sponsor_info){
    ?>
        <b><i class="text-success fa fa-check-circle"></i></b>
    <?php      
    }else{
    ?>
    <b><i class="text-danger fa fa-close"></i></b>
<?php } }


if(isset($_POST["placement_id"])){
    $placement_id=$_POST["placement_id"];
    $placement_info = get_user_info_by_user_id($placement_id);
    if($placement_info){
        $placement_id_limit=get_placement_list_by_user_id($placement_info['u_id']);
        if(count($placement_id_limit)<10){
          ?>
          <b><i class="text-success fa fa-check-circle"></i></b>
        <?php
        }else{
        ?>
          <b>Limit Exists <i class="text-danger fa fa-close"></i></b>
        <?php
        }
    }else{
        ?>
          <b><i class="text-danger fa fa-close"></i></b>
    <?php
    } } ?>