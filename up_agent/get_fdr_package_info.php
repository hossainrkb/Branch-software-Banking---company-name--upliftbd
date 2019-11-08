<?php  
include './includes/functions.php';
    if(isset($_POST["package_id"])){
    $pac_id=$_POST["package_id"];
    $fdr_package= get_fdr_package_info_by_id($pac_id);
      }
    ?>  
<html>
<head>
</head>
<body class="text-center">
    <table>
        <tr>
            <td class="text-right"><b>Minimum Amount: <?php echo "  ".'<span class="text-primary">'.$fdr_package['fi_amount'].'</span>';?> BDT</b></td>
        </tr>
    </table>  
</body>
</html>