<?php
require_once('../config/config.php');
require_once('../controllers/session-controller.php');
require_once('../classess/privileges.php');

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

                    <!-- href must be unique and match the id of target div -->

                    <li><a href="#tab2">Manage User Privileges</a></li>
                </ul>

                <div class="clear"></div>

            </div> <!-- End .content-box-header -->

            <div class="content-box-content">

                <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->

                    <?php
                    //   $users = privileges :: getAllUsers();
                    $users = privileges :: getUsersForAssigningPrivileges();

//                    if(isset($_GET['u_id'])){

                    if(isset($_GET['u_id'])){

                    echo "<h4>Please assign the functional privileges for the newly created user </h4> </br><br/><br/>";
                    }
//                        $user_details_arr = privileges::getGivenUserDetails(base64_decode($_GET['u_id']));
//
//                        if(array_key_exists('name',$user_details_arr)){
//                        echo '<h5>Privileges for the User : '.$user_details_arr['name'].'</h5>';
//                        }
//                        else{
//                            //redirect to home page
//                        }
//                    }
//                    else{

                    ?>

                    Select User <select id="users_lst" onchange="loadSelectedUserPrivileges(this.value);">
                        <option id="">Select User</option>
                        <?php foreach($users as $user){

                        if(isset($_GET['u_id'])){
                            if((base64_decode($_GET['u_id'])== $user['user_id'])){
                                ?>
                                <option value="<?php echo $user['user_id']; ?>" <?php if(base64_decode($_GET['u_id'])== $user['user_id']){ ?> selected="selected"  <?php } ?>> <?php echo $user['name']; ?></option>

                                <?php
                            }

                        }
                        else{
                            ?>
                            <option value="<?php echo $user['user_id']; ?>"> <?php echo $user['name']; ?></option>
                            <?php }
                    } ?>
                    </select>




                </div> <!-- End #tab1 -->


                <div id="assigned_user_privileges" style="margin-top: 50px;">
                    <?php
                    if(isset($_GET['u_id'])){

                        ?>
                        <script type="text/javascript">
                            loadSelectedUserPrivileges(<?php echo base64_decode($_GET['u_id']); ?>);
                        </script>
                        <?php
                    }
                    ?>

                </div>




            </div> <!-- End .content-box-content -->

            <div id="user_msg" style="margin-left: 100px;">

            </div>

<!--             <a href="add-new-user.php">Go to Admin Users</a>-->
            <input style="margin-left: 20px;" class="button" type="button" value="Go to Admin Users" onclick="redirectionToAdminUsers();"/>


            <script type="text/javascript">
                function redirectionToAdminUsers(){

                    window.location = "add-new-user.php";
                }
            </script>
            <br/>
            <br/>

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
