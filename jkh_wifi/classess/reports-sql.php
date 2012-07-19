<?php 
	function getUsageTime($user, $client) {

    $sql = "SELECT AcctStartTime , AcctStopTime  FROM radacct WHERE   UserName='" .mysql_real_escape_string($user). "'  and UserName in ( select UserName FROM radcheck where CustID='" . mysql_real_escape_string($client). "' )";

    $mRows = mysql_query($sql);
    $usgtm = 0;

    while ($mRow = mysql_fetch_array($mRows)) {

        $strttm = strtotime($mRow["AcctStartTime"]);

        $stoptm = strtotime($mRow["AcctStopTime"]);

        if ($mRow["AcctStopTime"] == '0000-00-00 00:00:00')
            $usgtm +=time() - $strttm;

        else
            $usgtm+=$stoptm - $strttm;
    }

    return $usgtm;
}

 function getDaysString($diff) {
                            $mReturnString = "";
                            if ($days = intval((floor($diff / 86400)))) {
                                $diff = $diff % 86400;
                                $mReturnString .= $days . " Days";
                            }
                            if ($hours = intval((floor($diff / 3600)))) {
                                $diff = $diff % 3600;

                                $mReturnString .= empty($mReturnString) ? $hours . " Hours" : ", " . $hours . " Hours";
                            }
                            if ($minutes = intval((floor($diff / 60)))) {
                                $diff = $diff % 60;
                                $mReturnString .= empty($mReturnString) ? $minutes . " Minutes" : ", " . $minutes . " Minutes";
                            }
                            $diff = intval($diff);
                            if ($diff > 0) {
                                $mReturnString .= empty($mReturnString) ? $diff . " Seconds" : ", " . $diff . " Seconds";
                            }

                            return $mReturnString;
// return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
                        }

class REPORTS{
	
	
//function to get live users
function getliveusers($custermer_id){	
	

$liveusers = array();


	
$mQueryx = "SELECT radcheck.UserName , radcheck.id , radcheck.Value  FROM  radcheck , radacct WHERE   radcheck.CustID ='".mysql_real_escape_string($custermer_id)."' and radcheck.UserName=radacct.UserName and radacct.AcctStopTime='0000-00-00 00:00:00' group by radcheck.UserName ";

$mResultx = mysql_query($mQueryx);

$mStyle = 'class="alt2"';

$emptyusg = "Not Used";
$sectm = "";
$numOfCards = 0;
while ($mRowx = mysql_fetch_array($mResultx)) {
    $mQueryx2 = "SELECT AcctStartTime , AcctStopTime  FROM radacct WHERE   UserName='" . $mRowx["UserName"] . "' and radacct.AcctStopTime='0000-00-00 00:00:00' order by AcctStartTime asc ";
    $mRowx2 = mysql_fetch_array(mysql_query($mQueryx2));

    mysql_num_rows(mysql_query($mQueryx2));




    $mQueryy = "SELECT * FROM `usergroup` WHERE UserName='" . $mRowx["UserName"] . "' ";
    $mResulty = mysql_query($mQueryy) or die($mQueryy . "<br/>" . mysql_error());
    $mRowy = mysql_fetch_array($mResulty);

    $mQueryz = "SELECT * FROM `radgroupcheck` WHERE GroupName='" . $mRowy['GroupName'] . "' and Attribute='Validity-Period' ";
    $mResultz = mysql_query($mQueryz) or die($mQuery2 . "<br/>" . mysql_error());
    $mRowz = mysql_fetch_array($mResultz);
    $mQueryb = "SELECT * FROM `radgroupcheck` WHERE GroupName='" . $mRowy['GroupName'] . "' and Attribute='Max-Session-Time' ";
    $mResultb = mysql_query($mQueryb) or die($mQueryb . "<br/>" . mysql_error());
    $mRowb = mysql_fetch_array($mResultb);

    $loginTime = mysql_fetch_array(mysql_query("SELECT AcctStartTime,AcctStopTime  FROM radacct WHERE   UserName='" . $mRowx["UserName"] . "' order by AcctStartTime asc "));
   // echo "SELECT AcctStartTime,AcctStopTime  FROM radacct WHERE   UserName='" . $mRowx["UserName"] . "' order by AcctStartTime asc ";
    $wifiuser = null;
   // echo $loginTime['AcctStartTime'] . "--" . $loginTime['AcctStopTime'];
   /// if ($loginTime['AcctStartTime'] >= $from && $loginTime['AcctStopTime'] < $to) {

        $mResultp = mysql_query("SELECT * FROM package_prices where package_name='" . $mRowy["GroupName"] . "' ") or die($mQueryp . "<br/>" . mysql_error());
        $mRowp = mysql_fetch_array($mResultp);

        $sectm = strtotime($loginTime['AcctStartTime']) + $mRowz["Value"];

        $usgtm = getUsageTime($mRowx['UserName'], $custermer_id) + 60;
    //    echo $usgtm . "<br />";
        $mStyle = "";
?>
        <?php
        $wifiuser['id'] = $mRowx['id'];

        $wifiuser['name'] = $mRowx['UserName'];
        $wifiuser['value'] = $mRowx['Value'];
        $wifiuser['price'] = $mRowp["price"];
		   $wifiuser['starttime'] = $loginTime['AcctStartTime'];
		
		$liveusers[] = $wifiuser;
		
 //       if ($loginTime['AcctStartTime'] != '') {
//            $wifiuser['starttime'] = $loginTime['AcctStartTime'];
//            $wifiuser['expiretime'] = date("Y-m-d H:m:s a", $sectm);
//            $wifiuser['usagetime'] = getDaysString($usgtm);
//        } else {
//
//            $wifiuser['starttime'] = $emptyusg;
//            $wifiuser['expiretime'] = $emptyusg;
//            $wifiuser['usagetime'] = $emptyusg;
//        }

       // if ($usgtm >= $mRowz["Value"] || $sectm < time()) {
//           // $expiredusers[] = $wifiuser;
//        } else {
//            $liveusers[] = $wifiuser;
//        }
    }
//}	
	
	
	
	
	return $liveusers;
	
	}
//End Of live users function
		
	
	



//function to get Not Used Users
function getnotusedcustermers($custermer_id){	
	

$notusedusers = array();


	$notusedquery="SELECT radcheck.* FROM radcheck LEFT JOIN radacct ON radcheck.UserName=radacct.UserName
                            WHERE radcheck.CustID='".mysql_real_escape_string($custermer_id)."' AND radacct.UserName IS NULL";	
	
	$notusedresult = mysql_query($notusedquery);



while ($mRowx = mysql_fetch_array($notusedresult)) {
	
 $mQueryy = "SELECT * FROM `usergroup` WHERE UserName='".$mRowx["UserName"]."' "; 
 $mResulty = mysql_query($mQueryy) or die(mysql_error());
 $mRowy = mysql_fetch_array($mResulty);

    $mQueryz = "SELECT * FROM `radgroupcheck` WHERE GroupName='".$mRowy['GroupName']."' and Attribute='Validity-Period' ";	
	 $mResultz = mysql_query($mQueryz) or die($mQueryz . "<br/>" . mysql_error());
    $mRowz = mysql_fetch_array($mResultz);
	
	
   $mQueryb = "SELECT * FROM `radgroupcheck` WHERE GroupName='" . $mRowy['GroupName'] . "' and Attribute='Max-Session-Time' ";
    $mResultb = mysql_query($mQueryb) or die($mQueryb . "<br/>" . mysql_error());
    $mRowb = mysql_fetch_array($mResultb);

    $wifiuser = null;

  $mResultp = mysql_query("SELECT * FROM package_prices where package_name='".$mRowy["GroupName"] . "' ") or die(mysql_error());
    $mRowp = mysql_fetch_array($mResultp);


    $mStyle = "";

  $wifiuser['id'] = $mRowx['id'];

    $wifiuser['name'] = $mRowx['UserName'];
    $wifiuser['value'] = $mRowx['Value'];
    $wifiuser['price'] = $mRowp["price"];
    $notusedusers[] = $wifiuser;

	
}	
		return $notusedusers;
	
	}
//End Of Not Used Function	
	
	
	
function getactiveusers($custermer_id,$from,$to){	
$activeusers = array();
$expiredusers = array();	
$mQueryx = "SELECT radcheck.UserName , radcheck.id , radcheck.Value  FROM  radcheck , radacct WHERE   radcheck.CustID ='".mysql_real_escape_string($custermer_id)."' and radcheck.UserName=radacct.UserName and ((radacct.AcctStartTime between '" . $from . "' and  '" . $to . "')) group by radcheck.UserName ";
$mResultx = mysql_query($mQueryx);
$mStyle = 'class="alt2"';
$emptyusg = "Not Used";
$sectm = "";
$numOfCards = 0;
while ($mRowx = mysql_fetch_array($mResultx)) {
    $mQueryx2 = "SELECT AcctStartTime , AcctStopTime  FROM radacct WHERE   UserName='" . $mRowx["UserName"] . "' and AcctStartTime between '" . $from . "' and  '" . $to . "' order by AcctStartTime asc ";
    $mRowx2 = mysql_fetch_array(mysql_query($mQueryx2));
    mysql_num_rows(mysql_query($mQueryx2));
    $mQueryy = "SELECT * FROM `usergroup` WHERE UserName='" . $mRowx["UserName"] . "' ";
    $mResulty = mysql_query($mQueryy) or die($mQueryy . "<br/>" . mysql_error());
    $mRowy = mysql_fetch_array($mResulty);
    $mQueryz = "SELECT * FROM `radgroupcheck` WHERE GroupName='" . $mRowy['GroupName'] . "' and Attribute='Validity-Period' ";
    $mResultz = mysql_query($mQueryz) or die($mQuery2 . "<br/>" . mysql_error());
    $mRowz = mysql_fetch_array($mResultz);
    $mQueryb = "SELECT * FROM `radgroupcheck` WHERE GroupName='" . $mRowy['GroupName'] . "' and Attribute='Max-Session-Time' ";
    $mResultb = mysql_query($mQueryb) or die($mQueryb . "<br/>" . mysql_error());
    $mRowb = mysql_fetch_array($mResultb);
    $loginTime = mysql_fetch_array(mysql_query("SELECT AcctStartTime,AcctStopTime  FROM radacct WHERE   UserName='" . $mRowx["UserName"] . "' order by AcctStartTime asc "));
   // echo "SELECT AcctStartTime,AcctStopTime  FROM radacct WHERE   UserName='" . $mRowx["UserName"] . "' order by AcctStartTime asc ";
    $wifiuser = null;
   // echo $loginTime['AcctStartTime'] . "--" . $loginTime['AcctStopTime'];
    if ($loginTime['AcctStartTime'] >= $from && $loginTime['AcctStopTime'] < $to) {
        $mResultp = mysql_query("SELECT * FROM package_prices where package_name='" . $mRowy["GroupName"] . "' ") or die($mQueryp . "<br/>" . mysql_error());
        $mRowp = mysql_fetch_array($mResultp);
        $sectm = strtotime($loginTime['AcctStartTime']) + $mRowz["Value"];
        $usgtm = getUsageTime($mRowx['UserName'], $custermer_id) + 60;
    //    echo $usgtm . "<br />";
        $mStyle = "";?>
        <?php
        $wifiuser['id'] = $mRowx['id'];
        $wifiuser['name'] = $mRowx['UserName'];
        $wifiuser['value'] = $mRowx['Value'];
        $wifiuser['price'] = $mRowp["price"];
        if ($loginTime['AcctStartTime'] != '') {
            $wifiuser['starttime'] = $loginTime['AcctStartTime'];
            $wifiuser['expiretime'] = date("Y-m-d H:m:s a", $sectm);
            $wifiuser['usagetime'] = getDaysString($usgtm);
        } else {
            $wifiuser['starttime'] = $emptyusg;
            $wifiuser['expiretime'] = $emptyusg;
            $wifiuser['usagetime'] = $emptyusg;
        }
        if ($usgtm >= $mRowz["Value"] || $sectm < time()) {
           // $expiredusers[] = $wifiuser;
        } else {
            $activeusers[] = $wifiuser;
        }
    }
}		
	return $activeusers;	
	}	
	
	

function getexpiredusers($custermer_id,$from,$to){
$expiredusers = array();	
$mQueryx = "SELECT radcheck.UserName , radcheck.id , radcheck.Value  FROM  radcheck , radacct WHERE   radcheck.CustID ='".mysql_real_escape_string($custermer_id)."' and radcheck.UserName=radacct.UserName and ((radacct.AcctStartTime between '".$from."' and  '".$to."')) group by radcheck.UserName";
$mResultx = mysql_query($mQueryx);
$mStyle = 'class="alt2"';
$emptyusg = "Not Used";
$sectm = "";
$numOfCards = 0;
while ($mRowx = mysql_fetch_array($mResultx)) {
    $mQueryx2 = "SELECT AcctStartTime , AcctStopTime  FROM radacct WHERE   UserName='".$mRowx["UserName"]."' and AcctStartTime between '".$from."' and  '".$to."' order by AcctStartTime asc ";
    $mRowx2 = mysql_fetch_array(mysql_query($mQueryx2));
    mysql_num_rows(mysql_query($mQueryx2));
	    $mQueryy = "SELECT * FROM `usergroup` WHERE UserName='".$mRowx["UserName"]."' ";
    $mResulty = mysql_query($mQueryy) or die($mQueryy."<br/>" . mysql_error());
    $mRowy = mysql_fetch_array($mResulty);
    $mQueryz = "SELECT * FROM `radgroupcheck` WHERE GroupName='" . $mRowy['GroupName'] . "' and Attribute='Validity-Period' ";
    $mResultz = mysql_query($mQueryz) or die($mQueryz."<br/>" .mysql_error());
    $mRowz = mysql_fetch_array($mResultz);
    $mQueryb = "SELECT * FROM `radgroupcheck` WHERE GroupName='".$mRowy['GroupName']."' and Attribute='Max-Session-Time' ";
    $mResultb = mysql_query($mQueryb) or die($mQueryb . "<br/>" . mysql_error());
    $mRowb = mysql_fetch_array($mResultb);
    $loginTime = mysql_fetch_array(mysql_query("SELECT AcctStartTime,AcctStopTime  FROM radacct WHERE   UserName='".$mRowx["UserName"]."' order by AcctStartTime asc "));
   // echo "SELECT AcctStartTime,AcctStopTime  FROM radacct WHERE   UserName='" . $mRowx["UserName"] . "' order by AcctStartTime asc ";
    $wifiuser = null;
   // echo $loginTime['AcctStartTime'] . "--" . $loginTime['AcctStopTime'];
    if ($loginTime['AcctStartTime'] >= $from && $loginTime['AcctStopTime'] < $to) {
        $mResultp = mysql_query("SELECT * FROM package_prices where package_name='" . $mRowy["GroupName"] . "' ") or die($mQueryp . "<br/>" . mysql_error());
        $mRowp = mysql_fetch_array($mResultp);
        $sectm = strtotime($loginTime['AcctStartTime']) + $mRowz["Value"];
        $usgtm = getUsageTime($mRowx['UserName'], $custermer_id) + 60;
    //    echo $usgtm . "<br />";
        $mStyle = "";
        $wifiuser['id'] = $mRowx['id'];
        $wifiuser['name'] = $mRowx['UserName'];
        $wifiuser['value'] = $mRowx['Value'];
        $wifiuser['price'] = $mRowp["price"];
        if ($loginTime['AcctStartTime'] != '') {
            $wifiuser['starttime'] = $loginTime['AcctStartTime'];
            $wifiuser['expiretime'] = date("Y-m-d H:m:s a", $sectm);
            $wifiuser['usagetime'] = getDaysString($usgtm);
        } else {
            $wifiuser['starttime'] = $emptyusg;
            $wifiuser['expiretime'] = $emptyusg;
            $wifiuser['usagetime'] = $emptyusg;
        }
       if ($usgtm >= $mRowz["Value"] || $sectm < time()) {			
           $expiredusers[] = $wifiuser;
		  } else {	
           // $activeusers[] = $wifiuser;
        }
    }}			
	return $expiredusers;	
	}	
	}
?>