<?php
/////////////////////////////// USER ////////////////////////////////////////////////
function check_branch_info_by_br_code($br_code){
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_branch_info WHERE br_code='".$br_code."'");
    if($results){
        $num_of_user = mysqli_num_rows($results);
        if($num_of_user>0){
            return mysqli_fetch_array($results);
        }
    }
    return false;
}

function is_branch_login($br_code,$br_password){
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_branch_info WHERE br_code='".$br_code."' AND br_password='".$br_password."'");
    if($results){
        $num_of_user = mysqli_num_rows($results);
        if($num_of_user>0){
            return mysqli_fetch_array($results);
        }
    }
    return false;
}

function get_branch_info_by_id($br_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_branch_info WHERE br_id ='".$br_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}
function get_admin_info_by_id($br_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_admin_info WHERE a_id ='".$br_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_branch_owner_info_by_branch_id($branch_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_branch_owner WHERE bwi_branch ='".$branch_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}
//////////////////////////////////////////////////////
function get_member_info_by_id($member_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_id ='".$member_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}
function get_dps_month_info_by_id($id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_dps_month WHERE dps_month_id ='".$id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_member_type_info_by_id($member_type){
    $user = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_type WHERE ut_id='".$member_type."'");
    if($results){
        $user = mysqli_fetch_array($results);
    }
    return $user;
}


function get_employee_info_by_id($employee_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_employee_info WHERE e_id ='".$employee_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_employee_type_info_by_id($et_id){
    $user = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_employee_type WHERE et_id='".$et_id."'");
    if($results){
        $user = mysqli_fetch_array($results);
    }
    return $user;
}

function get_all_branch_members($branch_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_branch_id='".$branch_id."'");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}
function get_all_branch_unverified_members($branch_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_branch_id='".$branch_id."'  AND u_verify='0'      ");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

function get_all_branch_employee($branch_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_employee_info WHERE e_branch='".$branch_id."'");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

function get_branch_creator_income($member_id,$branch_id){
    $dep_cat='8';
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_deposit_history WHERE dep_user='".$member_id."' AND dep_branch_id ='".$branch_id."' AND dep_category ='".$dep_cat."'");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

function update_branch_tpin($branch_id,$n_tpin){
    global $connection;
    $result = mysqli_query($connection,"UPDATE tbl_branch_info SET br_tpin ='".$n_tpin."' WHERE br_id='".$branch_id."' ");
    if($result){
        return true;
    }
    return false;
}

function update_branch_password($branch_id,$password){
    global $connection;
    $result = mysqli_query($connection,"UPDATE tbl_branch_info SET br_password ='".$password."' WHERE br_id='".$branch_id."' ");
    if($result){
        return true;
    }
    return false;
}

function get_all_branch_order_history($branch_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_order WHERE uo_branch_id='".$branch_id."' ORDER BY uo_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

function get_pvs_info_by_invoice_id($invoice_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_pv_pin WHERE upv_invoice_id ='".$invoice_id."'");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

function check_item_in_order_process($op_check){
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_order_process WHERE op_check='".$op_check."'");
    if($results){
        $num_of_user = mysqli_num_rows($results);
        if($num_of_user>0){
            return mysqli_fetch_array($results);
        }
}
    return false;
}

function update_branch_product_qty_plus($product_id,$p_quantity){
    $product_info= get_branch_product_info_by_id($product_id);
    $pi_quantity=($product_info['bp_quantity']+$p_quantity);
    global $connection;
    $result=mysqli_query($connection,"UPDATE tbl_branch_products SET bp_quantity='".$pi_quantity."' WHERE bp_id='".$product_id."'");
    if ($result) {
        return true;
    }
    return false;
}

function update_branch_product_qty_minus($product_id,$p_quantity){
    $product_info= get_branch_product_info_by_id($product_id);
    $pi_quantity=($product_info['bp_quantity']-$p_quantity);
    global $connection;
    $result=mysqli_query($connection,"UPDATE tbl_branch_products SET bp_quantity='".$pi_quantity."' WHERE bp_id='".$product_id."'");
    if ($result) {
        return true;
    }
    return false;
}

function add_item_into_order_process($s_product_id,$s_qty,$branch_id){
    $op_check=$s_product_id.'0'.$branch_id;
    $op_status = '1';
    global $connection;
    $result = mysqli_query($connection,"INSERT INTO tbl_order_process(op_pi_id,op_pi_qty,op_branch_id,op_check,op_status) VALUES('".$s_product_id."','".$s_qty."','".$branch_id."','".$op_check."','".$op_status."')");
    if($result){
        return true;
    }
    return false;
}

function update_order_process_item_qty_plus($op_check,$s_qty){
    $item_info=check_item_in_order_process($op_check);
    $op_pi_qty=$item_info['op_pi_qty']+$s_qty;
    global $connection;
    $result = mysqli_query($connection,"UPDATE tbl_order_process SET op_pi_qty='".$op_pi_qty."' WHERE op_check='".$op_check."'");
    if($result){
        return true;
    }
    return false;
}

function remove_item_from_order_process($op_check_key){
    global $connection;
    $result = mysqli_query($connection,"DELETE FROM tbl_order_process WHERE op_check='".$op_check_key."'");
    if($result){
        return true;
    }
    return false;
}

function clear_branch_shopping_cart($branch_id){
    $op_employee='0';
    global $connection;
    $result = mysqli_query($connection,"DELETE FROM tbl_order_process WHERE op_branch_id='".$branch_id."' AND op_employee='".$op_employee."'");
    if($result){
        return true;
    }
    return false;
}


function setOrder($uo_order_id,$uo_branch_id,$uo_employee_id,$uo_customer_id,$uo_customer_name,$uo_customer_mobile,$uo_product_ids,$uo_product_quantities,$uo_product_unit_prices,$uo_total_pvs,$uo_total_amount,$sell_commission){
    $uo_order_date = date('Y-m-d');
    $uo_order_time = date('H:m:s');
    $uo_order_status='1';
    global $connection;
    $result = mysqli_query($connection,"INSERT INTO tbl_users_order(uo_order_id,uo_branch_id,uo_employee_id,uo_customer_id,uo_customer_name,uo_customer_mobile,uo_product_ids,uo_product_quantities,uo_product_unit_prices,uo_total_pvs,uo_total_amount,uo_commission_discount,uo_order_date,uo_order_time,uo_order_status) VALUES('".$uo_order_id."','".$uo_branch_id."','".$uo_employee_id."','".$uo_customer_id."','".$uo_customer_name."','".$uo_customer_mobile."','".$uo_product_ids."','".$uo_product_quantities."','".$uo_product_unit_prices."','".$uo_total_pvs."','".$uo_total_amount."','".$sell_commission."','".$uo_order_date."','".$uo_order_time."','".$uo_order_status."')");
    if($result){
        return true;
    }
    return false;
}

function get_user_info_by_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_id ='".$user_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_user_info_by_uid_or_contact($u_userid){
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_userid='".$u_userid."' OR u_contact='".$u_userid."'");
    if($results){
        $num_of_user = mysqli_num_rows($results);
        if($num_of_user>0){
            return mysqli_fetch_array($results);
        }
}
    return false;
}

function update_user_balance_plus($user_id,$u_amount){
    $user_info= get_user_info_by_id($user_id);
    $u_balance=$user_info['u_balance']+$u_amount;
    global $connection;
    $result=mysqli_query($connection,"UPDATE tbl_users_info SET u_balance='".$u_balance."' WHERE u_id='".$user_id."'");
    if ($result) {
        return true;
    }
    return false;
}

function add_users_pv_pin($upv_pin,$upv_value,$upv_branch_id,$upv_invoice_id){
    $upv_user_id='0';
    $upv_status ='1'; //Active
    $upv_date =date('Y-m-d');
    $upv_time =date('H:i:s');
    global $connection;
    $result = mysqli_query($connection,"INSERT INTO tbl_users_pv_pin(upv_pin,upv_value,upv_branch_id,upv_invoice_id,upv_user_id,upv_status,upv_date,upv_time)VALUES('".$upv_pin."','".$upv_value."','".$upv_branch_id."','".$upv_invoice_id."','".$upv_user_id."','".$upv_status."','".$upv_date."','".$upv_time."')");
    if($result){
        return true;
    }
    return false;
}

function get_users_order_by_id($uo_id){
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_order WHERE uo_id='".$uo_id."'");
    $order = array();
    if($results){
        $order = mysqli_fetch_array($results);
    }
    return $order;
}

function get_user_order_by_order_id($order_id){
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_order WHERE uo_order_id='".$order_id."'");
    $order = array();
    if($results){
        $order = mysqli_fetch_array($results);
    }
    return $order;
}

function get_users_pv_pin_by_order_nd_branch_id($order_id,$branch_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_pv_pin WHERE upv_invoice_id='".$order_id."' AND upv_branch_id='".$branch_id."' ");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

function get_order_details_by_order_nd_branch_id($order_id,$branch_id){
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_order WHERE uo_id='".$order_id."' AND uo_branch_id='".$branch_id."' ");
    $order = array();
    if($results){
        $order = mysqli_fetch_array($results);
    }
    return $order;
}

///////////////////////////////////////////////////////////////////////////////////////////
function add_users_info($name,$contact,$password,$branch_id,$u_sponsor_id,$u_placement_id){
    $id="";
    $u_userid=$contact;
    $t_pin= rand(1111,9999);
    $u_token = md5(uniqid(rand()));
    $reg_date =date('Y-m-d');
    $reg_time =date('H:i:s',time()+5*3600);
    $u_type='1';  //BD
    $status ='1'; //Active
    global $connection;
    $result = mysqli_query($connection,"INSERT INTO tbl_users_info(u_id,u_userid,u_name,u_branch_id,u_sponsor_id,u_placement_id,u_tpin,u_contact,u_password,u_reg_date,u_reg_time,u_token,u_type,u_status)"
            . "VALUES('".$id."','".$u_userid."','".$name."','".$branch_id."','".$u_sponsor_id."','".$u_placement_id."','".$t_pin."','".$contact."','".$password."','".$reg_date."','".$reg_time."','".$u_token."','".$u_type."','".$status."')");
    if($result){
        return true;
    }
    return false;
}

function check_user_info($u_userid){
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_userid='".$u_userid."' OR u_contact='".$u_userid."'");
    if($results){
        $num_of_user = mysqli_num_rows($results);
        if($num_of_user>0){
            return mysqli_fetch_array($results);
        }
}
    return false;
}

function update_members_userid($u_id,$customer_id){
    //global $conn;
    global $connection;
    $result=mysqli_query($connection,"UPDATE tbl_users_info SET u_userid='".$customer_id."' WHERE u_id='".$u_id."'");
    if ($result) {
        return true;
    }
    return false;
}


function check_dps_list_verify($ck){
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_dps_list WHERE udl_check_key='".$ck."'     ");
    if($results){
        $num_of_user = mysqli_num_rows($results);
        if($num_of_user>0){
            return mysqli_fetch_array($results);
        }
}
    return false;
}
function check_user_verify($u_userid){
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_id='".$u_userid."' AND u_verify='0'     ");
    if($results){
        $num_of_user = mysqli_num_rows($results);
        if($num_of_user>0){
            return mysqli_fetch_array($results);
        }
}
    return false;
}

function get_sponsor_list_by_user_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_sponsor_id='".$user_id."'");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

function get_member_list_by_user_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_sponsor_id='".$user_id."' OR u_placement_id='".$user_id."' ");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

function add_reseller_user_info($u_name,$u_contact,$u_password,$u_status,$u_ref_id){
    $u_id="";
    $u_userid=$u_contact;
    $u_username=$u_contact;
    $u_email=$u_contact;
    $u_reg_date=date('Y-m-d H:i:s');
    $u_tpin= generatePIN();
    global $connection;
    $result = mysqli_query($connection,"INSERT INTO tbl_users_info(u_id,u_userid,u_username,u_name,u_tpin,u_contact,u_email,u_password,u_reg_date,u_ref_id,u_status)VALUES('".$u_id."','".$u_userid."','".$u_username."','".$u_name."','".$u_tpin."','".$u_contact."','".$u_email."','".$u_password."','".$u_reg_date."','".$u_ref_id."','".$u_status."')");
    if($result){
        return true;
    }
    return false;
}

function get_ref_list_by_user_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_employee_info WHERE e_ref_id='".$user_id."' ORDER BY e_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

function get_placement_list_by_user_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_placement_id='".$user_id."' ORDER BY u_id ASC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

function check_placements_id_type_by_status($user_id,$u_type){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_placement_id='".$user_id."' AND u_type ='".$u_type."'");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

function get_user_info_by_user_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_userid ='".$user_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function check_user_info_contact_no($m_contact){
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_contact='".$m_contact."'");
    if($results){
        $num_of_user = mysqli_num_rows($results);
        if($num_of_user>0){
            return mysqli_fetch_array($results);
        }
}
    return false;
}


function check_user_tpin($user_id,$tpin){
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_employee_info WHERE e_id='".$user_id."' AND e_tpin='".$tpin."'");
    if($results){
        $num_of_row = mysqli_num_rows($results);
        if($num_of_row>0){
            return true;
        }
}
    return false;
}

function update_user_status($u_id,$u_status){
    global $connection;
    $result=mysqli_query($connection,"UPDATE tbl_users_info SET u_status='".$u_status."' WHERE u_id='".$u_id."'");
    if ($result) {
        return true;
    }
    return false;
}

function update_user_balance($user_id,$u_amount){
    $user_info= get_branch_info_by_id($user_id);
    $u_balance=$user_info['u_balance']+$u_amount;
    global $connection;
    $result=mysqli_query($connection,"UPDATE tbl_users_info SET u_balance='".$u_balance."' WHERE u_id='".$user_id."'");
    if ($result) {
        return true;
    }
    return false;
}


function update_user_pv_value($user_id,$upv_value){
    $user_info= get_branch_info_by_id($user_id);
    $pv_value=$user_info['u_pv_value']+$upv_value;
    global $connection;
    $result=mysqli_query($connection,"UPDATE tbl_users_info SET u_pv_value='".$pv_value."' WHERE u_id='".$user_id."'");
    if ($result) {
        return true;
    }
    return false;
}

function update_user_branch_pv_pin_status($upv_pin,$upv_branch_id,$upv_user_id){
    $upv_status='0';
    $upv_date= date('Y-m-d');
    global $connection;
    $result=mysqli_query($connection,"UPDATE tbl_users_pv_pin SET upv_user_id='".$upv_user_id."',upv_status='".$upv_status."',upv_date='".$upv_date."' WHERE upv_pin='".$upv_pin."' AND upv_branch_id='".$upv_branch_id."'");
    if ($result) {
        return true;
    }
    return false;
}

function setMessages($name,$email,$phone,$subject,$messages,$customer_id){
    $date =  date("Y-m-d H:i:s");
    global $connection;
    $result = mysqli_query($connection,"INSERT INTO atw_contact(name,email,phone,subject,messages,date,c_id) VALUES('".$name."','".$email."','".$phone."','".$subject."','".$messages."','".$date."','".$customer_id."')");
    if($result){
        return true;
    }
    return false;
}

function get_messages_by_user_id($user_id){
    $messages = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM atw_contact WHERE c_id='".$user_id."' ORDER BY id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $messages[] = $row;
        }
    }
    return $messages;
}

///////////////////////////////////////////////////////////////////////////////////
function check_branch_user_pv_pin_info_by_id($branch_id,$pv_pin){
    $var = array();
    $upv_status='1';
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_pv_pin WHERE upv_branch_id='".$branch_id."' AND upv_pin='".$pv_pin."' AND upv_status='".$upv_status."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function get_users_pv_pin_list($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_pv_pin WHERE upv_user_id='".$user_id."' ORDER BY upv_status DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

function add_users_offers($uo_user_id,$uo_offer_id){
    $uo_date =  date("Y-m-d");
    $uo_exp_date =  date("Y-m-d");
    $uo_status =  date("Y-m-d");
    global $connection;
    $result = mysqli_query($connection,"INSERT INTO tbl_users_offers(uo_user_id,uo_offer_id,uo_date,uo_exp_date,uo_status) VALUES('".$uo_user_id."','".$uo_offer_id."','".$uo_date."','".$uo_exp_date."','".$uo_status."')");
    if($result){
        return true;
    }
    return false;
}

function get_user_order_info_by_id($uo_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_order WHERE uo_id='".$uo_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
}

function add_users_withdraw_request($w_branch,$w_amount,$uwr_pin,$w_tnxId,$user_id){
    $uwr_date = date("Y-m-d");
    $uwr_time = date('H:m:s');
    //$uwr_pin= generatePIN(6);
    $uwr_status = '2';
    global $connection;
    $result = mysqli_query($connection,"INSERT INTO tbl_users_withdraw(uwr_branch_id,uwr_user_id,uwr_amount,uwr_pin,uwr_txnId,uwr_date,uwr_time,uwr_status) VALUES('".$w_branch."','".$user_id."','".$w_amount."','".$uwr_pin."','".$w_tnxId."','".$uwr_date."','".$uwr_time."','".$uwr_status."')");
    if($result){
        return true;
    }
    return false;
}

function get_all_branch_withdraw($branch_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_agent_withdraw WHERE wr_branch_id='".$branch_id."' ORDER BY awr_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}
function get_all_users_withdraw($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_withdraw WHERE uwr_user_id='".$user_id."' ORDER BY uwr_id DESC");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }else{
        echo mysqli_error();
    }
    return $var;
}


function get_product_info_by_id($product_id){  
    $pro = array();
    global $connection;
    $qu = mysqli_query($connection,"SELECT * FROM  tbl_product_info WHERE pi_id = '".$product_id." '   ");
    if($qu){
        $pro = mysqli_fetch_array($qu);
    }
    return $pro;  
}



?>
