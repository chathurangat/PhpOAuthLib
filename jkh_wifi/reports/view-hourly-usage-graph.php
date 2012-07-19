<?php
require_once('../config/config.php');
require_once('../controllers/session-controller.php');
require_once('../classess/user-sql.php');
require_once('../classess/reports-sql.php');
require_once('../classess/packages.php');
require_once('../classess/privileges.php');

if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],3)==false){

    header("Location: ../");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <title>Lanka Communication Services Radius Manager Administration Panel</title>

    <!--                       CSS                       -->

    <!-- Reset Stylesheet -->
    <link rel="stylesheet" href="../css/reset.css" type="text/css" media="screen" />
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
    <!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
    <link rel="stylesheet" href="../css/invalid.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../css/jquery.alerts.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../css/jquery-ui.css" type="text/css" media="screen" />

    <!-- Internet Explorer Fixes Stylesheet -->
    <!--[if lte IE 7]>
    <link rel="stylesheet" href="resources/css/ie.css" type="text/css" media="screen" />
    <![endif]-->
    <!--                       Javascripts                       -->
    <!-- jQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
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

    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>

    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#datepicker_from").datepicker();
            $( "#datepicker_from" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
            $("#datepicker_to").datepicker();
            $( "#datepicker_to" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        });
    </script>


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

                <h3>Hourly Traffic</h3>



                <div class="clear"></div>

            </div> <!-- End .content-box-header -->

            <div class="content-box-content">

                <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->

                    <form method="post" action="#" name="hotel_selection">
                        <p>
                            <label>Select a Hotel</label>
                            <select name="hotel_id"  class="small-input" id="hotel_id" onchange="displayHourlyGraphForGivenHotel(this.value);" >
                                <option value="">Please select</option>
                                <?php
                                if($_SESSION['group_id']==3 || $_SESSION['group_id']==4){

                                    $hotels = PACKAGES ::getAllAvailableHotels();
                                    // while($hotel = mysql_fetch_array($hotels)){
                                    for($index=0 ;$index < sizeof($hotels) ; $index++){

                                        $hotel_data = $hotels[$index];

                                        ?>
                                        <option value="<?php echo $hotel_data['hotel_id']; ?>"><?php echo $hotel_data['hotel_name']; ?></option>
                                        <?php
                                    }
                                }
                                else{
                                    //receptionist has logged in
                                    $hotel_data = PACKAGES :: getHotelOnGivenId($_SESSION['custermer_id']);
                                    ?>

                                    <option value="<?php echo $hotel_data['hotel_id']; ?>"><?php echo $hotel_data['hotel_name']; ?></option>

                                    <?php

                                }?>

                            </select>
                            <span id="msg_user_hotel"></span>
                        </p>

                    </form>

                    <div id="date_time_section">

                        <br/><br/>

                        <b> Date :</b>
                        <?php
                        //echo date("Y-m-d");

                        $t=time();
                        //echo($t . "<br />");
                        echo(date("D F d Y",$t));

                        ?>

                        <b style="margin-left: 50px;"> Time :</b><?php $time = date(' h:i:s a', time());echo $time;?>

                        <br/><br/>

                    </div>

                    <div style="color: #3366FF;background:#3366FF; width: 10px;"> .</div> <label style="color: #3366FF;">Outgoing Traffic</label>

                    <div style="color: #57a000;background:#57a000; width: 10px;">.</div> <label style="color: #57a000;">Incoming Traffic</label>

                    <br/>


                    <div id="graph_frame_div">

                        <!--                        <iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="http://203.143.20.173/cgi-bin/routers2.cgi?rtr=chaayaBlue.cfg&bars=Cami&xgtype=6&page=graph&xgstyle=y3&xmtype=options&if=_summary_"></iframe>-->


                    </div>


                </div> <!-- End #tab1 -->

                <!-- End #tab2 -->

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
    $('#3').addClass('current');
</script>


</html>
