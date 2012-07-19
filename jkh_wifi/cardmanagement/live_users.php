<?php
require_once('../config/config.php');
require_once('../controllers/session-controller.php');
require_once('../classess/user-sql.php');
require_once('../classess/packages.php');

$cust_id='';

if($_SESSION['custermer_id']==0){
    $cust_id  = $_GET['htl_id'];

}else{
    $cust_id = $_SESSION['custermer_id'];
}


$liveusers = PACKAGES :: getliveusers($cust_id);



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

    <script type="text/javascript" src="../scripts/jquery.min.js"></script>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $("#expire_date").datepicker();



            $( "#expire_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );


        });
    </script>


    <script type="text/javascript">

        function pagereload(id){
            window.location = "live_users.php?htl_id="+id;

        }
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

            <h3>Live Users</h3>

            <ul class="content-box-tabs">
                <!--<li><a href="#tab1" >View</a></li> -->
                <!-- href must be unique and match the id of target div -->








                <li><a href="#tab2" class="default-tab">Live Users</a></li>
            </ul>

            <div class="clear"></div>

        </div> <!-- End .content-box-header -->

        <div class="content-box-content">

            <!-- End #tab1 -->
            <?php if($_SESSION['group_id']==3 || $_SESSION['group_id']==4 ){ ?>

            <div>
                <form onsubmit="return false">
                    <fieldset>


                        <p>
                            <label>Select a Hotel</label>
                            <select name="custermer" id="htl_id" class="small-input" onchange="pagereload(this.value)">
                                <option value="">Please select</option>
                                <?php
                                $hotels = USER ::getHotels();
                                while($rowhotels = mysql_fetch_array($hotels)){
                                    ?>
                                    <option <?php if($_GET['htl_id']==$rowhotels['groupid']){echo "selected='selected'";} ?> value="<?php echo $rowhotels['groupid']; ?>"><?php echo $rowhotels['groupname']; ?></option>
                                    <?php } ?>

                            </select>





                        </p>
                    </fieldset>
                </form>
            </div>
            <?php } ?>



            <?php //echo $_SESSION['custermer_id']."custermor id"; ?>


            <div class="tab-content default-tab" id="tab2">
                <?php if(count($liveusers)!=0){
                ?>
                <?php } ?>

                <?php if(count($liveusers)==0){

                echo "<Center>No Live Users now.</center>";

            }else{?>
                <table   >

                    <thead>
                    <tr >
                        <th>Room No</th>
                        <th>Contact</th>
                        <th>Start Time</th>
                        <th>Session Time</th>
                        <th>Downloaded MB</th>
                        <th>Uploaded MB</th>
                        <th>IP Address</th>
                        <th>Inst rate (Kbps)</th>

                    </tr>
                    </thead>

                    <?php
                    $z=0;
                    if (!empty($liveusers)) {
                        foreach ($liveusers as $wifiuser) {

                            //calculate average usage
                            $uploaded_bytes = $wifiuser['uploadedbytes'];
                            $downloaded_bytes = $wifiuser['downloadedbytes'];

                            $session_time = $wifiuser['sessiontime'];

                            //$average_usage = ($uploaded_bytes + $downloaded_bytes) / ($session_time * 1024);

                            //$average_usage = round($average_usage,4);

                            $average_usage = round($wifiuser['downd']/(60*1024),4);
		//	$average_usage = round($wifiuser['downloadedbytes']);


                            //session time

                            $session_time_seconds = $wifiuser['sessiontime'];


                            $hour  = (int)($session_time_seconds /3600);

                            $remainingValue = $session_time_seconds % 3600 ;

                            $minutes = (int) ($remainingValue / 60);

                            //remaining seconds
                            $remainingValue = $remainingValue % 60;

                            $formattedTime =  $hour.":".$minutes.":".$remainingValue;
                            ?>
                            <tr>
                                <td><a href="http://203.143.20.173/usergraph/users.php?user_id=<?php echo base64_encode($wifiuser['name']); ?>" ><?php echo $wifiuser['name']; ?></a></td>
                                <td><?php echo $wifiuser['contact']; ?></td>
                                <td ><?php echo $wifiuser['starttime'];?></td>
                                <td><?php echo $formattedTime;?></td>
                                <td ><?php echo round($wifiuser['downloadedbytes']/(1024*1024),4);?></td>
                                <td ><?php echo round($wifiuser['uploadedbytes']/(1024*1024),4);?></td>
                                <td ><?php echo $wifiuser['ipaddress'];?></td>
                                <td ><?php echo $average_usage; ?></td>

                            </tr>
                            <?php
                        }
                    }
                    ?>





                </table>




                <?php } ?>



            </div> <!-- End #tab2 -->

        </div> <!-- End .content-box-content -->
<?php if (!empty($liveusers)) { ?>
        <br/><br/>
        <h3> Total Number of Live Users : <?php echo sizeof($liveusers); ?></h3>
<?php } ?>

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
