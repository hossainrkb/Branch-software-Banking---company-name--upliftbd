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
function get_all_expense_history(){
    $var = array();
     global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_expense_history  order by ex_id desc   ");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}



function add_agent_withdraw_request($w_branch,$w_amount,$uwr_pin,$w_tnxId,$admin){
       global $connection;
    $awr_date = date("Y-m-d");
    $awr_time = date('H:m:s');
    //$uwr_pin= generatePIN(6);
    $awr_status = '2';
    $result = mysqli_query($connection,"INSERT INTO tbl_agent_withdraw(wr_branch_id,awr_amount,awr_pin,awr_txnId,awr_date,awr_time,awr_status ,awr_admin)"
            . " VALUES('".$w_branch."','".$w_amount."','".$uwr_pin."','".$w_tnxId."','".$awr_date."','".$awr_time."','".$awr_status."','".$admin."')");
    if($result){
        return true;
    }
    return false;
}
function search_member_by_id_or_contact($m_id,$m_contact){
       global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_userid='".$m_id."' OR u_contact='".$m_contact."'   ");
    if($results){
        $num_of_user = mysqli_num_rows($results);
        if($num_of_user>0){
            return mysqli_fetch_array($results);
        }
    }
    return false;
}
function get_dps_info_by_user_id($user_Id)
{
      global $link;
    $stu = array();
    global $connection;
    $qu =("SELECT * FROM tbl_users_dps_info WHERE udi_user_id='".$user_Id."' AND udi_status='1'  OR udi_user_id='".$user_Id."' AND udi_status='2' ");
    $sql= mysqli_query($connection,$qu);
    if($sql){
        while($row = mysqli_fetch_array($sql)){
            $stu[] = $row;
        }
    }
    return $stu;
}

function get_fdr_info_by_user_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_fdr_info WHERE ufi_user_id='".$user_id."' AND ufi_status='1' OR ufi_user_id='".$user_id."' AND ufi_status='2' ");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}
function get_dps_info_by_user_id_status($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_dps_info WHERE udi_user_id='".$user_id."' AND udi_status='1' OR udi_user_id='".$user_id."' AND udi_status='2' ");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}
function get_all_dps_list_by_ck($info){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_dps_list WHERE check_key='".$info."'  ");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}
function get_dps_info_by_id($id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_dps_info WHERE udi_id='".$id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
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

function get_all_admin_list(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_admin_info");
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
function get_all_month_list(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_dps_month");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
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
function add_branch_expance_history($branch_id,$dep_cat,$total_dep,$date,$time,$code){
    $charge='0';
    $dep_status='1';
    global $connection;
    $results = mysqli_query($connection,"INSERT INTO tbl_branch_expense(bex_branch,bex_category,bex_amount,bex_charge,bex_date,bex_time,bex_tnxId,bex_status) "
            . "VALUES('".$branch_id."','".$dep_cat."','".$total_dep."','".$charge."','".$date."','".$time."','".$code."','".$dep_status."')");
    if($results){
        return true;
    }
    return false;
}
function add_member_expense_history($member_expense,$u_sponsor_id,$exp_cat,$amount,$date,$time){
    $charge='0';
    $exp_status='1';
    global $connection;
    $results = mysqli_query($connection,"INSERT INTO tbl_expense_history(ex_tnxId,ex_user,ex_category,ex_amount,ex_charge,ex_date,ex_time,ex_status) "
            . "VALUES('".$member_expense."','".$u_sponsor_id."','".$exp_cat."','".$amount."','".$charge."','".$date."','".$time."','".$exp_status."')");
    if($results){
        return true;
    }
    return false;
}
function get_all_dps_packages(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_dps_package_info");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}
function get_all_dps_packages_by_status(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_dps_package_info WHERE dpi_status='1' ");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}
function get_all_fdr_packages_by_status(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_fdr_package_info WHERE fi_status ='1' ");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}
function get_all_fdr_packages(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_fdr_package_info");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function add_branch_income_history($branch_id,$sponsor_id,$dep_cat,$total_dep,$date,$time,$code){
   // $charge='0';
    $dep_status='1';
    global $connection;
    $results = mysqli_query($connection,"INSERT INTO tbl_branch_income(bc_branch_id,bc_user_id,bc_category,bc_amount,bc_add_date,bc_add_time,bc_tnxId,bc_status) "
            . "VALUES('".$branch_id."','".$sponsor_id."','".$dep_cat."','".$total_dep."','".$date."','".$time."','".$code."','".$dep_status."')");
    if($results){
        return true;
    }
    return false;
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

function get_all_user(){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
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
function get_dps_package_info_by_id($pac_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_dps_package_info WHERE dpi_id='".$pac_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}
function get_fdr_package_info_by_id($pac_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_fdr_package_info WHERE fi_id='".$pac_id."'");
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
    global $connection;
    $mr_date = date('Y-m-d');
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
    global $connection;
    $var = array();
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
    $results = mysqli_query($connection,"SELECT * FROM tbl_newsletter WHERE ecn_status='".$ecn_status."' ORDER BY ecn_id");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}

function check_employee_info_by_contact_no($e_contact){
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_employee_info WHERE e_contact='".$e_contact."'");
    if($results){
        $num_of_user = mysqli_num_rows($results);
        if($num_of_user>0){
            return mysqli_fetch_array($results);
        }
}
    return false;
}

function add_employee_info($e_userid,$e_name,$e_contact,$e_password,$e_branch_id,$e_type,$e_ref_id){
    global $connection;
    $e_tpin = generatePIN(4);
    $e_reg_date = date('Y-m-d');
    $e_reg_time = date('H:i:s');
    $e_status = '1'; //Active
    $e_verify = '1'; //Active
    $result = mysqli_query($connection,"INSERT INTO tbl_employee_info(e_userid,e_name,e_contact,e_password,e_tpin,e_branch,e_type,e_ref_id,e_verify,e_status,e_reg_date,e_reg_time,e_cr_branch)VALUES('".$e_userid."','".$e_name."','".$e_contact."','".$e_password."','".$e_tpin."','".$e_branch_id."','".$e_type."','".$e_ref_id."','".$e_verify."','".$e_status."','".$e_reg_date."','".$e_reg_time."','".$e_branch_id."')");
    if($result){
        return true;
    }
    return false;
}
?>
