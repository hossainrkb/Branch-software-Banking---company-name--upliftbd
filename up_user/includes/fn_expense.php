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

/*
function add_user_expense_history($ex_user,$ex_category,$ex_amount,$ex_charge){
    $ex_date = date('Y-m-d');
    $ex_time = date('H:m:s');
    $ex_status='1';
    $ex_tnxId=strtoupper(uniqid('E'));
    //$ex_tnxId='E'.$ex_user.time();
    $results = mysqli_query("INSERT INTO tbl_expense_history(ex_tnxId,ex_user,ex_category,ex_amount,ex_charge,ex_date,ex_time,ex_status) VALUES('".$ex_tnxId."','".$ex_user."','".$ex_category."','".$ex_amount."','".$ex_charge."','".$ex_date."','".$ex_time."','".$ex_status."')");
    if($results){
        return true;
    }
    return false;
}
*/

function add_user_expense_history($ex_user,$ex_to_ac,$ex_category,$ex_amount,$ex_charge,$ex_tnxId){
    $ex_date = date('Y-m-d');
    $ex_time = date('H:m:s');
    $ex_status='1';
    //$ex_tnxId=strtoupper(uniqid('E'));
    //$ex_tnxId='E'.$ex_user.time();
    global $connection;
    $results = mysqli_query($connection,"INSERT INTO tbl_expense_history(ex_tnxId,ex_user,exp_to_id,ex_category,ex_amount,ex_charge,ex_date,ex_time,ex_status) VALUES('".$ex_tnxId."','".$ex_user."','".$ex_to_ac."','".$ex_category."','".$ex_amount."','".$ex_charge."','".$ex_date."','".$ex_time."','".$ex_status."')");
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

function get_all_expense_history_by_user_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_expense_history WHERE ex_user='".$user_id."' ORDER BY ex_id desc");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
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

function get_all_expense_history_by_user_id_and_ex_category($user_id,$ex_category){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_expense_history WHERE ex_user='".$user_id."' AND ex_category='".$ex_category."' ORDER BY ex_id DESC");
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
//////////////////////////////////////////////////////////////
function get_dps_package_details_info_by_id($dpi_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_dps_package_info WHERE dpi_id='".$dpi_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}
?>
