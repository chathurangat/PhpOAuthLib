<?php require_once(DOCUMENT_ROOT."classess/privileges.php"); ?>

<!--<h2>Welcome  --><?php //if(isset($_SESSION['name'])){ echo $_SESSION['name']; } else{ echo "Guest"; } ?><!--</h2>-->

<?php
if($_SESSION['custermer_id']==0){
    //user with no hotel
    ?>
<h3>Welcome <?php if(isset($_SESSION['name'])){ echo $_SESSION['name']; } else{ echo "Guest"; } ?></h3>
<?php
}
else{

    //user with hotel
    //getting hotel name
    $result = mysql_query("select * from system_hotel_graph_codes where hotel_id = ".$_SESSION['custermer_id']."");

    $hotel_data =  mysql_fetch_array($result);

    $hotel_name_from_pageHeader = $hotel_data['hotel_name'];

    ?>
<h3>Welcome  to <?php echo $hotel_data['hotel_name']." : ";  if(isset($_SESSION['name'])){ echo $_SESSION['name']; } else{ echo "Guest"; } ?></h3>

<?php
}
?>


<?php
$hotel_id = $_SESSION['custermer_id'];
$group_id = $_SESSION['group_id'];

//getting user type
$sql = mysql_query("select * from system_users_types where USER_TYPE_ID= ".$group_id."");

//getting  hotel name
?>
<p id="page-intro">WiFi Management System of Keels Hotel Management Services </p>

<ul class="shortcut-buttons-set">
    <?php if(isset($_SESSION['group_id']) && $_SESSION['group_id']==4){ ?>
    <li><a class="shortcut-button" href="<?php echo HTTP_PATH;?>usermanagement/add-new-user.php"><span>
					<img src="<?php echo HTTP_PATH;?>images/icons/manage_users.png" alt="icon" width="48"/><br />
					Manage Users
				</span></a></li>
    <?php } ?>
    <!--<li><a class="shortcut-button" href="<?php echo HTTP_PATH;?>reports/wifi-usage-reports.php"><span>
					<img src="<?php echo HTTP_PATH;?>images/wifi.png" alt="icon" width="48"/><br />
					WiFi Usage
				</span></a></li>
	-->
</ul>