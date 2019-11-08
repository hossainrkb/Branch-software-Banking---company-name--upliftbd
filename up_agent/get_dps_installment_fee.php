<?php  
include './includes/functions.php';
    if(isset($_POST["get_dps_installment"])){
    $get_installment=$_POST["get_dps_installment"];
  $get_ins= get_dps_info_by_id($get_installment);
      }
    ?>  
<html>
<head>
</head>
<body class="text-center">
    <table>
        <tr>
            <td class="text-right"><b>Installemnt Fee: <?php echo "  ".'<span class="text-primary">'.$get_ins['udi_installment'].'</span>';?> BDT</b></td>
        </tr>
    </table>  
</body>
</html>