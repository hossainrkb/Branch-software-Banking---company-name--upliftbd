<?php
include './includes/common.php';
include './includes/dbconnect.php';
include './includes/fn_expense.php';
include './includes/fn_deposit.php';
include './includes/fn_users.php';
include './includes/fn_admin.php';
//include './includes/fn_ajax.php';
///////////////////////////////////////////////////////////////////////////////
function generatePIN($digits = 4){
    $i = 0; //counter
    $tpin = ""; //our default pin is blank.
    while($i < $digits){
        //generate a random number between 0 and 9.
        $tpin .= mt_rand(0, 9);
        $i++;
    }
    return $tpin;
}

function get_all_company_offers(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_company_offers ORDER BY co_id ASC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_company_offers_info_by_id($offer_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_company_offers WHERE co_id='".$offer_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_all_users_offers_user_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_offers WHERE uo_user_id='".$user_id."'");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_all_branch_list(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_branch_info");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_branch_info_by_id($branch_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_branch_info WHERE br_id='".$branch_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_all_branch_product_list_by_branch_id($branch_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_branch_products WHERE bp_branch = '".$branch_id."' ORDER BY bp_id ASC ");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}


function update_branch_balance_plus($branch_id,$br_amount){
    $branch_info= get_branch_info_by_id($branch_id);
    $br_balance=$branch_info['br_amount']+$br_amount;
    global $connection;
    $result=mysqli_query($connection,"UPDATE tbl_branch_info SET br_amount='".$br_balance."' WHERE br_id='".$branch_id."'");
    if ($result) {
        return true;
    }
    return false;
}

function update_branch_balance_minus($branch_id,$br_amount){
    $branch_info= get_branch_info_by_id($branch_id);
    $br_balance=($branch_info['br_amount']-$br_amount);
    global $connection;
    $result=mysqli_query($connection,"UPDATE tbl_branch_info SET br_amount='".$br_balance."' WHERE br_id='".$branch_id."'");
    if ($result) {
        return true;
    }
    return false;
}


/////////////////////////////// M BANKING //////////////////////////////////////////////////
function user_m_banking_transation($mbt_user,$mbt_ac_no,$mbt_agent,$mbt_amount){
    $mbt_ac_type = "1";
    $mbt_status = "1";
    $mbt_date = date('Y-m-d');
    $mbt_check_key=$mbt_user.time();
    global $connection;
    $results = mysqli_query($connection,"INSERT INTO mb_transaction(mbt_user,mbt_ac_no,mbt_agent,mbt_ac_type,mbt_amount,mbt_date,mbt_check_key,mbt_status) VALUES('".$mbt_user."','".$mbt_ac_no."','".$mbt_agent."','".$mbt_ac_type."','".$mbt_amount."','".$mbt_date."','".$mbt_check_key."','".$mbt_status."')");
    if($results){
        return true;
    }
    return false;
}

function user_m_banking_transation_history_by_user_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM mb_transaction WHERE mbt_user='".$user_id."' ORDER BY  mbt_id desc");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_all_mobile_banking_agent(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM mb_agent WHERE mba_status=1");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_mobile_banking_agent_info_by_id($mb_agent){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM mb_agent WHERE mba_id='".$mb_agent."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_all_mobile_banking_agent_type(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM mb_agent_type WHERE mbat_status=1");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_mobile_banking_agent_type_by_id($mb_agent_type){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM mb_agent_type WHERE mbat_id='".$mb_agent_type."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_all_mobile_banking_agent_offers(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM mb_agent_offer ORDER BY moo_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_all_mobile_banking_agent_offers_by_operator_id($mo_agent){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM mb_agent_offer WHERE moo_operator='".$mo_agent."' ORDER BY moo_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}
//////////////////////////////MOBILE RECHARGE///////////////////////////////////
function get_all_mobile_operator(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM m_operator WHERE mo_status=1 ORDER BY mo_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_mobile_operator_info_by_code($mo_code){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_mobile_operator WHERE mo_code='".$mo_code."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_mobile_operator_info_by_id($mo_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM m_operator WHERE mo_id='".$mo_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_all_mobile_operator_type(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM m_operator_type WHERE mot_status=1");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_mobile_operator_type_info_by_id($mo_type){
    $user = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM m_operator_type WHERE mot_id='".$mo_type."'");
    if($results){
        $user = mysqli_fetch_array($results);
    }
    return $user;
}

function user_mobile_recharge($m_user,$m_no,$m_type,$m_amount){
    $mr_status = "1";
    $mr_date = date('Y-m-d');
    global $connection;
    $mr_check_key=$m_user.$m_no.$m_type.$m_amount. date('dmy');
    $results = mysqli_query($connection,"INSERT INTO m_recharge(mr_user,mr_number,mr_amount,mr_type,mr_date,mr_status,mr_check_key) VALUES('".$m_user."','".$m_no."','".$m_amount."','".$m_type."','".$mr_date."','".$mr_status."','".$mr_check_key."')");
    if($results){
        return true;
    }
    return false;
}

function user_mobile_recharge_history_by_user_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM m_recharge WHERE mr_user='".$user_id."' ORDER BY  mr_id desc");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_all_mobile_operator_offers(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM m_operator_offer ORDER BY moo_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_all_mobile_operator_offers_by_operator_id($mo_agent){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM m_operator_offer WHERE moo_operator='".$mo_agent."' ORDER BY moo_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function get_all_newsletter(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_newsletter ORDER BY ecn_id DESC LIMIT 0,50");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function get_newsletter_by_status($ecn_status){
    $var = array();
    global $connection;
    mysqli_query($connection,'SET character_set_results=utf8');
    $results = mysqli_query($connection,"SELECT * FROM tbl_newsletter WHERE ecn_status='".$ecn_status."' ORDER BY ecn_id DESC");
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
