<?
$hostname_rsConn = "203.143.14.232:14331";
$database_rsConn = "MIS2000";
$username_rsConn = "sa";
$password_rsConn= "lcs321";
$mssqlConn = mssql_pconnect($hostname_rsConn, $username_rsConn, $password_rsConn) or trigger_error(mysql_error(),E_USER_ERROR);

$selected = mssql_select_db($database_rsConn, $mssqlConn) or die("Couldn't open database $database_rsConn");

//email

$query_Recordset_messagelistemail = "SELECT * FROM messagelist";

$Recordset_messagelistemail = mssql_query($query_Recordset_messagelistemail, $mssqlConn) or die();

$ind=0;

while($row = mssql_fetch_array($Recordset_messagelistemail)){

    //sending EMAIL
    if($row['mess_type']=='EMAIL' && $row['sendstatus']==0){
        $to = "".$row['recipient']."";
        $subject = "".$row['subject']."";
        $body = "".$row['email_body']."";
        $headers = 'From: webmaster@lankacom.net' . "\r\n" .
            'Reply-To: webmaster@lankacom.net' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $body);
    }//if

    //sending SMS
    if($row['mess_type']=='SMS' && $row['sendstatus']==0){

        system('sudo /usr/local/bin/sendsms.wo '.$row["recipient"].' \''.$row["sms_body"].'\' ');
    }

}

//sms
/*
$query_Recordset_messagelistsms = "SELECT * FROM messagelist WHERE sendstatus = 0 AND mess_type = 'SMS'";
$Recordset_messagelistsms = mssql_query($query_Recordset_messagelistsms, $mssqlConn) or die();
$ind=0;
while($row = mssql_fetch_array($Recordset_messagelistsms)){
    system('sudo /usr/local/bin/sendsms.wo '.$row["recipient"].' \''.$row["sms_body"].'\' ');
}
*/

?>
