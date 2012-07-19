<?php
require_once('../config/config.php');
require_once('../controllers/session-controller.php');
require_once('../classess/user-sql.php');
require_once('../classess/privileges.php');

//$allusers = USER :: getallusers();
$allusers = USER :: getModeratableAdminUsers();

if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],1)==false){

    header("Location: ../");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <title>Lanka Communication Services Radius Manager Administration Panel For John Keells Holdings</title>

    <!--                       CSS                       -->

    <!-- Reset Stylesheet -->
    <link rel="stylesheet" href="../css/reset.css" type="text/css" media="screen" />
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
    <!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
    <link rel="stylesheet" href="../css/invalid.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../css/jquery.alerts.css" type="text/css" media="screen" />

    <!-- Internet Explorer Fixes Stylesheet -->
    <!--[if lte IE 7]>
    <link rel="stylesheet" href="resources/css/ie.css" type="text/css" media="screen" />
    <![endif]-->
    <!--                       Javascripts                       -->
    <!-- jQuery -->
    <script type="text/javascript" src="../scripts/jquery-1.3.2.min.js"></script>
    <!-- jQuery Configuration -->
    <script type="text/javascript" src="../scripts/simpla.jquery.configuration.js"></script>
    <!-- Facebox jQuery Plugin -->
    <script type="text/javascript" src="../scripts/facebox.js"></script>
    <!-- jQuery WYSIWYG Plugin -->
    <script type="text/javascript" src="../scripts/jquery.wysiwyg.js"></script>
    <script type="text/javascript" src="../scripts/jquery.alerts.js"></script>



    <script type="text/javascript" src="../scripts/js-functions.js"></script>
    <!-- jQuery Datepicker Plugin -->
    <!--[if IE]><script type="text/javascript" src="resources/scripts/jquery.bgiframe.js"></script><![endif]-->
    <!-- Internet Explorer .png-fix -->
    <!--[if IE 6]>
    <script type="text/javascript" src="resources/scripts/DD_belatedPNG_0.0.7a.js"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('.png_bg, img, li');
    </script>
    <![endif]-->

</head>

<body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->

<div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->


    <?php require('../includes/side-top-profile-details.php'); ?>
    <?php require('../includes/side-navigation.php'); ?>

    <!-- End #main-nav -->

    <!-- End #messages -->

</div></div> <!-- End #sidebar -->

<div id="main-content"> <!-- Main Content Section with everything -->

    <noscript> <!-- Show a notification if the user has disabled javascript -->
        <div class="notification error png_bg">
            <div>
                Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
            </div>
        </div>
    </noscript>

    <!-- Page Head -->

    <?php require_once('../includes/page-hader.php'); ?>
    <!-- End .shortcut-buttons-set -->

    <div class="clear"></div> <!-- End .clear -->

    <div class="content-box"><!-- Start Content Box -->

        <div class="content-box-header">

            <h3>Manage Users</h3>

            <ul class="content-box-tabs">
                <li><a href="#tab1" class="default-tab">View</a></li>
                <!-- href must be unique and match the id of target div -->


                <li><a href="#tab2">Add new User</a></li>
            </ul>

            <div class="clear"></div>

        </div> <!-- End .content-box-header -->

        <div class="content-box-content">

            <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->

                <div id="ajax-load-user">
                    <table>
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email address</th>
                            <th>User Group</th>
                            <th>Hotel</th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        <?php
                        while($rowallusers=mysql_fetch_array($allusers)){
                            ?>
                            <tr id="user<?php echo $rowallusers['user_id']; ?>">
                                <td><?php echo $rowallusers['name']; ?></td>
                                <td><?php echo $rowallusers['username']; ?></td>
                                <td><?php echo $rowallusers['email_address']; ?></td>
                                <td><?php echo $rowallusers['USER_TYPE']; ?></td>
                                <td><?php echo $rowallusers['groupname']; ?></td>
                                <td>
                                    <?php if($_SESSION['user_id']!=$rowallusers['user_id']){ ?>
                                    <img src="../images/icons/cross.png" style="cursor:pointer;" onclick="deletefunc('user<?php echo $rowallusers['user_id']; ?>','act_deleteuser','<?php echo $rowallusers['user_id']; ?>','Are you sure want to delete this user?')"/>
                                    <?php }

                                    if($_SESSION['group_id']==2 || $_SESSION['group_id']==3 || $_SESSION['group_id']==4){
                                        ?>

                                        <a href="../usermanagement/change-admin-user-password.php?id= <?php echo base64_encode($rowallusers['user_id']);  ?>" ><img width="16px" height="16px" src="../images/icons/key.png"  style="cursor:pointer;" title="Change Password" /></a>
                                        <?php
                                    }
                                    ?>
                                </td>



                            </tr>
                            </tr>
                            <?php } ?>


                    </table>
                </div>
                <br/><br/>



                <h3> Total Number of Users : <?php echo mysql_num_rows($allusers); ?></h3>
            </div> <!-- End #tab1 -->



            <div class="tab-content" id="tab2">

                <form action="#" method="post" name="addnewusersform">

                    <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->

                        <p>	<label>Name</label>
                            <input class="text-input small-input" type="text"        id="user_name" name="small-input" /> <span id="msg_user_name"></span> <!-- Classes for input-notification: success, error, information, attention -->
                            <!--<br /><small>A small description of the field</small>-->
                        </p>

                        <p>	<label>Username</label>
                            <input class="text-input small-input" type="text"        id="username" name="small-input" /> <span id="msg_username"></span> <!-- Classes for input-notification: success, error, information, attention -->
                        </p>

                        <p>	<label>Password</label>
                            <input class="text-input small-input" type="password" id="user_password" name="small-input" /> <span id="msg_user_password"></span> <!-- Classes for input-notification: success, error, information, attention -->
                            <br /><!--<small>A small description of the field</small>-->
                        </p>

                        <p>	<label>Confirm Password</label>
                            <input class="text-input small-input" type="password" id="user_confirm_password" name="small-input" /> <span id="msg_user_confirm_password"></span> <!-- Classes for input-notification: success, error, information, attention -->
                            <br /><!--<small>A small description of the field</small>--></p>
                        <p>	<label>Email address</label>
                            <input class="text-input small-input" type="text" id="user_email" name="small-input" /> <span id="msg_user_email"></span> <!-- Classes for input-notification: success, error, information, attention -->
                            <br /><!--<small>A small description of the field</small>--></p>
                        <p>
                            <label>User Group</label>
                            <select id="user_group" name="dropdown" class="small-input" onchange="showcustermerbox(this.value)">
                                <option value="">Please select</option>

                                <?php

                                $systemusertypes = USER :: getSystemUserTypesForUserGroups();

                                while($rowsysusertypes = mysql_fetch_array($systemusertypes)){

                                    ?>

                                    <option value="<?php echo $rowsysusertypes['USER_TYPE_ID']; ?>"><?php echo $rowsysusertypes['USER_TYPE']; ?></option>
                                    <?php } ?>


                            </select>
                            <span id="msg_user_group"></span>
                        </p>

                        <p id="custermer_select_box" style="display:none;">

                            <label>Select a Hotel</label>

                            <select name="custermer" id="user_custermer" class="small-input">
                                <option value="">Please select</option>
                                <?php
                                $hotels = USER ::getHotelsBasedOnLoggedUserGroup();
                                while($rowhotels = mysql_fetch_array($hotels)){

                                    ?>
                                    <option value="<?php echo $rowhotels['groupid']; ?>"><?php echo $rowhotels['groupname']; ?></option>
                                    <?php } ?>

                            </select>


                            <span id="msg_user_custermer"></span>
                        </p>

                        <p><span id="msg_user_add"></span></p>

                        <p>
                            <input class="button" type="button" value="Add" onclick="addnewuser();"/>
                        </p>


                    </fieldset>

                    <div class="clear"></div><!-- End .clear -->

                </form>

            </div> <!-- End #tab2 -->

        </div> <!-- End .content-box-content -->

    </div> <!-- End .content-box -->

    <!-- End .content-box -->

    <!-- End .content-box -->
    <div class="clear"></div>


    <!-- Start Notifications -->





    <!-- End Notifications -->

    <div id="footer">
        <?php require_once('../includes/footer.php') ?>
    </div><!-- End #footer -->

</div> <!-- End #main-content -->

</div></body>
<script type="text/javascript">
    $('#2').addClass('current');
</script>


</html>
