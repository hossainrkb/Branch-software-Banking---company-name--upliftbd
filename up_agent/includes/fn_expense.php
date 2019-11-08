<?php
///////////////////eXPENSE/////////////////////
function get_all_expense_category(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_expense_category");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_expense_type_info_by_id($ex_type){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_expense_type WHERE ext_id='".$ex_type."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_expense_category_info_by_id($ex_category){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_expense_category WHERE ec_id='".$ex_category."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_branch_expense_history_by_branch_id($branch_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_branch_expense WHERE bex_branch='".$branch_id."' ORDER BY bex_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_branch_expense_history_by_branch_id_and_ex_category($branch_id,$ex_category){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_branch_expense WHERE bex_branch='".$branch_id."' AND bex_category='".$ex_category."' ORDER BY bex_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}







//////////////////////////////////////////////////////////////////////////////////////////////////////////

function add_user_expense_history($ex_user,$ex_category,$ex_amount,$ex_charge){
    $ex_date = date('Y-m-d');
    $ex_time = date('H:m:s');
    $ex_status='1';
    $ex_tnxId=strtoupper(uniqid('E'));
    //$ex_tnxId='E'.$ex_user.time();
    global $connection;
    $results = mysqli_query($connection,"INSERT INTO tbl_expense_history(ex_tnxId,ex_user,ex_category,ex_amount,ex_charge,ex_date,ex_time,ex_status) VALUES('".$ex_tnxId."','".$ex_user."','".$ex_category."','".$ex_amount."','".$ex_charge."','".$ex_date."','".$ex_time."','".$ex_status."')");
    if($results){
        return true;
    }
    return false;
}

function get_expense_history_info_by_id($ex_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_expense_history WHERE ex_id='".$ex_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_expense_history_info_by_txnId($ex_tnxId){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_expense_history WHERE ex_tnxId='".$ex_tnxId."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_user_expense_history_info_by_id($ex_id,$ex_user){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_expense_history WHERE ex_id='".$ex_id."' AND ex_user='".$ex_user."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}


function get_expense_history_by_userId_exType($user_id,$ex_type){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_expense_history WHERE ex_user='".$user_id."' AND ex_type='".$ex_type."' ORDER BY ex_id desc");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_expense_history_by_userId_exType_status($user_id,$ex_type,$ex_status){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_expense_history WHERE ex_user='".$user_id."' AND ex_type='".$ex_type."'AND ex_status='".$ex_status."' ORDER BY ex_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_todays_expense_history_by_user_id($user_id){
    $var = array();
    $ex_date = date('Y-m-d');
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_expense_history WHERE ex_user='".$user_id."' AND ex_date='".$ex_date."' ORDER BY ex_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_todays_expense_history_by_user_id_and_ex_type($user_id,$ex_type){
    $var = array();
    $ex_date = date('Y-m-d');
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_expense_history WHERE ex_user='".$user_id."' AND ex_type='".$ex_type."' AND ex_date='".$ex_date."' ORDER BY ex_id desc");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////
function get_all_branch_withdraw_request($branch_id){  
    $var = array();
    global $connection;
    $query = mysqli_query($connection,"SELECT * FROM  tbl_users_withdraw WHERE uwr_branch_id='".$branch_id."' ORDER BY uwr_status DESC");
    if($query){
        while($row = mysqli_fetch_array($query)){
            $var[] = $row;
        }
    }
    return $var;
}

function get_users_withdraw_info_by_branch_user_pin($branch_id,$user_id,$w_pin){   
    $var = array();
    $uwr_status='2';
    global $connection;
    $query = mysqli_query($connection,"SELECT * FROM  tbl_users_withdraw WHERE uwr_branch_id = '".$branch_id."' AND uwr_user_id = '".$user_id."' AND uwr_pin = '".$w_pin."' AND uwr_status = '".$uwr_status."'");
    if($query){
        $var = mysqli_fetch_array($query);
    }
    return $var;
}

function update_withdraw_info_status($branch_id,$user_id,$w_pin){   
    $var = array();
    $uwr_status='1';
    global $connection;
    $query = mysqli_query($connection,"UPDATE tbl_users_withdraw SET uwr_status='".$uwr_status."' WHERE uwr_branch_id = '".$branch_id."' AND uwr_user_id = '".$user_id."' AND uwr_pin = '".$w_pin."'");
    if($query) {
        return true;
    }
    return false;
}
?>