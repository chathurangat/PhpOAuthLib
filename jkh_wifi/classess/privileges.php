<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 4/5/12
 * Time: 10:21 AM
 * To change this template use File | Settings | File Templates.
 */
class privileges
{


    static function getAllUsers(){

        $users = array();

        $sql="select * from system_users";

        $result = mysql_query($sql) or die(" Error ".mysql_error());

        while($data = mysql_fetch_array($result)){

            $user_data['user_id'] = $data['user_id'];
            $user_data['group_id'] = $data['group_id'];
            $user_data['name'] = $data['name'];
            $user_data['email_address'] = $data['email_address'];
            $user_data['password'] = $data['password'];
            $user_data['custermer_id'] = $data['custermer_id'];
            $user_data['status'] = $data['status'];

            $users[] = $user_data;

        }

        return $users;

    }



    static function getUsersForAssigningPrivileges(){

        $users = array();

        if($_SESSION['group_id']=='4'){
            //if LCS administrator
        $sql="select * from system_users";
        }
        else if($_SESSION['group_id']=='2'){
            //if Front Office Manager
            $sql="select * from system_users where group_id!=3 AND group_id!=4 AND group_id!=2 and custermer_id=".$_SESSION['custermer_id']."";
        }
        else if($_SESSION['group_id']=='3'){
            //if JKH super Admin
            $sql="select * from system_users where group_id!=4";
        }

        $result = mysql_query($sql) or die(" Error ".mysql_error());

        while($data = mysql_fetch_array($result)){

            $user_data['user_id'] = $data['user_id'];
            $user_data['group_id'] = $data['group_id'];
            $user_data['name'] = $data['name'];
            $user_data['email_address'] = $data['email_address'];
            $user_data['password'] = $data['password'];
            $user_data['custermer_id'] = $data['custermer_id'];
            $user_data['status'] = $data['status'];

            $users[] = $user_data;

        }

        return $users;

    }




    static function getAllPrivilegeCategories(){

        $privileges = array();

        $sql = "select * from system_privilege_categories";

        $result = mysql_query($sql) or die(" Error ".mysql_error());

        while($data = mysql_fetch_array($result)){

            $privilege['category_id'] = $data['category_id'];
            $privilege['category_name'] = $data['category_name'];

            $privileges[]=$privilege;
        }


        return $privileges;
    }



    static function getPrivilegesUnderGiverCategory($category_id){


        $privileges = array();

        $sql = "select * from system_privileges where privilege_category_id =".$category_id." AND status = 'active'";

        $result = mysql_query($sql) or die(" Error ".mysql_error());

        while($data = mysql_fetch_array($result)){

            $privilege['privilege_id'] = $data['privilege_id'];
            $privilege['privilege_category_id'] = $data['privilege_category_id'];
            $privilege['privilege_name'] = $data['privilege_name'];
            $privilege['privilege_description'] = $data['privilege_description'];

            $privileges[]=$privilege;
        }

        return $privileges;

    }




    static function changeUserPrivileges(){

        $sql = "select * from system_user_privileges where user_id=".$_POST['user_id']." AND priviledge_id=".$_POST['privilege_id']."";

        $result = mysql_query($sql) or die(" Error ".mysql_error());

        if(mysql_num_rows($result)>0){

            //privilege is already assigned for the user. therefore it should be removed
            $result2 = mysql_query("delete from system_user_privileges where user_id=".$_POST['user_id']." AND priviledge_id=".$_POST['privilege_id']."") or die(" Error ".mysql_error());
            return "success_removed";
        }
        else{
            //priviledge is not assigned for the user. therefore it should be inserted
            $sql_insert="insert into system_user_privileges(user_id,priviledge_id) values(".$_POST['user_id'].",".$_POST['privilege_id'].")";

            $result3 = mysql_query($sql_insert) or die(" Error ".mysql_error());
            return "success_assigned";
        }

    }




    static  function isUserHavingPrivilege($user_id,$privilege_id){


//        $sql = "select * from system_user_privileges where user_id=".$user_id." AND priviledge_id=".$privilege_id."";
        $sql = "select * from system_user_privileges sup, system_privileges sp where sup.user_id=".$user_id." AND sup.priviledge_id=".$privilege_id." AND sup.priviledge_id=sp.privilege_id AND sp.status='active'";

        $result = mysql_query($sql) or die(" Error ".mysql_error());

        if(mysql_num_rows($result)>0){

            return true;
        }
        else{
            return false;
        }


    }




//    static function getGivenUserDetails($userId){
//
//        $result = mysql_query("select * from system_users where user_id=".$userId);
//
//        return mysql_fetch_array($result);
//    }


}//privileges
