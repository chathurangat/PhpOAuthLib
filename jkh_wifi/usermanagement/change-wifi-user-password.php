<?php
require_once('../config/config.php');
//require_once('../controllers/session-controller.php');
require_once('../classess/user-sql.php');
require_once('../classess/packages.php');

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
    <script type="text/javascript">

        function pagereload(id){
            window.location = "manage_cards.php?htl_id="+id;
            //alert(id);
            //	window.location.reload('?id='+id);
            //  setTimeout("location.href = 'manage_cards.php?id="+id';",100);
            //  setTimeout("location.href = '?=id'"+id,100);
            //window.location("manage_cards.php");
        }
    </script>


    <style type="text/css">
        .sample_button {
            font-family: Verdana, Arial, sans-serif;
            display: inline-block;
            background: #459300 url('../images/bg-button-green.gif') top left repeat-x    !important;
            border: 1px solid #459300 !important;
            padding: 14px 7px 4px 7px !important;
            color: #fff !important;
            font-size: 11px !important;
            cursor: pointer;
            width: 200px;
            height: 25px;
            text-align: center;
            font-weight: bold;
            margin-left: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }


        .sample_button:hover {
            text-decoration: underline;
        }

        .sample_button:active {
            padding: 5px 7px 3px 7px !important;
        }




        .sample_button2 {
            font-family: Verdana, Arial, sans-serif;
            display: inline-block;
            background: #459300 url('../images/bg-button-green.gif') top left repeat-x    !important;
            border: 1px solid #459300 !important;
            padding: 14px 7px 4px 7px !important;
            color: #fff !important;
            font-size: 10px !important;
            cursor: pointer;
            width: 200px;
            height: 25px;
            text-align: center;
            font-weight: bold;
            margin-left: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }


        .sample_button2:hover {
            text-decoration: underline;
        }

        .sample_button2:active {
            padding: 5px 7px 3px 7px !important;
        }



    </style>

</head>

<body onload="hideDiv();"><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->

    <!--    <div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->-->
    <!---->
    <!---->
    <!---->
    <!--    </div></div> <!-- End #sidebar -->-->

    <?php

    if(isset($_GET['username']) && isset($_GET['link-orig']) && isset($_GET['link-logout']) && isset($_GET['link-status'])){

        $username = base64_decode($_GET['username']);
        $link_status = base64_decode($_GET['link-status']);
        $link_orig = base64_decode($_GET['link-orig']);
        $link_logout = base64_decode($_GET['link-logout']);

    }
    else if(isset($_POST['username']) && isset($_POST['link-orig']) && isset($_POST['link-logout']) && isset($_POST['link-status'])){

        $username = $_POST['username'];
        $link_status = $_POST['link-status'];
        $link_orig = $_POST['link-orig'];
        $link_logout = $_POST['link-logout'];

    }

    ?>

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

        <div style="text-align: center;">

            <a  class="sample_button" href="http://www.google.lk"> Proceed </a>

            <br/><br/>

            <a  class="sample_button" href="http://logout."> Logout from Wi-Fi</a>

            <br/><br/>


<!--            <a  class="sample_button2" href="--><?php //echo $link_status; ?><!--">Connection Info</a>-->

<!--            <br/><br/>-->


            <a  class="sample_button2"  onclick="visibleDiv();" href="#"> Change WiFi Password</a>


        </div>



        <!--        <div id='main_context_box' class="content-box" style="width: 600px;"><!-- Start Content Box -->
        <div id="main_frame" align="center" >
            <div  style="width : 350px;text-align: center;" >

                <h5>Change User Password</h5>



                <ul class="content-box-tabs">
                    <!--<li><a href="#tab1" >View</a></li> -->
                    <!-- href must be unique and match the id of target div -->

                    <!--                    <li><a href="#tab2" class="default-tab">Change User Password</a></li>-->


                </ul>


                <div class="clear"></div>

            </div> <!-- End .content-box-header -->

            <div id="change_password" class="content-box-content">

                <!-- End #tab1 -->

                <form id='change_pw_form' action="../controllers/package-controller.php" method="post" onsubmit="return change_wifi_user_passwords();" >



                    <fieldset>

                        <p>
                            <label> Old Password </label><input class="text-input small-input" type="password" id="user_old_password" name="user_old_password" /> </br>

                        </p>

                        <p>
                            <label> New Password </label><input class="text-input small-input" type="password" id="user_new_password" name="user_new_password" /> </br>

                        </p>

                        <p>
                            <label> Confirm Password </label><input class="text-input small-input" type="password" id="user_confirm_password" name="user_confirm_password" /> </br>

                        </p>

                    </fieldset>
                    <input type="hidden" name="username" id="username" value="<?php echo $username; ?>"/>

                    <input type="hidden" name="link-orig" id="link-orig" value="<?php echo $link_orig; ?>"/>

                    <input type="hidden" name="link-logout" id="link-logout" value="<?php echo $link_logout; ?>"/>

                    <input type="hidden" name="link-status" id="link-status" value="<?php echo $link_status; ?>"/>


                    <input type="hidden" name="action" id="action" value="change_hotel_WiFi_user_password"/>

                    <input type="submit" class="button" value="Change" />

                    <span id="user_pw_change_msg"></span>

                </form>


            </div> <!-- End .content-box-content -->

        </div> <!-- End .content-box -->

        <!-- End .content-box -->

        <!-- End .content-box -->
        <div class="clear"></div>


        <!-- Start Notifications -->



        <!-- End Notifications -->

        <div id="footer">
            <?php //require_once('../includes/footer.php') ?>
        </div><!-- End #footer -->

    </div> <!-- End #main-content -->

</div></body>
<script type="text/javascript">
    $('#5').addClass('current');
</script>


</html>
