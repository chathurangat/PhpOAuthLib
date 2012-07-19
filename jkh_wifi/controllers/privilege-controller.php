<?php
include("../config/config.php");
include("../classess/privileges.php");
require_once  '../classess/user-sql.php';

$action = $_POST['action'];


switch($action){

    case 'load_user_privileges':

        echo displayUserPrivileges();
        break;

    case 'change_user_privileges':
        echo changeUserPrivileges();
        break;

    default:
        redirectHome();
        break;
}




function displayUserPrivileges(){

    //return "user privileges from controller ".$_POST['user_id'];

    $privileges = privileges ::getAllPrivilegeCategories();

    // $resultQ = mysql_query("SELECT * FROM system_users su,system_users_types sut  WHERE su.user_id=".$_POST['user_id']." AND su.group_id=sut.USER_TYPE_ID");

    //$user_level = mysql_fetch_array($resultQ);



    $table="";

    $isHotelUser =  USER::isUserAssignedForHotel($_POST['user_id']);

    if($isHotelUser){

        //getting  user details
        $userData = USER::getGivenUserDetails($_POST['user_id']);

        $table = $table."<table><tr><td><h3>Name :</h3></td><td><h3>".$userData['name']."</h3></td></tr>";
        $table = $table."<tr><td><h3>Hotel :</h3></td><td><h3>".$userData['hotel_name']."</h3></td></tr>";
        $table = $table."<tr><td><h3>User Level :</h3></td><td><h3>".$userData['user_type']."</h3></td></tr></table>";
    }


    foreach($privileges as $privilege){


        //get sub privileges under each master privilege
        $sub_privileges = privileges :: getPrivilegesUnderGiverCategory($privilege['category_id']);


        if(($_SESSION['group_id']!=3 && $_SESSION['group_id']!=4) && ($privilege['category_id']==1 || $privilege['category_id']==6)){

            continue;

        }
        // $table="<label><h3>User Level : ".$user_level['USER_TYPE']."</h3></label>";

        $table = $table."<table>
    <tr><td><b>".$privilege['category_name']."</b></td></tr>
    <br/>
    <tr><table>";

        foreach($sub_privileges as $sub_privilege){

            $isAuthorized = privileges :: isUserHavingPrivilege($_POST['user_id'],$sub_privilege['privilege_id']);

            $checked="";

            if($isAuthorized){
                $checked="checked='true'";
            }

            $table = $table."<tr><td><input type='checkbox' ".$checked." name='privilege' onchange='changePrivileges(".$sub_privilege['privilege_id'].");' />".$sub_privilege['privilege_name']."</td></tr>";
        }
        $table = $table."</table></tr></table>";

    }

    return $table;

}//displayUserPrivileges







/*


function displayUserPrivileges(){

    //return "user privileges from controller ".$_POST['user_id'];

    $privileges = privileges ::getAllPrivilegeCategories();

    // $resultQ = mysql_query("SELECT * FROM system_users su,system_users_types sut  WHERE su.user_id=".$_POST['user_id']." AND su.group_id=sut.USER_TYPE_ID");

    //$user_level = mysql_fetch_array($resultQ);

    $table="";

    foreach($privileges as $privilege){

        //get sub privileges under each master privilege
        $sub_privileges = privileges :: getPrivilegesUnderGiverCategory($privilege['category_id']);

        // $table="<label><h3>User Level : ".$user_level['USER_TYPE']."</h3></label>";

        $table = $table."<table>
    <tr><td><b>".$privilege['category_name']."</b></td></tr>
    <br/>
    <tr><table>";

        foreach($sub_privileges as $sub_privilege){

            $isAuthorized = privileges :: isUserHavingPrivilege($_POST['user_id'],$sub_privilege['privilege_id']);

            $checked="";

            if($isAuthorized){
                $checked="checked='true'";
            }

            $table = $table."<tr><td><input type='checkbox' ".$checked." name='privilege' onchange='changePrivileges(".$sub_privilege['privilege_id'].");' />".$sub_privilege['privilege_name']."</td></tr>";
        }
        $table = $table."</table></tr></table>";

    }

    return $table;

}//displayUserPrivileges
*/



function redirectHome(){

    header("Location: ../");
}



function changeUserPrivileges(){

    return privileges :: changeUserPrivileges();
}