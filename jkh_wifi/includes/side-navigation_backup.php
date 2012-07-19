<ul id="main-nav">  <!-- Accordion Menu -->

    <li>
        <a id="1" href="<?php echo HTTP_PATH; ?>" class="nav-top-item no-submenu"> <!-- Add the class "no-submenu" to menu items with no sub menu -->
            Home Page
        </a>
    </li>
    <?php if($_SESSION['group_id']==4){ ?>

        <li>
            <a id="2"  href="<?php echo HTTP_PATH; ?>usermanagement/add-new-user.php" class="nav-top-item no-submenu">
                Manage Admin users
            </a>
        <!--    <ul>
                <li><a href="<?php //echo HTTP_PATH; ?>usermanagement/add-new-user.php" <?php //if(basename($_SERVER["PHP_SELF"])=='add-new-user.php'){ echo "class='current'"; } ?>>Manage Users</a></li>

            </ul> -->

        </li><?php } ?>





    <!--Graphs start-->

    <li >

        <a id="6" href="#" class="nav-top-item">Traffic</a>
        <ul>
            <li><a href="<?php echo HTTP_PATH; ?>reports/view-hourly-usage-graph.php"">Hourly Graphs</a></li>
            <li><a href="<?php echo HTTP_PATH; ?>reports/view-daily-usage-graph.php"">Daily Graphs</a></li>
            <li><a href="<?php echo HTTP_PATH; ?>reports/view-weekly-usage-graph.php"">Weekly Graphs</a></li>
            <li><a href="<?php echo HTTP_PATH; ?>reports/view-monthly-usage-graph.php"">Monthly Graphs</a></li>

            <!--            <li><a href="#"">Hourly Graphs</a></li>-->
            <!--            <li><a href="#">Daily Graphs</a></li>-->

        </ul>


    </li>





    <li >
        <a id="3" href="#" class="nav-top-item">Reports</a>
        <ul>
            <li><a href="<?php echo HTTP_PATH; ?>reports/wifi-usage-reports.php" <?php if(basename($_SERVER["PHP_SELF"])=='wifi-usage-reports.php'){ echo "class='current'"; } ?>>Room Reports</a></li>

            <li><a href="<?php echo HTTP_PATH; ?>reports/wifi-hotel-usage-reports.php" <?php if(basename($_SERVER["PHP_SELF"])=='wifi-usage-reports.php'){ echo "class='current'"; } ?>>Hotel Reports</a></li>

            <?php if($_SESSION['group_id']==3){ ?>
            <li><a href="<?php echo HTTP_PATH; ?>reports/live-users.php" <?php if(basename($_SERVER["PHP_SELF"])=='live-users.php'){ echo "class='current'"; } ?>>Live Users</a></li>      <?php } ?>



        </ul>


    </li>






    <?php //if($_SESSION['group_id']==4 || $_SESSION['group_id']==5){ ?>
    <li >
        <a id="4" href="#" class="nav-top-item">Manage WiFi users</a>
        <ul>
            <!--       <?php if($_SESSION['group_id']==4 ){ ?><li><a href="<?php echo HTTP_PATH; ?>cardmanagement/add-cards.php" <?php if(basename($_SERVER["PHP_SELF"])=='add-cards.php'){ echo "class='current'"; } ?> >Add Cards</a></li><?php } ?>  -->
            <!--<li><a href="<?php echo HTTP_PATH; ?>cardmanagement/activate-cards.php" <?php if(basename($_SERVER["PHP_SELF"])=='activate-cards.php'){ echo "class='current'"; } ?> >Activate Cards</a></li>
          	<li><a href="<?php echo HTTP_PATH; ?>cardmanagement/manage-cards.php" <?php if(basename($_SERVER["PHP_SELF"])=='manage-cards.php'){ echo "class='current'"; } ?> >Manage Cards</a></li>   -->


            <?php if($_SESSION['group_id']==4 ){ ?> <!--<li><a href="<?php echo HTTP_PATH; ?>cardmanagement/generate-cards.php" <?php if(basename($_SERVER["PHP_SELF"])=='generate-cards.php'){ echo "class='current'"; } ?> >Generate Cards</a></li>-->   <?php } ?>



            <li><a href="<?php echo HTTP_PATH; ?>cardmanagement/add_cards.php" <?php if(basename($_SERVER["PHP_SELF"])=='add_cards.php'){ echo "class='current'"; } ?> >Add Users</a></li>
            <li><a href="<?php echo HTTP_PATH; ?>cardmanagement/manage_cards.php" <?php if(basename($_SERVER["PHP_SELF"])=='manage_cards.php'){ echo "class='current'"; } ?> >Manage Users</a></li>
            <li><a href="<?php echo HTTP_PATH; ?>cardmanagement/live_users.php" <?php if(basename($_SERVER["PHP_SELF"])=='live_users.php'){ echo "class='current'"; } ?> >Live Users</a></li>


        </ul>
    </li>

    <?php //} ?>



    <li>
        <a id="5"  href="#" class="nav-top-item">
            Settings
        </a>
        <ul>
            <li><a <?php if(basename($_SERVER["PHP_SELF"])=='change-password.php'){ echo "class='current'"; } ?> href="<?php echo HTTP_PATH; ?>myaccount/change-password.php">Change Password</a></li>



            <!--<li>
                       <a   href="#" class="nav-top-item">
                           Image Gallery
                       </a>
                       <ul>
                           <li><a href="#">Upload Images</a></li>
                           <li><a href="#">Manage Galleries</a></li>
                           <li><a href="#">Manage Albums</a></li>
                           <li><a href="#">Gallery Settings</a></li>
                       </ul>
                   </li>-->

            <!--<li>
                       <a id="4"  href="#" class="nav-top-item">
                           Events Calendar
                       </a>
                       <ul>
                           <li><a href="#">Calendar Overview</a></li>
                           <li><a href="#">Add a new Event</a></li>
                           <li><a href="#">Calendar Settings</a></li>
                       </ul>
                   </li>-->


        </ul>
    </li>



    <li>
        <a id="2"  href="<?php echo HTTP_PATH; ?>usermanagement/change-user-privileges.php" class="nav-top-item no-submenu">
            Change User Privileges
        </a>

    </li>





</ul>
