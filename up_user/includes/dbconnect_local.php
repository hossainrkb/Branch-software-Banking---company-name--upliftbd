<?php
$link = mysql_connect("localhost","root","");
if($link){
    $con = mysql_select_db("upliftbd",$link);
    mysql_query('SET CHARACTER SET utf8');
    if(!$con){
        echo "Database not found.";
    }
}
?>