<?php
require_once('../../../config/config.php');
require_once('../../../classess/user-sql.php');
require_once('../../../classess/reports-sql.php');
require_once('../../../classess/packages.php');

$hotel = base64_decode($_REQUEST['hotel']);
$room = base64_decode($_REQUEST['room']);
$from = base64_decode($_REQUEST['from']);
$to = base64_decode($_REQUEST['to']);


$WifiUsages = PACKAGES ::getRoomWiFiUsageForGivenPeriod($hotel,$room,$from,$to);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <link rel="stylesheet" href="../../../css/tables.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../../../css/invalid.css" type="text/css" media="screen" />


    <!-- Main Stylesheet -->



</head>

<body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->

    <div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->

        <!-- End #main-nav -->

        <!-- End #messages -->

    </div></div> <!-- End #sidebar -->

    <div id="main-content"> <!-- Main Content Section with everything -->



        <!-- Page Head -->

        <!-- End .shortcut-buttons-set -->

        <div class="clear"></div> <!-- End .clear -->

        <div class="content-box"><!-- Start Content Box -->

            <!-- End .content-box-header -->

            <div class="content-box-content">

                <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->



                    <img src="../../../images/lankacom-logo.jpg"/>
                    <?php
                    echo "<h3>Active Users of Sample</h3>";
                    echo "<div>From :  ".substr($from,0,10)."         TO :  ".substr($to,0,10)."</div>";
                    ?>



                    <table  align="left" class="Grid">

                        <thead><tr>
                            <th>Name</th>
                            <th>Passport/NIC</th>
                            <!--                            <th>Service Start Date</th>-->
                            <!--                            <th>Service Stop Date</th>-->
                            <th>Acc Start time</th>
                            <th>Acc Stop time</th>
                            <th>Session time</th>
                            <th>IP</th>
                            <th>Uploaded MB</th>
                            <th>Downloaded MB</th>
                            <th>Avg Usage(Kbps)</th>
                        </tr></thead>

                        <?php


                        $num_users = 0;
                        $total_upload=0;
                        $total_download=0;
                        $total_session_time=0;

                        for($i=0;$i<sizeof($WifiUsages);$i++){

                            $WiFiUsageArr = $WifiUsages[$i];

                            //avg usage

                            if($WiFiUsageArr['acc_session_time']!=0){
                                $avgUsage  =round(($WiFiUsageArr['uploaded_bytes'] + $WiFiUsageArr['downloaded_bytes'])/ ($WiFiUsageArr['acc_session_time']*1024) ,4);

                            }
                            else{
                                $avgUsage = 0;
                            }
                            //downloaded mb


                            $total_session_time = $total_session_time + $WiFiUsageArr['acc_session_time'];
                            $total_download = $total_download + $WiFiUsageArr['downloaded_bytes'];
                            $total_upload = $total_upload + $WiFiUsageArr['uploaded_bytes'];


                            //session time
                            $session_time_seconds = $WiFiUsageArr['acc_session_time'];


                            $hour  = (int)($session_time_seconds /3600);

                            $remainingValue = $session_time_seconds % 3600 ;

                            $minutes = (int) ($remainingValue / 60);

                            //remaining seconds
                            $remainingValue = $remainingValue % 60;

                            $formatted_time =  $hour.":".$minutes.":".$remainingValue;



                            ?>

                            <tr>
                                <td><?php echo $WiFiUsageArr['contact_name']; ?></td>
                                <td><?php echo $WiFiUsageArr['nic_passport_no']; ?></td>
                                <!--                                <td>--><?php //echo $WiFiUsageArr['service_start_date']; ?><!--</td>-->
                                <!--                                <td>--><?php //echo $WiFiUsageArr['service_stop_date']; ?><!--</td>-->
                                <td><?php echo $WiFiUsageArr['acc_start_time']; ?></td>
                                <td><?php echo $WiFiUsageArr['acc_stop_time']; ?></td>
                                <td><?php echo $formatted_time; ?></td>
                                <td><?php echo $WiFiUsageArr['ip_address']; ?></td>
                                <td><?php echo round($WiFiUsageArr['uploaded_bytes']/ (1024* 1024),4); ?></td>
                                <td><?php echo round($WiFiUsageArr['downloaded_bytes']/ (1024* 1024),4); ?></td>
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
                            <td style="font-weight: bold;"></td>
                            <td style="font-weight: bold;"><?php echo $formattedTime; ?></td>
                            <td style="font-weight: bold;"></td>
                            <td style="font-weight: bold;"><?php echo round($total_upload/ (1024* 1024),4); ?></td>
                            <td style="font-weight: bold;"><?php echo round($total_download/ (1024* 1024),4); ?></td>
                            <td style="font-weight: bold;"><?php echo round(($total_upload + $total_download)/ ($total_session_time*1024) ,4); ?></td>

                        </tr>


                    </table>




                </div> <!-- End #tab1 -->


                <!-- End #tab2 -->

            </div> <!-- End .content-box-content -->

        </div> <!-- End .content-box -->

        <!-- End .content-box -->

        <!-- End .content-box -->
        <div class="clear"></div>


        <!-- Start Notifications -->




        <!-- End Notifications -->


    </div> <!-- End #main-content -->

</div></body>


</html>
