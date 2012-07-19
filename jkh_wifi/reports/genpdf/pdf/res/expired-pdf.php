<?php 
require_once('../../../config/config.php');
require_once('../../../classess/user-sql.php');
require_once('../../../classess/reports-sql.php');



$custermer_id = $_REQUEST['custermer'];
$from = $_REQUEST['from'];
$to = $_REQUEST['to'];


$expiredusers = REPORTS::getexpiredusers($custermer_id,$from,$to);

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
echo "<h3>Expired Users of ".USER::getcustermerbyid($_REQUEST['custermer'])."</h3>";
echo "<div>From ".$from." To ".$to."</div>";
						?>
                        
                        
                       
                        <table align="left" class="Grid"  >
                        
               <thead> 
               <tr style="background-color:#F60;color:#FFF;">
                <th>Serial#</th>
 <?php if($_SESSION['group_id']==4 || $_SESSION['user_id']==66 || $_SESSION['user_id']==63){ ?><th>User</th><?php } ?>         
			   <?php if($_SESSION['group_id']==4 || $_SESSION['user_id']==66){ ?><th>Password</th><?php } ?>
                <th>Package (Card Value)</th>
                <th>Start Time</th>
                <th>Expiry Date</th>
                <th>Usage Time</th>
             
                </tr>
                </thead>   
                        
 			<?php			
					$z=0;
                        if (!empty($expiredusers)) {
                            foreach ($expiredusers as $wifiuser) {
                    ?>
                    <tr>
                        <td><?php echo $wifiuser['id']; ?></td>
           <?php if($_SESSION['group_id']==4 || $_SESSION['user_id']==66 || $_SESSION['user_id']==63){ ?><td><?php echo $wifiuser['name']; ?></td><?php } ?>      
         <?php if($_SESSION['group_id']==4 || $_SESSION['user_id']==66){ ?><td><?php echo $wifiuser['value']; ?></td >  <?php } ?>         
                        <td  align="right">Rs <?php echo $wifiuser['price']; 
						$z+=$wifiuser['price'];						?></td>
                         <td ><?php echo $wifiuser['starttime'];?></td>
                          <td ><?php echo $wifiuser['expiretime'];?></td>
                          <td ><?php echo $wifiuser['usagetime'];?></td>
                        
                        </tr>
<?php
                            }
                        }
?>

          
               
               
               
                        </table>
                        
                        
                                       
                      <?php 	echo "<b>Total : Rs.".$z."</b>"; ?>
                        
                        
                        
						
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
