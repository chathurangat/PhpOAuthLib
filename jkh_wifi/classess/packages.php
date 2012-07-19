<?php

class PACKAGES{


    function searchbyusername(){

        $sql = "SELECT * FROM radcheck
				LEFT JOIN rm_users ON rm_users.username=radcheck.username
				LEFT JOIN rm_services ON rm_services.srvid=rm_users.srvid 
				WHERE ";

        $sql .=  "  rm_users.username like '%".mysql_real_escape_string($_POST['search_txt'])."%' ";

        if($_SESSION['custermer_id']==0){
        }else{
            $sql .=  " AND rm_users.groupid='".(int)$_SESSION['custermer_id']."' ";
        }


        $sql .=  " group by radcheck.username ";


        $res = mysql_query($sql)or die(mysql_error());
        return $res;

    }



    function getroominfo(){


        $sql = "SELECT * FROM rm_users WHERE username='".mysql_real_escape_string($_POST['user_name'])."' AND 	groupid='".(int)$_POST['htl_id']."'";
        $res = mysql_query($sql)or die(mysql_error());
        $row = mysql_fetch_array($res);
        return $row['expiration'];
    }


    function getHotelprefix(){


        $sql = "SELECT descr FROM rm_usergroups WHERE groupid='".mysql_real_escape_string($_POST['htl_id'])."' ";
        $res = mysql_query($sql)or die(mysql_error());
        $row = mysql_fetch_array($res);
        return $row['descr'];
    }




    function getFiltertedcards(){

        $sql = "SELECT rm_users.username,rm_users.expiration,rm_cards.id FROM  rm_users
			LEFT JOIN rm_cards ON 	rm_users.username=rm_cards.cardnum		
					 WHERE   rm_users.groupid like '%".mysql_real_escape_string($_POST['custermer'])."%' AND
							 rm_cards.series like '%".mysql_real_escape_string($_POST['package'])."%' AND
							 rm_users.enableuser like '%".mysql_real_escape_string($_POST['enable_disable'])."%' AND
		 					 rm_users.srvid like '%".mysql_real_escape_string($_POST['service'])."%' 	 ";
        $res = mysql_query($sql)or die(mysql_error());
        return $res;
    }


    function getnases(){

        $sql = "SELECT * FROM nas ORDER BY id DESC";
        $res = mysql_query($sql)or die(mysql_error());
        return $res;

    }


    function getServicesofthenas(){

        $sql2 = "SELECT * FROM rm_cards
				LEFT JOIN rm_users ON rm_cards.cardnum=rm_users.username
				WHERE rm_users.groupid=0 AND rm_cards.series='".mysql_real_escape_string($_POST['package'])."'  LIMIT ".mysql_real_escape_string($_POST['nofcards'])." ";



        $sql = "SELECT * FROM rm_allowednases
		LEFT JOIN rm_services ON rm_allowednases.srvid=rm_services.srvid
		
		 WHERE nasid='".(int)$_POST['id']."' ";
        $res = mysql_query($sql)or die(mysql_error());
        return $res;



    }



    function getServices(){

        $sql = "SELECT * FROM rm_services ORDER BY srvid DESC";
        $res = mysql_query($sql)or die(mysql_error());
        return $res;


    }




    function addnewcardsviaexcel($card_no,$username,$pw){

        $sql = "INSERT INTO radcheck(id,CustID,UserName,Attribute,op,Value)
                                        VALUES('".mysql_real_escape_string($card_no)."',
                                            	'0',
                                               '".mysql_real_escape_string($username)."',
                                               'User-Password',
                                               '==',
                                               '".mysql_real_escape_string($pw)."'
											   			)";
        $res = mysql_query($sql)or die(mysql_error());


        $sql2 = "INSERT INTO usergroup(UserName,GroupName,priority)
                                        VALUES('".mysql_real_escape_string($username)."',
                                               '".mysql_real_escape_string($_POST['card_package'])."',
                                               '1' )";
        $res2 = mysql_query($sql2)or die();

        return $res2;






    }

    function deleteCurreentnumbers($htl_prefix){


        $sql = "DELETE FROM radcheck WHERE username='".mysql_real_escape_string($htl_prefix.$_POST['user_name'])."'";
        $res = mysql_query($sql)or die(mysql_error());

        $sql = "DELETE FROM rm_users WHERE username='".mysql_real_escape_string($htl_prefix.$_POST['user_name'])."' AND groupid='".(int)$_POST['htl_id']."'";
        $res = mysql_query($sql)or die(mysql_error());

    }



    function getHotelbyid($id){

        $sql  ="SELECT groupname FROM rm_usergroups WHERE groupid='".(int)$id."'";
        $res = mysql_query($sql)or die(mysql_error());
        $row = mysql_fetch_array($res);
        return $row['groupname'];

    }



    function getHotelItmanagers($id){

        $sql  ="SELECT * FROM system_users WHERE custermer_id='".(int)$id."' ";
        $res = mysql_query($sql)or die(mysql_error());
        return $res;

    }


    function getJKHItmanagers($id){

        $sql  ="SELECT * FROM system_users WHERE group_id='3' ";
        $res = mysql_query($sql)or die(mysql_error());
        return $res;

    }



    function act_addcardsbyhtlroom($pw,$htl_prefix){

        $uname  = $htl_prefix.$_POST['user_name'];
        //	echo $uname;die();

        $sql = "INSERT INTO radcheck(UserName,Attribute,op,Value)
                                        VALUES('".mysql_real_escape_string($uname)."',
                                               'Simultaneous-Use',
                                               ':=',
                                               '".mysql_real_escape_string($_POST['simultanious_users'])."'
											   			)";
        $res = mysql_query($sql)or die(mysql_error());



        $sql = "INSERT INTO radcheck(UserName,Attribute,op,Value)
                                        VALUES('".mysql_real_escape_string($uname)."',
                                               'Cleartext-Password',
                                               ':=',
                                               '".mysql_real_escape_string($pw)."'
											   			)";
        $res = mysql_query($sql)or die(mysql_error());




        $sql2 = "INSERT INTO rm_users(username,password,groupid,enableuser,expiration,srvid)
                                        VALUES('".mysql_real_escape_string($uname)."',
                                               '".mysql_real_escape_string(md5($pw))."',
											   '".mysql_real_escape_string($_POST['htl_id'])."',
                                               '1',
											   '".mysql_real_escape_string($_POST['expire_date'])."',
											   '".mysql_real_escape_string($_POST['service'])."'   )";
        $res2 = mysql_query($sql2)or die();


        $sql3 = "INSERT INTO system_user_details(username,contact_name,nic_passport_no,service_stop_date,created_by) values('".mysql_real_escape_string($uname)."','".mysql_real_escape_string($_POST['contact_name'])."','".mysql_real_escape_string($_POST['identity_no'])."','".mysql_real_escape_string($_POST['expire_date'])."',".$_SESSION["user_id"].")";
        $res3 = mysql_query($sql3)or die();

        $current_insert_id = mysql_insert_id();


        $sql4 = "update system_user_details set service_stop_date=now() where id !=".$current_insert_id." AND service_stop_date > now() AND username = '".$uname."'";

        $res4 = mysql_query($sql4)or die();


        $sql5 ="select * from radreply where username = '".$uname."'";
        $result5 = mysql_query($sql5);


        if(mysql_num_rows($result5)==0){

            mysql_query("insert into radreply(username,attribute,op,value) values('".$uname."','Idle-Timeout',':=','180')");
        }



        return $uname;

    }



    function act_editcardsbyhtlroom(){




        $sql = "UPDATE radcheck SET username='".mysql_real_escape_string($_POST['user_name'])."',
		 							  Value='".mysql_real_escape_string($_POST['simultanious_users'])."'
                                      WHERE username='".mysql_real_escape_string($_POST['id'])."' AND attribute='Simultaneous-Use' ";
        $res = mysql_query($sql)or die(mysql_error());


        $sql2 = "UPDATE rm_users SET username='".mysql_real_escape_string($_POST['user_name'])."',
									 expiration='".mysql_real_escape_string($_POST['expire_date'])."',
								     srvid='".mysql_real_escape_string($_POST['service'])."'
									  WHERE  username='".mysql_real_escape_string($_POST['id'])."' ";
        $res2 = mysql_query($sql2)or die();


        //update the last entry on system_user_details based on username attribute

        $result = mysql_query("select max(id) as max_id from system_user_details where username='".mysql_real_escape_string($_POST['id'])."'")or die();

        $data = mysql_fetch_array($result);

        $max_id=$data['max_id'];

        $sql3 = "UPDATE system_user_details SET service_stop_date='".mysql_real_escape_string($_POST['expire_date'])."'
									  WHERE username ='".mysql_real_escape_string($_POST['id'])."' AND id =".$max_id."";

        // WHERE username ='".mysql_real_escape_string($_POST['id'])."' AND id = (select max(id) from system_user_details where username='".mysql_real_escape_string($_POST['id'])."')

        $res3 = mysql_query($sql3)or die();

        return $res3;




    }





    function activatingcards(){

        $activatedcards = array();

        $sql = "SELECT * FROM rm_cards
				LEFT JOIN rm_users ON rm_cards.cardnum=rm_users.username
				WHERE rm_users.groupid=0 AND rm_cards.series='".mysql_real_escape_string($_POST['package'])."'  LIMIT ".mysql_real_escape_string($_POST['nofcards'])." ";

        $res = mysql_query($sql)or die(mysql_error());

        while($row = mysql_fetch_array($res)){
            //$updatesql = "UPDATE rm_users LEFT JOIN rm_cards ON radcheck.UserName=usergroup.UserName
            //SET CustID='".$_POST['custermer']."'
            //WHERE radcheck.id='".$row['id']."' ";

            $updatesql = "UPDATE rm_users SET groupid='".mysql_real_escape_string($_POST['custermer'])."',srvid='".mysql_real_escape_string($_POST['service'])."',enableuser=1	WHERE username='".mysql_real_escape_string($row['cardnum'])."' ";


            $activatedcards[] = $row['id'];

            $res2 = mysql_query($updatesql)or die(mysql_error());
        }


        return $activatedcards;
    }




    function getahavailablecardamount(){

        $sql = "SELECT * FROM rm_cards
				LEFT JOIN rm_users ON rm_cards.cardnum=rm_users.username
				WHERE rm_users.groupid=0 AND rm_cards.series='".mysql_real_escape_string($_POST['package'])."' ";
        $res = mysql_query($sql)or die(mysql_error());
        return mysql_num_rows($res);
    }


    function getCardpackages(){
        $sql = "SELECT DISTINCT series FROM rm_cards ORDER BY id DESC";
        $res = mysql_query($sql)or die(mysql_error());
        return $res;

    }


    function getpackagevaluebyname($package){

        $sql = "SELECT price FROM package_prices WHERE package_name='".mysql_real_escape_string($package)."' LIMIT 0,1";
        $res = mysql_query($sql)or die();
        $row = mysql_fetch_array($res);
        return $row['price'];
    }



    function generatecards($username,$password){
        $sql = "INSERT INTO radcheck(CustID,UserName,Attribute,op,Value)
										VALUES('".mysql_real_escape_string($_POST['custermer'])."',
										       '".mysql_real_escape_string($username)."',
											   'User-Password',
											   '==',
											   '".mysql_real_escape_string($password)."'	)";
        $res = mysql_query($sql)or die();
        return mysql_insert_id();

        $sql2 = "INSERT INTO usergroup(UserName,GroupName,priority)
										VALUES('".mysql_real_escape_string($username)."',
											   '".mysql_real_escape_string($_POST['package'])."',
											   '1' )";
        $res2 = mysql_query($sql2)or die();


        //return mysql_affected_rows();

    }


    function getSimultanoususers($username){

        $sql =  "SELECT value FROM radcheck WHERE attribute='Simultaneous-Use' AND username='".mysql_real_escape_string($username)."'";
        $res = mysql_query($sql)or die();
        $row = mysql_fetch_array($res);
        return $row['value'];
    }


    function getPassword($username){

        $sql =  "SELECT value FROM radcheck WHERE attribute='Cleartext-Password' AND username='".mysql_real_escape_string($username)."'";
        $res = mysql_query($sql)or die();
        $row = mysql_fetch_array($res);
        return $row['value'];
    }
    

    function getAllCards($cust_id){

        if($_SESSION["group_id"]==3 || $_SESSION["group_id"]==4){

            $sql = "SELECT * FROM radcheck
        				LEFT JOIN rm_users ON rm_users.username=radcheck.username
        				LEFT JOIN rm_services ON rm_services.srvid=rm_users.srvid
        				 WHERE 	rm_users.groupid='".(int)$cust_id."' group by radcheck.username ";

        }
        else{
            $sql = "SELECT * FROM radcheck
				LEFT JOIN rm_users ON rm_users.username=radcheck.username
				LEFT JOIN rm_services ON rm_services.srvid=rm_users.srvid
				 WHERE 	rm_users.groupid='".(int)$cust_id."' AND rm_users.expiration > '".date("Y-m-d")."' group by radcheck.username ";
        }
        $res = mysql_query($sql)or die(mysql_error());
        return $res;
        //return mysql_num_rows($res);

    }

    function getroomcardbyusername($id){

        $sql = "SELECT * FROM radcheck
				LEFT JOIN rm_users ON rm_users.username=radcheck.username
				LEFT JOIN rm_services ON rm_services.srvid=rm_users.srvid 
				 WHERE 	rm_users.username='".mysql_real_escape_string($id)."'  ";
        $res = mysql_query($sql)or die(mysql_error());
        $row = mysql_fetch_array($res);
        return $row;


    }



/*
    //function to get live users
    function getliveusers($custermer_id){


        $liveusers = array();

        //WHERE   radcheck.CustID ='".mysql_real_escape_string($custermer_id)."' and

        $mQueryx = "SELECT radcheck.UserName , radcheck.id , radcheck.Value , radacct.AcctStartTime , radacct.acctinputoctets , radacct.acctoutputoctets , radacct.framedipaddress , radacct.acctsessiontime FROM  radcheck , radacct,rm_users
WHERE  rm_users.groupid ='".mysql_real_escape_string($custermer_id)."' and
 rm_users.username =radacct.UserName and
 radcheck.UserName=radacct.UserName and radacct.AcctStopTime IS NULL group by radcheck.UserName ";

        $mResultx = mysql_query($mQueryx)or die(mysql_error());




        while ($mRowx = mysql_fetch_array($mResultx)) {





            $wifiuser['id'] = $mRowx['id'];

            $wifiuser['name'] = $mRowx['UserName'];
            $wifiuser['value'] = $mRowx['Value'];
            $wifiuser['price'] = $mRowp["price"];
            $wifiuser['starttime'] = $mRowx['AcctStartTime'];
            $wifiuser['uploadedbytes'] = $mRowx['acctinputoctets'];
            $wifiuser['downloadedbytes'] = $mRowx['acctoutputoctets'];
            $wifiuser['ipaddress'] = $mRowx['framedipaddress'];
            $wifiuser['sessiontime'] = $mRowx['acctsessiontime'];

            $liveusers[] = $wifiuser;

        }






        return $liveusers;

    }
//End Of live users function
*/


//function to get live users
    function getliveusers($custermer_id){


        $liveusers = array();

        //WHERE   radcheck.CustID ='".mysql_real_escape_string($custermer_id)."' and

        $mQueryx = "SELECT radcheck.UserName , radcheck.id , radcheck.Value , radacct.AcctStartTime , radacct.acctinputoctets , radacct.acctoutputoctets , radacct.framedipaddress , radacct.acctsessiontime ,system_user_details.contact_name , (SELECT `FragOutputOctets` FROM user_accounting_details WHERE `AcctUniqueId`=radacct.acctuniqueid ORDER BY `FragStartTime` DESC LIMIT 1,1) AS downd, (FragStartTime -  FragStopTime) AS duration  FROM  radcheck , radacct,rm_users, system_user_details ,user_accounting_details

WHERE

rm_users.groupid ='".mysql_real_escape_string($custermer_id)."' and

 rm_users.username =radacct.UserName and

 radacct.UserName=system_user_details.username and

 user_accounting_details.AcctUniqueId = radacct.acctuniqueid and

 radcheck.UserName=radacct.UserName and radacct.AcctStopTime IS NULL group by radcheck.UserName ";

        $mResultx = mysql_query($mQueryx)or die(mysql_error());




        while ($mRowx = mysql_fetch_array($mResultx)) {





            $wifiuser['id'] = $mRowx['id'];

            $wifiuser['name'] = $mRowx['UserName'];
            $wifiuser['value'] = $mRowx['Value'];
            $wifiuser['price'] = $mRowp["price"];
            $wifiuser['starttime'] = $mRowx['AcctStartTime'];
            $wifiuser['uploadedbytes'] = $mRowx['acctinputoctets'];
            $wifiuser['downloadedbytes'] = $mRowx['acctoutputoctets'];
            $wifiuser['ipaddress'] = $mRowx['framedipaddress'];
            $wifiuser['sessiontime'] = $mRowx['acctsessiontime'];
            $wifiuser['contact'] = $mRowx['contact_name'];
            $wifiuser['downd'] = $mRowx['downd'];
            $wifiuser['duration'] = $mRowx['duration'];

            $liveusers[] = $wifiuser;

        }






        return $liveusers;

    }
//End Of live users function





    function updatePasswordOfWiFiUsers(){


        $sql = "UPDATE rm_users set password='".mysql_real_escape_string(md5($_POST['user_new_password']))."' where username='".mysql_real_escape_string($_POST['username'])."'";

        $res = mysql_query($sql)or die(mysql_error());


        $sql2 = "UPDATE radcheck set value='".mysql_real_escape_string($_POST['user_new_password'])."' where username='".mysql_real_escape_string($_POST['username'])."' AND attribute='Cleartext-Password'";
        $res2 = mysql_query($sql2)or die(mysql_error());

        return $res;

    }//updatePasswordOfWiFiUsers




    function updatePasswordOfWiFiUsersInHotel(){

        $select_pw="select * from rm_users where username='".mysql_real_escape_string($_POST['username'])."' AND password='".md5($_POST['user_old_password'])."'";

        $result = mysql_query($select_pw);

        if(mysql_num_rows($result)>0){

            $sql = "UPDATE rm_users set password='".mysql_real_escape_string(md5($_POST['user_new_password']))."' where username='".mysql_real_escape_string($_POST['username'])."' AND password='".md5($_POST['user_old_password'])."'";

            $res = mysql_query($sql)or die(mysql_error());


            $sql2 = "UPDATE radcheck set value='".mysql_real_escape_string($_POST['user_new_password'])."' where username='".mysql_real_escape_string($_POST['username'])."' AND attribute='Cleartext-Password' AND value='".$_POST['user_old_password']."'";
            $res2 = mysql_query($sql2)or die(mysql_error());

            ?>
        <script type="text/javascript">
            alert("User password was changed");
            window.location ="../usermanagement/change-wifi-user-password.php?username=<?php echo base64_encode($_POST['username']); ?>&link-orig=<?php echo base64_encode($_POST['link-orig']); ?>&link-logout=<?php echo base64_encode($_POST['link-logout']); ?>&link-status=<?php echo base64_encode($_POST['link-status']); ?>";
        </script>
        <?php

            //header("Location : ../usermanagement/change-wifi-user-password.php");
            //return "pw_changed";
        }
        else{

            ?>
        <script type="text/javascript">
            alert("Old password is incorrect");
            window.location ="../usermanagement/change-wifi-user-password.php?username=<?php echo base64_encode($_POST['username']); ?>&link-orig=<?php echo base64_encode($_POST['link-orig']); ?>&link-logout=<?php echo base64_encode($_POST['link-logout']); ?>&link-status=<?php echo base64_encode($_POST['link-status']); ?>";
        </script>
        <?php

            //return "no_user_found";
            //header("Location : ../usermanagement/change-wifi-user-password.php");

        }

    }//updatePasswordOfWiFiUsers



    function getCardUsageHistoryForGivenRoom($username){


        $data = array();

        $sql = "select * from radacct where username='".$username."'";

        $result = mysql_query($sql)or die(mysql_error());


        while ($row = mysql_fetch_array($result)) {

            $card_history['username']=$row['username'];
            $card_history['start_time']=$row['acctstarttime'];
            $card_history['stop_time']=$row['acctstoptime'];
            $card_history['session_time']=$row['acctsessiontime'];
            $card_history['terminate_reason']=$row['acctterminatecause'];
            $card_history['ip_address']=$row['framedipaddress'];
            $card_history['upload_bytes']=$row['acctinputoctets'];
            $card_history['download_bytes']=$row['acctoutputoctets'];

            $data[] = $card_history;

        }


        return $data;

    }




    function getCardUsageHistoryForGivenRoomForGivenDateRange($username,$start_date,$end_date){


        $data = array();

        $start_date = $start_date.' 00:00:00';
        $end_date = $end_date.' 23:59:59';

        $sql = "SELECT * FROM radacct WHERE username = '".$username."' AND acctstarttime >= '".$start_date."'  AND acctstoptime <= '".$end_date."'";


        $result = mysql_query($sql)or die(mysql_error());


        while ($row = mysql_fetch_array($result)) {

            $card_history['username']=$row['username'];
            $card_history['start_time']=$row['acctstarttime'];
            $card_history['stop_time']=$row['acctstoptime'];
            $card_history['session_time']=$row['acctsessiontime'];
            $card_history['terminate_reason']=$row['acctterminatecause'];
            $card_history['ip_address']=$row['framedipaddress'];
            $card_history['upload_bytes']=$row['acctinputoctets'];
            $card_history['download_bytes']=$row['acctoutputoctets'];

            $data[] = $card_history;

        }


        return $data;

    }






    function getAllAvailableHotels(){

        $sql = "select * from rm_usergroups";

        $result = mysql_query($sql)or die(mysql_error());

        $hotels = array();

        while($data = mysql_fetch_array($result)){


            $hotel_data['hotel_id'] = $data['groupid'];
            $hotel_data['hotel_name'] = $data['groupname'];
            $hotel_data['hotel_code'] = $data['descr'];

            $hotels[] = $hotel_data;
        }


        return $hotels;

    }//getAllAvailableHotels








    function getRoomWiFiUsageForGivenPeriod($hotel,$room,$from,$to){

        $hotelData = PACKAGES ::getHotelOnGivenId($hotel);

        $hotel_code = $hotelData['hotel_code'];

        $room = $hotel_code."".$room;

        //working

        // $sql = "select * from system_user_details sud,radacct ra where ra.username = '".$room."' AND ra.username=sud.username AND (ra.acctstarttime BETWEEN '".$from."' AND '".$to."') AND (ra.acctstoptime BETWEEN '".$from."' AND '".$to."') AND (ra.acctstarttime BETWEEN sud.service_start_date AND sud.service_stop_date) AND (ra.acctstoptime BETWEEN sud.service_start_date AND sud.service_stop_date)";
        $sql = "select * from system_user_details sud,radacct ra where ra.username = '".$room."' AND ra.username=sud.username AND ( (ra.acctstarttime BETWEEN '".$from."' AND '".$to."') AND (ra.acctstoptime BETWEEN '".$from."' AND '".$to."') OR  ('".$from."' BETWEEN ra.acctstarttime AND ra.acctstoptime) OR ('".$to."' BETWEEN ra.acctstarttime AND ra.acctstoptime)) AND (ra.acctstarttime BETWEEN sud.service_start_date AND sud.service_stop_date) AND (ra.acctstoptime BETWEEN sud.service_start_date AND sud.service_stop_date)";
        // echo "[".$sql."]";

        $result = mysql_query($sql)or die(mysqli_error());


        $WiFiUsage = array();

        while($data = mysql_fetch_array($result)){


            $wi_fi_data['contact_name'] = $data['contact_name'];
            $wi_fi_data['nic_passport_no'] = $data['nic_passport_no'];
            $wi_fi_data['service_start_date'] = $data['service_start_date'];
            $wi_fi_data['service_stop_date'] = $data['service_stop_date'];
            $wi_fi_data['acc_start_time'] = $data['acctstarttime'];
            $wi_fi_data['acc_stop_time'] = $data['acctstoptime'];
            $wi_fi_data['acc_session_time'] = $data['acctsessiontime'];
            $wi_fi_data['uploaded_bytes'] = $data['acctinputoctets'];
            $wi_fi_data['downloaded_bytes'] = $data['acctoutputoctets'];
            $wi_fi_data['ip_address'] = $data['framedipaddress'];


            $WiFiUsage[]=$wi_fi_data;
        }



        return $WiFiUsage;


    }//getRoomWiFiUsageForGivenPeriod






    function getHotelWiFiUsageForGivenPeriod($hotel,$from,$to){

        $hotelData = PACKAGES ::getHotelOnGivenId($hotel);

        if(array_key_exists('hotel_code',$hotelData)){
            $hotel_code = $hotelData['hotel_code'];
        }
        else{
            $hotel_code = "";
        }

        // $sql ="SELECT username,min(acctstarttime) as start_time, max(acctstoptime) as stop_time , sum(acctsessiontime) as session_time ,sum(acctinputoctets) as upload, sum(acctoutputoctets) as download FROM radacct WHERE username like 'KHMS%' and acctstarttime>='2011-12-01 00:00:00'  and acctstoptime <= '2012-03-31 00:00:00' group by username";
        $sql ="SELECT username,min(acctstarttime) as start_time, max(acctstoptime) as stop_time , sum(acctsessiontime) as session_time ,sum(acctinputoctets) as upload, sum(acctoutputoctets) as download FROM radacct WHERE username like '".$hotel_code."%' and acctstarttime>='".$from."'  and acctstoptime <= '".$to."' group by username";


        $result = mysql_query($sql)or die(mysqli_error());

        $WiFiUsage = array();

        while($data = mysql_fetch_array($result)){

            $wi_fi_data['username'] = $data['username'];
            $wi_fi_data['start_time'] = $data['start_time'];
            $wi_fi_data['stop_time'] = $data['stop_time'];
            $wi_fi_data['session_time'] = $data['session_time'];
            $wi_fi_data['upload'] = $data['upload'];
            $wi_fi_data['download'] = $data['download'];

            $WiFiUsage[]=$wi_fi_data;
        }



        return $WiFiUsage;


    }//getRoomWiFiUsageForGivenPeriod





    function getHotelOnGivenId($hotelId){


        $sql = "select * from rm_usergroups where groupid =".$hotelId."";

        $result = mysql_query($sql)or die(mysql_error());

        $hotel_data = array();

        while($data = mysql_fetch_array($result)){


            $hotel_data['hotel_id'] = $data['groupid'];
            $hotel_data['hotel_name'] = $data['groupname'];
            $hotel_data['hotel_code'] = $data['descr'];


        }


        return $hotel_data;

    }//getHotelOnGivenId







    function getGraphCodeBasedOnHotel(){

        $sql = "select * from system_hotel_graph_codes where hotel_id =".$_POST['hotel_id']."";

        $result = mysql_query($sql)or die(mysql_error());

        $data = mysql_fetch_array($result);

        return $data['graph_code'].'######'.$data['interface_code'];

    }//function




    function isWiFiEnabledHotelRoom($hotel_no,$room_no){


        $sql = "select * from system_wifi_enable_hotel_rooms where hotel_id = ".$hotel_no." AND room_id ='".$room_no."'";

        $result = mysql_query($sql) or die("Error occured ".mysql_errno());

        if(mysql_num_rows($result)>0){

            return TRUE;
        }
        else{
            return FALSE;
        }


    }//function



    function getGraphAndInterfaceCodeBasedOnHotel(){


        $sql = "select * from system_hotel_graph_codes where hotel_id =".$_POST['hotel_id']."";

        $result = mysql_query($sql)or die(mysql_error());

        $data = mysql_fetch_array($result);

        $code = $data['graph_code']."####".$data['interface_code'];

        return $code;

    }





    function showRoomListForHotel(){

        // echo "room list for ".$_POST['hotel_id'];



        $sql = "select * from system_wifi_enable_hotel_rooms where hotel_id = ".$_POST['hotel_id']." order by room_id ASC";

        $result =  mysql_query($sql);

        if(mysql_num_rows($result)>0){

            $SelectStr='<label>Room No </label>';
            $SelectStr = $SelectStr.'<select id="room_no" name ="room_no">';
            while($data =  mysql_fetch_array($result)){

                $SelectStr = $SelectStr.'<option value ="'.$data['room_id'].'">'.$data['room_id'].'</option>';
            }
            $SelectStr=$SelectStr.'</select>';

            echo $SelectStr;
        }
        else{

            echo "<b> No Rooms Available for the Selected Hotel</b>";
        }
    }





    function checkWhetherTheUserNameAlreadyExists($UserName){

        $result  = mysql_query("select * from system_user_details where username = '".$UserName."'");

        if(mysql_num_rows($result) >0){
            return FALSE;
        }
        else{
            return TRUE;
        }
    }




    function isUserInHotelRoom(){

        //$hotel_id  = $_POST['htl_id'];

        $result1  = mysql_query("select * from rm_usergroups where groupid=".$_POST['htl_id']."");

        $data = mysql_fetch_array($result1);

        $username = $data['descr']."".$_POST["user_name"];

        $sql = "select * from system_user_details where username = '".$username."' AND service_stop_date > now()";

        $result = mysql_query($sql);

        if(mysql_num_rows($result)>0){

            $data1 = mysql_fetch_array($result);

            $data2 = mysql_fetch_array(mysql_query("select * from system_users where user_id = ".$data1['created_by'].""));

            $string = "<h3>Room : ".$_POST['user_name']."</h3> <br/> <h3>Expire Date: ".$data1['service_stop_date']."</h3><br/><h3>Created By: ".$data2['name']."</h3><br/>";

            return "1####".$string;
        }
        else{

            return "0####no user";
        }

    }


}//class


?>
