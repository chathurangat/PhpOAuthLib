<?php 
require_once('../config/config.php');
require_once('../classess/login-sql.php');


$action = $_POST['action'];


switch ($action) {
    case 'act_adminlogin':  	
		echo LOGIN :: adminlogin();
        break;   
      
   
		
    default:
	   echo "You dont have direct access to this page";
       die();
       break;
}







?>