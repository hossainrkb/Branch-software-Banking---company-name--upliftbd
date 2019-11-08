<?php
/////////////////////////////// USER ////////////////////////////////////////////////
function add_users_info($name,$contact,$password,$branch_id,$u_sponsor_id,$u_placement_id){
    $id="";
    $u_userid=$contact;
    //$t_pin= generatePIN();
    $t_pin=rand(1111,9999);
    $reg_date =date('Y-m-d');
    $reg_time =date('H:i:s');
    $u_type='1';  //BD
    $status ='1'; //Active
    global $connection;
    $result = mysqli_query($connection,"INSERT INTO tbl_users_info(u_id,u_userid,u_name,u_branch_id,u_sponsor_id,u_placement_id,u_tpin,u_contact,u_password,u_reg_date,u_reg_time,u_type,u_status)VALUES('".$id."','".$u_userid."','".$name."','".$branch_id."','".$u_sponsor_id."','".$u_placement_id."','".$t_pin."','".$contact."','".$password."','".$reg_date."','".$reg_time."','".$u_type."','".$status."')");
    if($result){
        return true;
    }
    return false;
}

function get_users_type_info_by_id($user_type){
    $user = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_type WHERE ut_id='".$user_type."'");
    if($results){
        $user = mysqli_fetch_array($results);
    }
    return $user;
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

function get_sponsor_list_by_user_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_sponsor_id='".$user_id."' ORDER BY u_id DESC");
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
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_placement_id='".$user_id."' AND u_type >='".$u_type."'");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
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

function get_user_info_by_user_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_userid ='".$user_id."'");
    if($results){
        $var = mysqli_fetch_array($results);
    }
    return $var;
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

function is_user_login($user_id,$password){
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_userid='".$user_id."' AND u_password='".$password."' OR u_contact='".$user_id."' AND u_password='".$password."'");
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
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_info WHERE u_id='".$user_id."' AND u_tpin='".$tpin."'");
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

function update_user_balance_minus($user_id,$u_amount){
    $user_info= get_user_info_by_id($user_id);
    $u_balance=$user_info['u_balance']-$u_amount;
    global $connection;
    $result=mysqli_query($connection,"UPDATE tbl_users_info SET u_balance='".$u_balance."' WHERE u_id='".$user_id."'");
    if ($result) {
        return true;
    }
    return false;
}

function update_user_pv_value($user_id,$upv_value){
    $user_info= get_user_info_by_id($user_id);
    $pv_value=$user_info['u_pv_value']+$upv_value;
    global $connection;
    $result=mysqli_query($connection,"UPDATE tbl_users_info SET u_pv_value='".$pv_value."' WHERE u_id='".$user_id."'");
    if ($result) {
        return true;
    }
    return false;
}

function update_user_password($user_id,$password){
    global $connection;
    $result = mysqli_query($connection,"UPDATE tbl_users_info SET u_password ='".$password."' WHERE u_id='".$user_id."' ");
    if($result){
        return true;
    }
    return false;
}

function update_user_tpin($user_id,$n_tpin){
    global $connection;
    $result = mysqli_query($connection,"UPDATE tbl_users_info SET u_tpin ='".$n_tpin."' WHERE u_id='".$user_id."' ");
    if($result){
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

function get_user_order_by_id($order_id){
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_order WHERE uo_id='".$order_id."'");
    $order = array();
    if($results){
        $order = mysqli_fetch_array($results);
    }
    return $order;
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

function get_users_dps_info_by_user_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_dps_info WHERE udi_user_id = '".$user_id."' ORDER BY udi_id DESC ");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

function get_users_frd_info_by_user_id($user_id){
    $var = array();
    global $connection;
    $results = mysqli_query($connection,"SELECT * FROM tbl_users_fdr_info WHERE ufi_user_id = '".$user_id."' ORDER BY ufi_id DESC ");
    if($results){
        while($row = mysqli_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}


?>
