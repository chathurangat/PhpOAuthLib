<?php
require_once('../config/config.php');
require_once('../controllers/session-controller.php');
require_once('../classess/user-sql.php');
require_once('../classess/packages.php');



$roomcardbyusername = PACKAGES :: getroomcardbyusername($_GET['id']);



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
            $("#expire_date").datepicker({
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

        <h3>Edit Cards</h3>

        <ul class="content-box-tabs">
            <!--<li><a href="#tab1" >View</a></li> -->
            <!-- href must be unique and match the id of target div -->








            <li><a href="#tab2" class="default-tab">Add Cards</a></li>
        </ul>

        <div class="clear"></div>

    </div> <!-- End .content-box-header -->

    <div class="content-box-content">

        <!-- End #tab1 -->




        <div class="tab-content default-tab" id="tab2">

            <form action="#" method="post" name="gencards">
                <?php //echo $roomcardbyusername['expiration']; ?>
                <?php
                //print_r($roomcardbyusername);
                ?>

                <fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->


                    <?php   if($_SESSION['group_id']==1 || $_SESSION['group_id']==2 ){
                        ?>

                        <input type="hidden" id="htl_id" value="<?php echo $_SESSION['custermer_id']?>"  />
                        <?php
                    }else{
                        ?>

                        <p>







                            <label>Select a Hotel</label>
                            <select name="custermer" id="htl_id" class="small-input" <?php if($_SESSION['group_id']==1){  echo 'disabled="disabled"'; } ?> >
                                <option value="">Please select</option>
                                <?php
                                $hotels = USER ::getHotels();
                                while($rowhotels = mysql_fetch_array($hotels)){
                                    ?>
                                    <option <?php if($rowhotels['groupid']== $roomcardbyusername['groupid']){  echo "selected='selected'";} ?> value="<?php echo $rowhotels['groupid']; ?>"><?php echo $rowhotels['groupname']; ?></option>
                                    <?php } ?>

                            </select>





                        </p>
                        <?php } ?>




                    <p>

                        <label>Hotel Room No / Username</label>
                        <input <?php if($_SESSION['group_id']==1){  echo 'disabled="disabled"'; } ?> class="text-input small-input" value="<?php echo $roomcardbyusername['username']; ?>"  type="text" id="user_name" name="small-input"  onkeyup="getroom_info()" onchange="getroom_info()" onkeypress="getroom_info()" /> <span id="msg_user_name" style="color:red;"></span>


                    </p>


                    <p>

                        <label>No of Simultaneous Users</label>


                        <select id="simultanious_users" >
                            <?php

                            $su = PACKAGES :: getSimultanoususers($roomcardbyusername['username']);

                            $x=1;
                            while($x<10){ ?>

                                <option <?php if($su==$x){  echo "selected='selected'";} ?> value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                <?php
                                $x++;
                            }
                            ?>
                        </select>

                        <span id="msg_user_name"></span>


                    </p>



                    <p>
                        <label>Expire Date</label>
                        <input class="text-input small-input" type="text"  value="<?php echo $roomcardbyusername['expiration']; ?>"     id="expire_date" name="small-input" /> <span id="msg_user_name"></span>


                    </p>





                    <?php

//                    if($_SESSION['group_id']==1  ){
if($_SESSION['group_id']!=2 && $_SESSION['group_id']!=3 && $_SESSION['group_id']!=4){

                        ?>

                        <input type="hidden" id="service" value="12"  />
                        <?php
                    }else{
                        ?>


                        <p>
                            <label>Service (Bandwidth)</label>
                            <select name="service" id="service" class="small-input">
                                <!--<option value="">Please select</option>-->
                                <?php
                                $services = PACKAGES :: getServices();
                                while($rowservices = mysql_fetch_array($services)){
                                    ?>
                                    <option  <?php if($rowservices['srvid']==$_GET['srv_id']){echo ' selected="selected"';} ?>   <?php if($_SESSION['group_id']==1){echo ' disabled="disabled"';} ?>    value="<?php echo $rowservices['srvid']; ?>"            ><?php echo $rowservices['srvname']; ?></option>
                                    <?php } ?>

                            </select>



                        </p>


                        <?php } ?>



                    <p><span id="msg_added_cards"></span></p>

                    <p>
                        <input type="hidden"  value="<?php echo $roomcardbyusername['username']; ?>" id="user_name_original"/>
                        <input class="button" type="button" value="Add" onclick="edit_cardsbyhotelroom();"/>
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
    $('#5').addClass('current');
</script>


</html>
