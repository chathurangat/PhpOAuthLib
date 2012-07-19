<?php 
require_once('../config/config.php');
require_once('../classess/user-sql.php');
require_once('../classess/Mail.php');


$action = $_POST['action'];


switch ($action) {
    case 'act_addnewuser':
     	$addnewuser=  USER :: addnewuser();
		if($addnewuser!=''){
		 MAIL :: newuseraddmail();
            echo $addnewuser;
		}
        break;    
   
    case 'act_managemarketier':
     	echo USER :: managemarketier();
        break; 
		
	case 'act_deleteuser':
     	echo USER :: deleteuser();
        break;	
	
	case 'act_delhtlroomcard':
     	echo USER :: deletehotelroomcards();
        break;
		
	case 'act_delmarketiercustermer':
     	echo USER :: delmarketiercustermer();
        break;	
		
	case 'act_oldpasswordcheck':	
     	echo USER :: oldpasswordcheck();
        break;	
		
	case 'act_changepassword':
     	echo USER :: changepassword();
        break;	
		
	case 'act_emailavailabilitychecker':
     	echo USER :: usernameAndEmailAvailabilityChecker();
        break;			
				
	case 'act_checkmarketierscustermers':
     	echo USER :: checkmarketierscustermers();
        break;			
	
	case 'act_getahavailablecardamount':
		echo PACKAGES :: getahavailablecardamount();
        break;
		
	case 'act_activatingcards':		
		$activatedcards = PACKAGES :: activatingcards();		
		if(count($activatedcards)==$_POST['nofcards']){			
			MAIL :: notifyofactivatedcards($activatedcards);
			echo 1;
			}else{
				echo 2;				
				}
		
		
		
		
		
		
		break;

    case 'change_admin_user_password':
        echo USER::changeAdminUserPassword();
        break;


		
    default:
	   echo "You dont have direct access to this page";
       die();
       break;
}








?>