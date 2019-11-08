<?php 
$hostname = 'localhost';
$user = 'root';
$password = '';
$database = 'upliftbd';
//////////////////////////////////////
$connection = mysqli_connect($hostname,$user,$password,$database);
if (!$connection){    
    die("database not connect". mysqli_connect_error());
}
?>



