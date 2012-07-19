<?php
require_once('../config/config.php');
require_once('../controllers/session-controller.php');
require_once('../classess/user-sql.php');
require_once('../classess/packages.php');

$cust_id='';

if($_SESSION['custermer_id']==0 && isset($_GET['htl_id'])){

    $cust_id  = $_GET['htl_id'];

}else{
    $cust_id = $_SESSION['custermer_id'];
}




$allusers = PACKAGES :: getAllCards($cust_id);


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

            <h3>Manage Cards</h3>

            <ul class="content-box-tabs">
                <!--<li><a href="#tab1" >View</a></li> -->
                <!-- href must be unique and match the id of target div -->








                <li><a href="#tab2" class="default-tab">Manage Cards</a></li>
            </ul>

            <div class="clear"></div>

        </div> <!-- End .content-box-header -->

        <div class="content-box-content">

            <!-- End #tab1 -->




            <div class="tab-content default-tab" id="tab2">
                <form onsubmit="return false">
                    <fieldset>

                        <p>
                        <center>
                            <input class="text-input small-input"  id="search_txt" type="text"  onFocus="managecardsvalidkey(event)" onClick="managecardsvalidkey(event)" onKeyPress="managecardsvalidkey(event)" autocomplete="on"/>&nbsp;&nbsp;&nbsp;
                            <input type="button" value="Search" class="button" onclick="searchbycardusername()"/>
                            <br/> <br/>
                            <span style="color:#CCC;padding-right:60px;">Please type Hotel Room Number / Card Username.</span>

                        </center>

                        </p>
                    </fieldset>
                </form>


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

                <div id="search_results_by_username">
                    <?php

                    if(!isset($_GET['htl_id']) && $_SESSION['custermer_id']==0){

                        echo "<br/><br/><br/><center><b>Please Select a Hotel...</b></center>";
                    }else{

                        if(mysql_num_rows($allusers)==0){echo "<br/><br/><br/><center><b>No results found</b></center>";}else{ ?>


                            <table>
                                <thead>
                                <tr>
                                    <th>Room number</th>
<!--                                    <th>Password</th>-->
                                    <th>Simultaneous Users</th>
                                    <th>Expiry date</th>
                                    <th>Service Id</th>
                                    <?php

                                    // if($_SESSION['group_id']!=1 ){ ?>
                                    <th>Action</th>
                                    <?php //}?>
                                </tr>
                                </thead>
                                <?php
                                while($rowallusers=mysql_fetch_array($allusers)){
                                    ?>
                                    <tr id="rmcards<?php echo $rowallusers['username'] ?>">
                                        <td>  <a href="view_user_history.php?id=<?php echo $rowallusers['username']; ?>"><b><?php echo $rowallusers['username']; ?></b></a></td>
<!--                                        <td>--><?php //echo PACKAGES :: getPassword($rowallusers['username']); ?><!--</td>-->
                                        <td><center><?php echo PACKAGES :: getSimultanoususers($rowallusers['username']); ?></center></td>
                                        <td><?php echo $rowallusers['expiration']; ?></td>
                                        <td><?php echo $rowallusers['srvname']; ?></td>

                                        <td>

                                            <a href="edit_cards.php?id=<?php echo $rowallusers['username']; ?>&srv_id=<?php echo $rowallusers['srvid']; ?>"><img src="../images/icons/pencil.png"  style="cursor:pointer;" title="Edit User Details" /></a>
                                            <?php

                                            if($_SESSION['group_id']!=1 ){ ?>

                                                <img src="../images/icons/cross.png" style="cursor:pointer;" onclick="deletefunc('rmcards<?php echo $rowallusers['username']; ?>','act_delhtlroomcard','<?php echo $rowallusers['username']; ?>','Are you sure want to delete this card ?')" title="Remove User" />


                                                <?php }

                                            if($_SESSION['group_id']==2 || $_SESSION['group_id']==3 || $_SESSION['group_id']==4 || $_SESSION['group_id']==1){
                                                ?>

                                                <a href="../usermanagement/change-user-password.php?id=<?php echo base64_encode($rowallusers['username']); ?>"" ><img width="16px" height="16px" src="../images/icons/key.png"  style="cursor:pointer;" title="Change Password" /></a>
                                                <?php
                                            }

                                            ?>


                                        </td>

                                    </tr>
                                    </tr>
                                    <?php } ?>


                            </table>

                            <?php }
                    }?>
                </div>
            </div> <!-- End #tab2 -->
            <br/><br/>
            <h3> Total Number of Users : <?php echo mysql_num_rows($allusers); ?></h3>
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
