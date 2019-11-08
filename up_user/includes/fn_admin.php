<?php
function ebijoy_get_all_product(){
    $var = array();
    $results = mysql_query("SELECT * FROM tbl_product_info ORDER BY pi_id DESC");
    if($results){
        while($row = mysql_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

function ebijoy_get_product_info_by_id($p_id){
    $pro = array();
    $qu = mysql_query("SELECT * FROM  tbl_product_info WHERE pi_id = '".$p_id." '   ");
    
    if($qu){
        $pro = mysql_fetch_array($qu);
    }
    return $pro;
}

function update_product_quantity_minus($product_id,$p_quantity){
    $product_info= ebijoy_get_product_info_by_id($product_id);
    $pi_quantity=($product_info['pi_quantity']-$p_quantity);
    $result=mysql_query("UPDATE tbl_product_info SET pi_quantity='".$pi_quantity."' WHERE pi_id='".$product_id."'");
    if ($result) {
        return true;
    }
    return false;
}

function add_product_sell_history($ps_branch,$ps_product,$ps_unit,$ps_txnId,$ps_admin){
    $ps_date = date("Y-m-d");
    $ps_time = date('H:m:s');
    $ps_status = '1';
    $result = mysql_query("INSERT INTO tbl_product_sell(ps_branch,ps_product,ps_unit,ps_date,ps_time,ps_txnId,ps_status,ps_admin) VALUES('".$ps_branch."','".$ps_product."','".$ps_unit."','".$ps_date."','".$ps_time."','".$ps_txnId."','".$ps_status."','".$ps_admin."')");
    if($result){
        return true;
    }
    return false;
}

function check_branch_products($bp_br_pro_ck){
    $results = mysql_query("SELECT * FROM tbl_branch_products WHERE bp_br_pro_ck='".$bp_br_pro_ck."'");
    if($results){
        return true;
    }
    return false;
}

function get_branch_products($bp_br_pro_ck){
    $var = array();
    $results = mysql_query("SELECT * FROM tbl_branch_products WHERE bp_br_pro_ck='".$bp_br_pro_ck."'");
    if($results){
        $var = mysql_fetch_array($results);
    }
    return $var;
}

function add_branch_products($ps_branch,$ps_product,$ps_unit,$ps_admin){
    $bp_br_pro_ck=$ps_branch.$ps_product;
    $ps_status = '1';
    $result = mysql_query("INSERT INTO tbl_branch_products(bp_branch,bp_product,bp_quantity,bp_br_pro_ck,bp_status,bp_admin) VALUES('".$ps_branch."','".$ps_product."','".$ps_unit."','".$bp_br_pro_ck."','".$ps_status."','".$ps_admin."')");
    if($result){
        return true;
    }
    return false;
}

function update_product_products_qty($check_b_product,$p_quantity){
    $b_product_info=get_branch_products($check_b_product);
    $bp_quantity=($b_product_info['bp_quantity']+$p_quantity);
    $results=mysql_query("UPDATE tbl_branch_products SET bp_quantity='".$bp_quantity."' WHERE bp_br_pro_ck ='".$check_b_product."'");
    if ($results) {
        return true;
    }
    return false;
}

function get_all_sell_product_list(){
    $var = array();
    $results = mysql_query("SELECT * FROM tbl_product_sell ORDER BY ps_id DESC");
    if($results){
        while($row = mysql_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

function get_all_branch_product_list(){
    $var = array();
    $results = mysql_query("SELECT * FROM tbl_branch_products ORDER BY bp_id DESC");
    if($results){
        while($row = mysql_fetch_array($results)){
            $var[] = $row;
        }
    }
    return $var;
}

?>