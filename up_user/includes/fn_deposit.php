<?php
///////////////////DEPOSIT/////////////////////
function add_users_spot_commission($dep_user,$dep_from_id,$dep_amount){
    $dep_category='2';
    $dep_date = date('Y-m-d');
    $dep_time = date('H:m:s');
    $dep_tnxId=strtoupper(uniqid('D'));
    //$mbt_check_key=$mbt_user.time();
    //$dep_tnxId='D'.$dep_user.time();
    $dep_status='1';
    global $connection;
    $results = mysqli_query($connection,"INSERT INTO tbl_deposit_history(dep_tnxId,dep_user,dep_from_id,dep_category,dep_amount,dep_date,dep_time,dep_status) VALUES('".$dep_tnxId."','".$dep_user."','".$dep_from_id."','".$dep_category."','".$dep_amount."','".$dep_date."','".$dep_time."','".$dep_status."')");
    if($results){
        return true;
    }
    return false;
}

function add_users_team_commission($dep_user,$dep_from_id,$dep_amount){
    $dep_category='3';
    $dep_date = date('Y-m-d');
    $dep_time = date('H:m:s');
    $dep_tnxId=strtoupper(uniqid('D'));
    //$mbt_check_key=$mbt_user.time();
    //$dep_tnxId='D'.$dep_user.time();
    $dep_status='1';
    global $connection;
    $results = mysqli_query($connection,"INSERT INTO tbl_deposit_history(dep_tnxId,dep_user,dep_from_id,dep_category,dep_amount,dep_date,dep_time,dep_status) VALUES('".$dep_tnxId."','".$dep_user."','".$dep_from_id."','".$dep_category."','".$dep_amount."','".$dep_date."','".$dep_time."','".$dep_status."')");
    if($results){
        return true;
    }
    return false;
}

function add_users_branch_sell_commission($dep_user,$dep_amount){
    $dep_category='9';
    $dep_from_id='0';
    $dep_date = date('Y-m-d');
    $dep_time = date('H:m:s');
    $dep_tnxId=strtoupper(uniqid('D'));
    $dep_status='1';
    global $connection;
    $results = mysqli_query($connection,"INSERT INTO tbl_deposit_history(dep_tnxId,dep_user,dep_from_id,dep_category,dep_amount,dep_date,dep_time,dep_status) VALUES('".$dep_tnxId."','".$dep_user."','".$dep_from_id."','".$dep_category."','".$dep_amount."','".$dep_date."','".$dep_time."','".$dep_status."')");
    if($results){
        return true;
    }
    return false;
}

function add_company_funds($cf_user_id,$cf_type,$cf_amount){
    $cf_add_date = date('Y-m-d');
    $cf_add_time = date('H:m:s');
    $cf_status='1';
    //$cf_tnxId=strtoupper(uniqid('D'));
    global $connection;
    $results = mysqli_query($connection,"INSERT INTO tbl_company_funds(cf_user_id,cf_type,cf_amount,cf_add_date,cf_add_time,cf_status) VALUES('".$cf_user_id."','".$cf_type."','".$cf_amount."','".$cf_add_date."','".$cf_add_time."','".$cf_status."')");
    if($results){
        return true;
    }
    return false;
}

function add_branch_commission($bc_user_id,$bc_branch_id,$bc_amount){
    $bc_add_date = date('Y-m-d');
    $bc_add_time = date('H:m:s');
    $bc_category='7';
    $bc_status='1';
    $bc_tnxId=strtoupper(uniqid('BI'));
    global $connection;
    $results = mysqli_query($connection,"INSERT INTO tbl_branch_income(bc_user_id,bc_branch_id,bc_category,bc_amount,bc_add_date,bc_add_time,bc_tnxId,bc_status) VALUES('".$bc_user_id."','".$bc_branch_id."','".$bc_category."','".$bc_amount."','".$bc_add_date."','".$bc_add_time."','".$bc_tnxId."','".$bc_status."')");
    if($results){
        return true;
    }
    return false;
}
/*
function add_user_deposit_history($dep_user,$dep_category,$dep_agent,$dep_from_acc,$dep_to_acc,$dep_amount_bdt,$dep_amount_usd,$dep_charge,$dep_status,$dep_note){
    $dep_date = date('Y-m-d');
    $dep_time = date('H:m:s');
    $dep_tnxId='D'.$dep_user.time();
    //$dep_tnxId=strtoupper(uniqid('D'));
    //$mbt_check_key=$mbt_user.time();
    $u_status='1';
    $results = mysqli_query("INSERT INTO tbl_deposit_history(dep_tnxId,dep_date,dep_time,dep_user,dep_category,dep_agent,dep_from_acc,dep_to_acc,dep_amount_bdt,dep_amount_usd,dep_charge,dep_status,dep_note) VALUES('".$dep_tnxId."','".$dep_date."','".$dep_time."','".$dep_user."','".$dep_category."','".$dep_agent."','".$dep_from_acc."','".$dep_to_acc."','".$dep_amount_bdt."','".$dep_amount_usd."','".$dep_charge."','".$dep_status."','".$dep_note."')");
    if($results){
        $update_status=update_user_status($dep_user,$u_status);
        if($update_status){
            return true;
        }
    }
    return false;
}
*/

function add_user_deposit_history($dep_user,$dep_from_id,$dep_category,$dep_amount,$dep_status,$dep_tnxId){
    $dep_date = date('Y-m-d');
    $dep_time = date('H:m:s');
    global $connection;
    $results = mysqli_query($connection,"INSERT INTO tbl_deposit_history(dep_tnxId,dep_user,dep_from_id,dep_category,dep_amount,dep_date,dep_time,dep_status) VALUES('".$dep_tnxId."','".$dep_user."','".$dep_from_id."','".$dep_category."','".$dep_amount."','".$dep_date."','".$dep_time."','".$dep_status."')");
    if($results){
        return true;
    }
    return false;
}

function get_all_deposit_category(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_deposit_category");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_deposit_category_info_by_id($d_category){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_deposit_category WHERE dc_id='".$d_category."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_all_deposit_history_by_user_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_deposit_history WHERE dep_user='".$user_id."' ORDER BY dep_id desc");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_all_deposit_history_by_user_id_and_dep_category($user_id,$dep_category){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_deposit_history WHERE dep_user='".$user_id."' AND dep_category='".$dep_category."' ORDER BY dep_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_deposit_history_info_by_id($dep_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_deposit_history WHERE dep_id='".$dep_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_user_deposit_history_info_by_id($dep_id,$dep_user){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_deposit_history WHERE dep_id='".$dep_id."' AND dep_user='".$dep_user."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_deposit_history_by_user_id_dep_type_status($user_id,$dep_type,$dep_status){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_deposit_history WHERE dep_user='".$user_id."' AND dep_category='".$dep_type."' AND dep_status='".$dep_status."' ORDER BY dep_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_todays_deposit_history_by_user_id($user_id){
    $var = array();
    $dep_date = date('Y-m-d');
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_deposit_history WHERE dep_user='".$user_id."' AND dep_date='".$dep_date."' ORDER BY dep_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

?>
