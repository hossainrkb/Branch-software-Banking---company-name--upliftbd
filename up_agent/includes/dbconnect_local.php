<?php 
$hostname = 'localhost';
$user = 'root';
$password = '';
$database = 'ebijoy';
//////////////////////////////////////
$connection = mysql_connect($hostname,$user,$password);
if($connection){
    $select_db = mysql_select_db($database,$connection);
    mysql_query('SET CHARACTER SET utf8');
    if(!$select_db){
        echo "Database not found.";
    } 
}
else {
    echo 'Database Connection Failed.';
}
?>
