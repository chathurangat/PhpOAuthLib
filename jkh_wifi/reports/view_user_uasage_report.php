<?php
require_once('../config/config.php');
require_once('../controllers/session-controller.php');
require_once('../classess/user-sql.php');
require_once('../classess/packages.php');

$user_id="";

$roomUsage = "";

if(isset($_GET['id'])){

    $user_id = $_GET['id'];
    $roomUsage = PACKAGES :: getCardUsageHistoryForGivenRoom($_GET['id']);
}
else if($_POST['user_id']){

    $user_id = $_POST['user_id'];
    $start_date = $_POST['start_date'];
    $stop_date = $_POST['stop_date'];

    //$roomUsage = PACKAGES :: getCardUsageHistoryForGivenRoomForGivenDateRange($user_id,'kkkk','hhhh');
    $roomUsage = PACKAGES :: getCardUsageHistoryForGivenRoomForGivenDateRange($user_id,$start_date,$stop_date);
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
    <link rel="stylesheet" href="../css/upload.css.css" type="text/css" media="screen" />

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


    <style type="text/style">





    </style>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>

    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <!--  <script type="text/javascript">
    $(document).ready(function() {
      //$("#expire_date").datepicker();
      //


      //$( "#expire_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );


    });
    </script>-->

    <script>
        $(function() {
            $("#start_date").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: false,
                changeYear: false,
            });

            $("#stop_date").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: false,
                changeYear: false,
            });
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

                <h3>User History</h3>

                <ul class="content-box-tabs">
                    <!--<li><a href="#tab1" >View</a></li> -->
                    <!-- href must be unique and match the id of target div -->


                    <li><a href="#tab2" class="default-tab">User History</a></li>
                </ul>


                <div class="clear"></div>



            </div> <!-- End .content-box-header -->

            <div class="content-box-content">

                <!-- End #tab1 -->
                <form id='filter_options' method="post" action="view_user_history.php" />

                <fieldset>
                    <p>
                        <label>Start Date</label>
                        <input class="text-input small-input" type="text"   value=""  name='start_date'  id="start_date" name="small-input" onchange="filterAndLoadUsageDetails();" />


                        <label style="margin-left: 20px;">Stop Date</label>
                        <input class="text-input small-input" type="text"   value=""  name='stop_date'  id="stop_date" name="small-input" onchange="filterAndLoadUsageDetails();" />


                    </p>

                </fieldset>

                <input type="hidden" id='user_id' name='user_id' value="<?php echo $user_id; ?>"/>
                <input type="submit" name="submit"class="button" value="Get Range" />
                </form>

                <table>

                    <thead>
                    <tr >
                        <th>Room No</th>
                        <th>Start Time</th>
                        <th>Stop Time</th>
                        <th>Terminate Reason</th>
                        <th>Downloaded Bytes</th>
                        <th>Uploaded Bytes</th>
                        <th>IP </th>
                        <th>Session Time</th>
                        <th>Avg. usage</th>

                    </tr>
                    </thead>

                    <?php

                    if (!empty($roomUsage)) {
                        foreach ($roomUsage as $usageData) {

                            //calculate average usage
                            $uploaded_bytes = $usageData['upload_bytes'];
                            $downloaded_bytes = $usageData['download_bytes'];

                            $session_time = $usageData['session_time'];

                            $average_usage = ($uploaded_bytes + $downloaded_bytes) / ($session_time * 1024);

                            $average_usage = round($average_usage,4).' Kbps';


                            ?>
                            <tr>
                                <td><?php echo $usageData['username']; ?></td>
                                <td ><?php echo $usageData['start_time'];?></td>
                                <td ><?php echo $usageData['stop_time'];?></td>
                                <td ><?php echo $usageData['terminate_reason'];?></td>
                                <td ><?php echo $usageData['download_bytes'];?></td>
                                <td ><?php echo $usageData['upload_bytes'];?></td>
                                <td ><?php echo $usageData['ip_address'];?></td>
                                <td ><?php echo $usageData['session_time'];?></td>
                                <td ><?php echo $average_usage; ?></td>

                            </tr>
                            <?php
                        }
                    }
                    ?>





                </table>


                <div class="tab-content default-tab" id="tab2">



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
    $('#5').addClass('current');
</script>


</html>
