<?php
require_once('../config/config.php');
require_once('../controllers/session-controller.php');
require_once('../classess/user-sql.php');
require_once('../classess/reports-sql.php');
require_once('../classess/packages.php');


//$room = $_POST['room_no'];
$hotel = $_POST['hotel'];
$from = trim($_POST['datepicker_from']).' 00:00:00';
$to = trim($_POST['datepicker_to']).' 23:59:59';

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

                <h3>Room WiFi Usage</h3>



                <div class="clear"></div>

            </div> <!-- End .content-box-header -->

            <div class="content-box-content">

                <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->

                    <?php

                    $hotelName = PACKAGES ::getHotelbyid($hotel);

                    echo "<b>Hotel : </b> ".$hotelName." <br/><br/>";
                    echo "<b>From  : </b> ".substr($from,0,10)." <br/><br/>";
                    echo "<b>To    : </b> ".substr($to,0,10)." <br/><br/>";
                    ?>


                    <table  align="left" class="Grid">

                        <thead><tr>
                            <th>Room</th>
                            <th>Start Time</th>
                            <th>Stop Time</th>
                            <th>Session Time</th>
                            <th>Upload (MB)</th>
                            <th>Download (MB)</th>
                            <th>Avg.Usage(Kbps)</th>

                        </tr></thead>

                        <?php

                        $WifiUsages = PACKAGES ::getHotelWiFiUsageForGivenPeriod($hotel,$from,$to);

                        $num_users=0;
                        $total_upload=0;
                        $total_download=0;
                        $total_session_time=0;


                        for($i=0;$i<sizeof($WifiUsages);$i++){

                            $WiFiUsageArr = $WifiUsages[$i];

                            //avg usage

                            if($WiFiUsageArr['session_time']!=0){

                                $avgUsage  =round(($WiFiUsageArr['upload'] + $WiFiUsageArr['download'])/ ($WiFiUsageArr['session_time']*1024) ,4);

                            }
                            else{
                                $avgUsage = 0;
                            }
                            //downloaded mb

                            $hotel_data = PACKAGES :: getHotelOnGivenId($hotel);

                            if(array_key_exists('hotel_code',$hotel_data)){

                            $room_name_without_hotel = str_ireplace($hotel_data['hotel_code'],"",$WiFiUsageArr['username']);

                            }
                            //session time
                            $session_time_seconds = $WiFiUsageArr['session_time'];


                            $hour  = (int)($session_time_seconds /3600);

                            $remainingValue = $session_time_seconds % 3600 ;

                            $minutes = (int) ($remainingValue / 60);

                            //remaining seconds
                            $remainingValue = $remainingValue % 60;

                            $formattedTime =  $hour.":".$minutes.":".$remainingValue;


                            $total_session_time = $total_session_time + $session_time_seconds;
                            $total_download = $total_download + $WiFiUsageArr['download'];
                            $total_upload = $total_upload + $WiFiUsageArr['upload'];

                            ?>

                            <tr>
                                <td><a href="view-room-wifi-usage.php?room_no=<?php echo base64_encode($room_name_without_hotel); ?>&hotel=<?php echo base64_encode($hotel); ?>&from=<?php echo base64_encode($from); ?>&to=<?php echo base64_encode($to); ?>"><?php echo $WiFiUsageArr['username']; ?></a></td>
                                <td><?php echo $WiFiUsageArr['start_time']; ?></td>
                                <td><?php echo $WiFiUsageArr['stop_time']; ?></td>
                                <td><?php echo $formattedTime; ?></td>
                                <td><?php echo round($WiFiUsageArr['upload']/ (1024* 1024),4); ?></td>
                                <td><?php echo round($WiFiUsageArr['download']/ (1024* 1024),4); ?></td>
                                <td><?php echo $avgUsage; ?></td>

                            </tr>

                            <?php
                            $num_users++;
                        }


                        //calculate total session time
                        $hour  = (int)($total_session_time /3600);

                        $remainingValue = $total_session_time % 3600 ;

                        $minutes = (int) ($remainingValue / 60);

                        //remaining seconds
                        $remainingValue = $remainingValue % 60;

                        $formattedTime =  $hour.":".$minutes.":".$remainingValue;


                        ?>


                        <tr >
                            <td style="font-weight: bold;"><?php echo "Number of Users ".$num_users; ?></td>
                            <td style="font-weight: bold;"></td>
                            <td style="font-weight: bold;"></td>
                            <td style="font-weight: bold;"><?php echo $formattedTime; ?></td>
                            <td style="font-weight: bold;"><?php echo round($total_upload/ (1024* 1024),4); ?></td>
                            <td style="font-weight: bold;"><?php echo round($total_download/ (1024* 1024),4); ?></td>
                            <td style="font-weight: bold;"><?php echo round(($total_upload + $total_download)/ ($total_session_time*1024) ,4); ?></td>

                        </tr>



                    </table>




                    <a href="genpdf/pdf/index.php?type=hotel_wifi_usage&from=<?php echo base64_encode($from); ?>&to=<?php echo base64_encode($to); ?>&room=<?php echo base64_encode($room); ?>&hotel=<?php echo base64_encode($hotel); ?>">Export To PDF</a>

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
