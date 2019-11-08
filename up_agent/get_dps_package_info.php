<?php  
include './includes/functions.php';
    if(isset($_POST["dps_package_id"])){
    $dps_pac_id=$_POST["dps_package_id"];
    $dps_package= get_dps_package_info_by_id($dps_pac_id);
      }
    ?>  
<html>
<head>
</head>
<body class="text-center">
    <table>
        <tr>
            <td class="text-right"><b>DPS Fee: <?php echo "  ".'<span class="text-primary">'.$dps_package['dpi_min_amount'].' - '.$dps_package['dpi_max_amount'].'</span>';?> BDT</b></td>
        </tr>
         </table>  
</body>
</html>