<?php
//require_once('../classess/privileges.php');
require_once(DOCUMENT_ROOT."classess/privileges.php");

//echo "chathuranga[".$_SERVER['DOCUMENT_ROOT']."jkh_wifi/classess/privileges.php]";
?>
<ul id="main-nav">  <!-- Accordion Menu -->

    <li>
        <a id="1" href="<?php echo HTTP_PATH; ?>" class="nav-top-item no-submenu"> <!-- Add the class "no-submenu" to menu items with no sub menu -->
            Home Page
        </a>
    </li>



    <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],1)){ ?>

        <li>
            <a id="2"  href="<?php echo HTTP_PATH; ?>usermanagement/add-new-user.php" class="nav-top-item no-submenu">
                Manage Admin users
            </a>

        </li>
        <?php } ?>





    <!--Graphs start-->
    <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],13)){ ?>
        <li >

            <a id="3" href="#" class="nav-top-item">Traffic</a>
            <ul>
                <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],3)){ ?>
                <li><a href="<?php echo HTTP_PATH; ?>reports/view-hourly-usage-graph.php"">Hourly Graphs</a></li>
                <?php } ?>

                <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],2)){ ?>
                <li><a href="<?php echo HTTP_PATH; ?>reports/view-daily-usage-graph.php"">Daily Graphs</a></li>
                <?php } ?>

                <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],4)){ ?>
                <li><a href="<?php echo HTTP_PATH; ?>reports/view-weekly-usage-graph.php"">Weekly Graphs</a></li>
                <?php } ?>

                <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],5)){ ?>
                <li><a href="<?php echo HTTP_PATH; ?>reports/view-monthly-usage-graph.php"">Monthly Graphs</a></li>
                <?php } ?>

                <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],18)){ ?>
                <li><a href="<?php echo HTTP_PATH; ?>reports/view-wifi-usage-graph.php"">Wi-Fi Graphs</a></li>
                <?php } ?>


                <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],19)){ ?>
                <li><a href="<?php echo HTTP_PATH; ?>reports/view-single-wifi-usage-graph.php"">Wi-Fi Usage Graphs</a></li>
                <?php } ?>


            </ul>

        </li>
        <?php } ?>



    <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],14)){ ?>

        <li >
            <a id="4" href="#" class="nav-top-item">Reports</a>
            <ul>
                <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],6)){ ?>
                <li><a href="<?php echo HTTP_PATH; ?>reports/wifi-usage-reports.php" <?php if(basename($_SERVER["PHP_SELF"])=='wifi-usage-reports.php'){ echo "class='current'"; } ?>>WiFi Usage Report(Room)</a></li>
                <?php } ?>

                <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],7)){ ?>
                <li><a href="<?php echo HTTP_PATH; ?>reports/wifi-hotel-usage-reports.php" <?php if(basename($_SERVER["PHP_SELF"])=='wifi-hotel-usage-reports.php'){ echo "class='current'"; } ?>>WiFi Usage Report(Hotel)</a></li>
                <?php } ?>

            </ul>
        </li>
        <?php } ?>





    <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],15)){ ?>

        <li >
            <a id="5" href="#" class="nav-top-item">Manage WiFi users</a>
            <ul>
                <!--       <?php if($_SESSION['group_id']==4 ){ ?><li><a href="<?php echo HTTP_PATH; ?>cardmanagement/add-cards.php" <?php if(basename($_SERVER["PHP_SELF"])=='add-cards.php'){ echo "class='current'"; } ?> >Add Cards</a></li><?php } ?>  -->
                <!--<li><a href="<?php echo HTTP_PATH; ?>cardmanagement/activate-cards.php" <?php if(basename($_SERVER["PHP_SELF"])=='activate-cards.php'){ echo "class='current'"; } ?> >Activate Cards</a></li>
          	<li><a href="<?php echo HTTP_PATH; ?>cardmanagement/manage-cards.php" <?php if(basename($_SERVER["PHP_SELF"])=='manage-cards.php'){ echo "class='current'"; } ?> >Manage Cards</a></li>   -->


                <?php if($_SESSION['group_id']==4 ){ ?> <!--<li><a href="<?php echo HTTP_PATH; ?>cardmanagement/generate-cards.php" <?php if(basename($_SERVER["PHP_SELF"])=='generate-cards.php'){ echo "class='current'"; } ?> >Generate Cards</a></li>-->   <?php } ?>


                <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],8)){ ?>
                <li><a href="<?php echo HTTP_PATH; ?>cardmanagement/add_cards.php" <?php if(basename($_SERVER["PHP_SELF"])=='add_cards.php'){ echo "class='current'"; } ?> >Add Users</a></li>
                <?php } ?>

                <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],9)){ ?>
                <li><a href="<?php echo HTTP_PATH; ?>cardmanagement/manage_cards.php" <?php if(basename($_SERVER["PHP_SELF"])=='manage_cards.php'){ echo "class='current'"; } ?> >Manage Users</a></li>
                <?php } ?>

                <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],10)){ ?>
                <li><a href="<?php echo HTTP_PATH; ?>cardmanagement/live_users.php" <?php if(basename($_SERVER["PHP_SELF"])=='live_users.php'){ echo "class='current'"; } ?> >Live Users</a></li>
                <?php } ?>


            </ul>
        </li>

        <?php } ?>


    <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],11)){ ?>

        <li>
            <a id="6"  href="#" class="nav-top-item">
                Settings
            </a>

            <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],16)){ ?>
            <ul>
                <li><a <?php if(basename($_SERVER["PHP_SELF"])=='change-password.php'){ echo "class='current'"; } ?> href="<?php echo HTTP_PATH; ?>myaccount/change-password.php">Change Password</a></li>
            </ul>
            <?php } ?>
        </li>
        <?php } ?>


    <?php if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],17)){ ?>

        <li>
            <a id="7"  href="<?php echo HTTP_PATH; ?>usermanagement/change-user-privileges.php" class="nav-top-item no-submenu">
                Change User Privileges
            </a>

        </li>

        <?php } ?>



</ul>
