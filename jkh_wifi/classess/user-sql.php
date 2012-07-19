<?php

class USER{


    function deletehotelroomcards(){

        $sql="DELETE FROM radcheck WHERE username='".mysql_real_escape_string($_POST['id'])."' ";
        $res = mysql_query($sql)or die();


        $sql="DELETE FROM rm_users WHERE username='".mysql_real_escape_string($_POST['id'])."' ";
        $res = mysql_query($sql)or die();
        return $res;

    }


    function getHotels(){

        $sql = "SELECT * FROM rm_usergroups ORDER BY groupid ASC";
        $res = mysql_query($sql)or die(mysql_error());
        return $res;


    }


    function getHotelsBasedOnLoggedUserGroup(){

        if($_SESSION['group_id']==3 || $_SESSION['group_id']==4){
            $sql = "SELECT * FROM rm_usergroups ORDER BY groupid ASC";
        }
        else{
            $sql = "SELECT * FROM rm_usergroups where groupid=".$_SESSION['custermer_id']."";
        }
        $res = mysql_query($sql)or die(mysql_error());
        return $res;


    }

    function getSystemusertypes(){

        $sql = "SELECT * FROM system_users_types ORDER BY USER_TYPE_ID ASC";
        $res = mysql_query($sql)or die(mysql_error());
        return $res;

    }



    function getSystemUserTypesForUserGroups(){

        if($_SESSION['group_id']==4){
            //LCS ADMIN
            $sql = "SELECT * FROM system_users_types ORDER BY USER_TYPE_ID ASC";

        }
        else if($_SESSION['group_id']==3){
            //JKH Super Admin
            $sql = "SELECT * FROM system_users_types where USER_TYPE_ID!=4 ORDER BY USER_TYPE_ID ASC";
        }
        else if($_SESSION['group_id']==2){
            //Front Office Managers
            $sql = "SELECT * FROM system_users_types where USER_TYPE_ID!=2 AND USER_TYPE_ID!=3 AND USER_TYPE_ID!=4 ORDER BY USER_TYPE_ID ASC";
        }
        $res = mysql_query($sql)or die(mysql_error());
        return $res;

    }


    function getmarketiersemail($marketier_id){
        $sql = "SELECT * FROM system_users WHERE user_id='".(int)$marketier_id."'";
        $res = mysql_query($sql)or die(mysql_error());
        $row = mysql_fetch_array($res);
        return $row['email_address'];


    }


    function gethotelsmarketier($custermer){

        $sql = "SELECT * FROM  system_marketiers WHERE hotel_id='".(int)$custermer."'";
        $res = mysql_query($sql)or die(mysql_error());
        $row = mysql_fetch_array($res);
        return $row['marketier_id'];
    }



    function checkmarketierscustermers(){
        $sql = "SELECT * FROM system_marketiers WHERE marketier_id='".(int)$_POST['marketiers']."' AND hotel_id='".(int)$_POST['marketier_custermer']."'";
        $res = mysql_query($sql)or die(mysql_error());
        $cnt = mysql_num_rows($res);
        return $cnt;


    }



    function usernameAndEmailAvailabilityChecker(){


        $sql = "SELECT * FROM system_users WHERE email_address='".mysql_real_escape_string($_POST['user_email'])."'";
        $res = mysql_query($sql)or die(mysql_error());

        if(mysql_num_rows($res)==0){
            //check whether the username is already taken

            $sql2 = "select * from system_users where username = '".$_POST['username']."'";

            $result2 = mysql_query($sql2);

            if(mysql_num_rows($result2)==0){

                return "success####Both username and email are available";

            }
            else{

                return "error####Username is Already Taken";
            }

        }
        else{

          return "error####Email Adderss is Already Taken";
        }

    }





    function getCustermersofMarketiers(){

        $sql ="SELECT custdet.ID,custdet.Name FROM custdet
LEFT JOIN system_marketiers ON 	custdet.ID=system_marketiers.hotel_id
 				WHERE system_marketiers.marketier_id='".(int)$_SESSION['user_id']."'";
        $res = mysql_query($sql)or die();
        return $res;

    }







    function changepassword(){
        $sql = "UPDATE system_users SET password= '".md5($_POST['c_new_pw'])."' WHERE user_id='".(int)$_POST['id']."'";
        $res = mysql_query($sql);
        if(mysql_affected_rows()){
            return 1;
        }


    }


    function oldpasswordcheck(){
        $sql  = "SELECT * FROM system_users WHERE password='".mysql_real_escape_string(md5($_POST['old_pw']))."' AND user_id='".(int)$_POST['id']."'";
        $res = mysql_query($sql)or die(mysql_error());
        $cnt = mysql_num_rows($res);
        return $cnt;
    }




    function delmarketiercustermer(){
        $sql="DELETE FROM system_marketiers WHERE data_id='".(int)$_POST['id']."' ";
        $res = mysql_query($sql)or die();
        return $res;
    }


    function deleteuser(){
        $sql="DELETE FROM system_users WHERE user_id='".(int)$_POST['id']."' ";
        $res = mysql_query($sql)or die();
        return $res;
    }


    function managemarketier(){
        $sql = "INSERT INTO system_marketiers(marketier_id, hotel_id)
							VALUES('".(int)$_POST['marketiers']."',
							       '".(int)$_POST['marketier_custermer']."')";
        $res = mysql_query($sql);
        return $res;
    }

    function getMarketierscustermers($id){
        $sql = "SELECT * FROM system_marketiers WHERE marketier_id='".(int)$id."'";
        $res = mysql_query($sql)or die();
        return $res;
    }


    function getallmarketiers(){
        $sql = "SELECT * FROM system_users WHERE group_id='2' ORDER BY user_id DESC";
        $res = mysql_query($sql)or die();
        return $res;
    }



    function getCustermers(){
        $sql = "SELECT * FROM rm_usergroups ORDER BY groupid DESC";
        $res = mysql_query($sql)or die();
        return $res;
    }

    function getcustermerbyid($id){
        $sql = "SELECT * FROM rm_usergroups WHERE groupid='".(int)$id."'";
        $res = mysql_query($sql)or die();
        $row = mysql_fetch_array($res);
        return $row['groupname'];
    }


    function getallusers(){

        //$sql = "SELECT * FROM system_users,rm_usergroups WHERE rm_usergroups.groupid=system_users.custermer_id ORDER BY user_id DESC";


        $sql ="SELECT * FROM system_users
LEFT JOIN rm_usergroups ON system_users.custermer_id=rm_usergroups.groupid 
LEFT JOIN system_users_types ON system_users.group_id =system_users_types.USER_TYPE_ID 

";
        $res = mysql_query($sql);
        return $res;
    }


    function addnewuser(){

        $sql  = "INSERT system_users(group_id, name,username, email_address, password, custermer_id)
								VALUES('".mysql_real_escape_string($_POST['user_group'])."', 
								  	   '".mysql_real_escape_string($_POST['user_name'])."',
								  	   '".mysql_real_escape_string($_POST['username'])."',
								       '".mysql_real_escape_string($_POST['user_email'])."',
								       '".mysql_real_escape_string(md5($_POST['user_password']))."',
								       '".mysql_real_escape_string($_POST['user_custermer'])."') ";
        $res = mysql_query($sql);

        //assign default privileges

        $user_id = mysql_insert_id();

        if($_POST['user_group']==1){

         //if reception

         $sql_privileges = "insert into system_user_privileges(user_id,priviledge_id) values(".$user_id.",6),(".$user_id.",7),(".$user_id.",8),(".$user_id.",9),(".$user_id.",10),(".$user_id.",11),(".$user_id.",13),(".$user_id.",14),(".$user_id.",15),(".$user_id.",16),(".$user_id.",19);";

        mysql_query($sql_privileges);

        }
        else if($_POST['user_group']==5 || $_POST['user_group']==6 || $_POST['user_group']==7){

            $sql_privileges = "insert into system_user_privileges(user_id,priviledge_id) values(".$user_id.",10),(".$user_id.",11),(".$user_id.",13),(".$user_id.",15),(".$user_id.",16),(".$user_id.",19);";

            mysql_query($sql_privileges);
        }

        return base64_encode($user_id);


    }







    function getModeratableAdminUsers(){

        $sql="";
        if($_SESSION['group_id']==4){
            //if LCS Super Admin
            $sql ="SELECT * FROM system_users
LEFT JOIN rm_usergroups ON system_users.custermer_id=rm_usergroups.groupid
LEFT JOIN system_users_types ON system_users.group_id =system_users_types.USER_TYPE_ID";


        }
        else if($_SESSION['group_id']==3){
            //JKH Super Admin

            $sql ="SELECT * FROM system_users
LEFT JOIN rm_usergroups ON system_users.custermer_id=rm_usergroups.groupid
LEFT JOIN system_users_types ON system_users.group_id =system_users_types.USER_TYPE_ID where system_users.group_id!=4";
        }

        else if($_SESSION['group_id']==2){

            $sql ="SELECT * FROM system_users
LEFT JOIN rm_usergroups ON system_users.custermer_id=rm_usergroups.groupid
LEFT JOIN system_users_types ON system_users.group_id =system_users_types.USER_TYPE_ID where system_users.group_id!=4 AND system_users.group_id!=3 AND system_users.group_id!=2 and system_users.custermer_id=".$_SESSION['custermer_id']."";

        }


        $res = mysql_query($sql);
        return $res;

    }







    function UPDATEUSERS(){

        $sql  = "UPDATE system_users SET group_id='".mysql_real_escape_string($_POST['user_group'])."',
								  name='".mysql_real_escape_string($_POST['user_name'])."',
								  email_address='".mysql_real_escape_string($_POST['user_email'])."',
								  password='".mysql_real_escape_string($_POST['user_password'])."',
								  custermer_id='".mysql_real_escape_string($_POST['user_custermer'])."' ";
        $res = mysql_query($sql);
        return $res;



    }




    static function getGivenUserDetails($userID){


        $sql = "select * from system_users where user_id =".$userID."";


        $result =  mysql_query($sql);

        $user_data = mysql_fetch_array($result);

        $sql2 = "select * from rm_usergroups where groupid =".$user_data['custermer_id']."";


        $hotel_data = mysql_fetch_array(mysql_query($sql2));

        $user_type = mysql_fetch_array(mysql_query("select * from system_users_types where USER_TYPE_ID = ".$user_data['group_id'].""));


        $received_data = array();

        $received_data['name'] = $user_data['name'];
        $received_data['hotel_name'] = $hotel_data['groupname'];
        $received_data['user_type'] = $user_type['USER_TYPE'];


        return $received_data;

        //return $user_data;

    }



    static function isUserAssignedForHotel($userID){

        $sql = "select * from system_users where user_id =".$userID." AND 	custermer_id !=0";

        $result = mysql_query($sql);

        if(mysql_num_rows($result)>0){

            return TRUE;
        }
        else{
            return FALSE;

        }

    }




    static function changeAdminUserPassword(){


        $sql = "update system_users set password ='".md5($_POST['password'])."' where user_id =".$_POST['user_id']."";

        $result = mysql_query($sql);


        if($result==1){

            return "success";
        }
        else{

            return "error";
        }
    }






    static function getHotelCodeOfTheLoggedHotelUser(){

        $sql = "select * from rm_usergroups where groupid = ".$_SESSION['custermer_id']."";

        $result  = mysql_query($sql);

        $data  = mysql_fetch_array($result);

        return $data;
    }




}

?>