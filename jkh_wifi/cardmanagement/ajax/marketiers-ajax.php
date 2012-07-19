<?php 
require_once('../../config/config.php');
require_once('../../controllers/session-controller.php');
require_once('../../classess/user-sql.php');

$allmarketiers = USER :: getallmarketiers();
$allmarketiers_select = USER :: getallmarketiers();


?>		

  <ul>
                          <?php 
						while($rowallmarketiers=mysql_fetch_array($allmarketiers)){
						?>
                        <li><h4><?php echo $rowallmarketiers['name']; ?></h4></li>
                        	<div style="margin-left:40px;">                            
                            
                      <ul>
    <?php
	$marketierscustermers = USER :: getMarketierscustermers($rowallmarketiers['user_id']);
	
	if(mysql_num_rows($marketierscustermers)==0){
		echo "Currently ".$rowallmarketiers['name']." do not have any custermers.";
		}else{
			 while($rowmarketierscustermers = mysql_fetch_array($marketierscustermers)){ ?>
      <li id="cus<?php echo $rowmarketierscustermers['data_id']; ?>"><?php echo USER::getcustermerbyid($rowmarketierscustermers['hotel_id']);  ?>&nbsp;&nbsp;
      
      <img src="../images/icons/cross.png" style="cursor:pointer;" onclick="deletefunc('cus<?php echo $rowmarketierscustermers['data_id']; ?>','act_delmarketiercustermer','<?php echo $rowmarketierscustermers['data_id']; ?>','Are you sure want to delete this Custermer form this Marketier?')"/></li>
    <?php }} ?>
                            
                     </ul>
                        </div>
                        
                        
                        
                        
                        
                        <?php  }?> 
                         </ul> 