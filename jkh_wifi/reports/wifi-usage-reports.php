<?php
require_once('../config/config.php');
require_once('../controllers/session-controller.php');
require_once('../classess/user-sql.php');
require_once('../classess/reports-sql.php');
require_once('../classess/packages.php');
require_once('../classess/privileges.php');


if(privileges :: isUserHavingPrivilege($_SESSION['user_id'],6)==false){

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
            $("#datepicker_from").datepicker({ changeMonth: true , changeYear: true });
            $( "#datepicker_from" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
            $("#datepicker_to").datepicker({ changeMonth: true , changeYear: true });
            $( "#datepicker_to" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

//            $('#datepicker_from').simpleDatepicker();

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

                <h3>WiFi Usage</h3>



                <div class="clear"></div>

            </div> <!-- End .content-box-header -->

            <div class="content-box-content">

                <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
                    <form action="view-room-wifi-usage.php" method="post" onsubmit="return validateWiFiUsageReportRequest();">
                        <fieldset>


                            <!--For JKH Super Admin and LCS Administrators and Front Office Managers-->
                            <?php // if($_SESSION['group_id']==3 || $_SESSION['group_id']==4 || $_SESSION['group_id']==2){ ?>
                            <p>
                                <label>Select a Hotel</label>
                                <select name="hotel_list"  class="small-input" id="hotel_list" onchange="loadRoomsBasedOnHotel(this.value);" >
                                    <option value="">Please select</option>
                                    <?php
                                   // $hotels = PACKAGES ::getAllAvailableHotels();
                                    $hotels_result = USER ::getHotelsBasedOnLoggedUserGroup();


                                   // $hotels = mysql_fetch_array($hotels_result);


                                    while($hotel = mysql_fetch_array($hotels_result)){
                                  //  for($index=0 ;$index < sizeof($hotels) ; $index++){

                                      //  $hotel_data = $hotels[$index];

                                        ?>
                                        <option value="<?php echo $hotel['groupid']; ?>"><?php echo $hotel['groupname']; ?></option>
                                        <?php } ?>

                                </select>
                                <span id="msg_user_hotel"></span>
                            </p>


<!--                            <input type="hidden" name="hotel" id="hotel" value="123"/>-->

                            <?php // }
                        //else{
                            //hotel is set to the hotel that the user has been assigned
                            ?>

<!--                            <input type="hidden" name="hotel" id="hotel" value="--><?php //echo $_SESSION['custermer_id']; ?><!--"/>-->

                            <?php
                       // }
                            ?>

                            <!--                            <p>-->
                            <!--                                <label>Room No</label>-->
                            <!--                                <input type="text"  id="room_no" name="room_no" />-->
                            <!--                            </p>-->

                            <div id="room_no_selection">

                            </div>




                            <p>
                                <label>From</label>
                                <input type="text"  id="datepicker_from" name="datepicker_from" autocomplete="off" />
                            </p>
                            <p>
                                <label>To</label>
                                <input type="text"  id="datepicker_to" name="datepicker_to" autocomplete="off" />
                            </p>

                            <p>		<input class="button" type="submit" value="Search" /></p>

                        </fieldset>


                    </form>

                    <!--                    <a href="genpdf/pdf/index.php?type=room_wifi_usage">Generate PDF</a>-->

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
    $('#4').addClass('current');
</script>


</html>
