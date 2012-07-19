<?php 
require_once('../config/config.php');
require_once('../classess/reports-sql.php');


$action = $_POST['action'];


switch ($action) {
    case 'dd':
     	echo USER :: addnewuser();
        break;    
   
    
		
		
    default:
	   echo "You dont have direct access to this page";
       die();
       break;
}








?>