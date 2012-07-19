<?php
require_once('../config/config.php');
require_once('../controllers/session-controller.php');
require_once('../classess/user-sql.php');
require_once('../classess/reports-sql.php');

if($_SESSION['group_id']!=3){
    die();
}


$custermer_id = $_SESSION['custermer_id'];


$liveusers = REPORTS::getliveusers($custermer_id);


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
    <link rel="stylesheet" href="../css/demo_table.css" type="text/css" media="screen" />

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
    <script type="text/javascript" src="../scripts/jquery.dataTables.js"></script>


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
            $("#datepicker").datepicker();
            $("#datepicker2").datepicker();
        });
    </script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('.Grid').dataTable({

            });

        } );



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

                <?php
                echo "<h3>WiFi Live user Details of ".USER::getcustermerbyid($custermer_id)."</h2><br/>";
                //echo "<div style='float:right;padding-right:20px;'><b>From ".$from." To ".$to."</b></div>";	 ?>



                <div class="clear"></div>

            </div> <!-- End .content-box-header -->

            <div class="content-box-content">

                <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
                    <?php



                    ?>


                <div> <h5 style="color:#060;">Live Users</h5>

                    <?php if(count($liveusers)!=0){
                        ?>
                        <span style="float:right;"></span></div><?php } ?>

                    <?php if(count($liveusers)==0){

                        echo "<Center>No Live Users now.</center>";

                    }else{?>
                        <table align="left" class="Grid"  >

                            <thead>
                            <tr style="background-color:#060;color:#FFF;">
                                <th>Serial#</th>
                                <?php if($_SESSION['group_id']==4 || $_SESSION['user_id']==66 || $_SESSION['user_id']==63){ ?><th>User</th><?php } ?>
                                <?php if($_SESSION['group_id']==4 || $_SESSION['user_id']==66){ ?><th>Password</th><?php } ?>
                                <th>Package (Card Value)</th>
                                <th>Start Time</th>

                            </tr>
                            </thead>

                            <?php
                            $z=0;
                            if (!empty($liveusers)) {
                                foreach ($liveusers as $wifiuser) {
                                    ?>
                                    <tr>
                                        <td><?php echo $wifiuser['id']; ?></td>
                                        <?php if($_SESSION['group_id']==4 || $_SESSION['user_id']==66 || $_SESSION['user_id']==63){ ?><td><?php echo $wifiuser['name']; ?></td><?php } ?>
                                        <?php if($_SESSION['group_id']==4 || $_SESSION['user_id']==66){ ?><td><?php echo $wifiuser['value']; ?></td >  <?php } ?>

                                        <td  align="right">Rs <?php echo $wifiuser['price'];
                                            $z+=$wifiuser['price'];						?></td>
                                        <td ><?php echo $wifiuser['starttime'];?></td>





                                    </tr>
                                    <?php
                                }
                            }
                            ?>





                        </table>




                        <?php } ?>



                </div> <!-- End #tab1 -->
                <hr/>




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
