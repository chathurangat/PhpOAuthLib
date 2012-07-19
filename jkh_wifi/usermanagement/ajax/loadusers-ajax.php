<?php 
require_once('../../config/config.php');
require_once('../../controllers/session-controller.php');
require_once('../../classess/user-sql.php');

$allusers = USER :: getallusers();

?>		



					      <table>
                        <thead>
                        <tr>
                        <th>Name</th>
                        <th>Email address</th>
                        <th>User Group</th>                        
                       
                        <th>Action</th>
                                            
                        </tr>                        
                        </thead>
                        <?php 
						while($rowallusers=mysql_fetch_array($allusers)){
						?>
                        <tr id="user<?php echo $rowallusers['user_id'] ?>">
                        <td><?php echo $rowallusers['name']; ?></td>
                        <td><?php echo $rowallusers['email_address']; ?></td>
                        <td><?php
						 if($rowallusers['group_id']==1){echo "Billig";} 
						 if($rowallusers['group_id']==2){echo "Marketiers";} 
						 if($rowallusers['group_id']==3){echo USER :: getcustermerbyid($rowallusers['custermer_id']);} 
						 if($rowallusers['group_id']==4){echo "Admin";}					 
						 
						 ?></td>
                      
                       
                        
                        
                        
                        </td>                
                         <td>
                        <?php if($_SESSION['user_id']!=$rowallusers['user_id']){ ?>
                        <img src="../images/icons/cross.png" style="cursor:pointer;" onclick="deletefunc('user<?php echo $rowallusers['user_id']; ?>','act_deleteuser','<?php echo $rowallusers['user_id']; ?>','Are you sure want to delete this user?')"/>
                        <?php } ?>
                         </td>  
                        </tr>
                        <?php } ?>
                             
                        
                        </table>
          
		