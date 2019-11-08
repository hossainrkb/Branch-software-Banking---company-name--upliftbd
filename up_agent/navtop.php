<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="cpanel.php"><?php echo '<b>'.$WebsiteSiteName.'</b>'; ?></a> 
    </div>
    <div style="color: white;padding: 15px 50px 5px 50px;float: right;font-size: 16px;">
        <b>
            <a href="profile.php" class="btn btn-danger"><b><?php echo $branch_info['br_name'].' ('.$branch_info['br_code'].')'; ?></b></a>
            eWallet :
            <?php 
            $u_balance=$branch_info['br_amount']; 
            //setlocale(LC_MONETARY,"en_US");
            //echo money_format("%i", $u_balance); 
            echo number_format($u_balance,2); ?> BDT</b>&nbsp;
            <a href="logout.php" class="btn btn-danger square-btn-adjust"><b>Logout</b></a>
    </div>
</nav> 