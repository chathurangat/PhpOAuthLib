<?php 
require_once ("../phpmailer/class.phpmailer.php");
require_once ("../phpmailer/class.smtp.php");




class MAIL{
	
	
	
	function notificatonOfActivatedcards($pw,$htl_prefix){
		
	$htl = PACKAGES :: getHotelbyid($_POST['htl_id']);
	
	
		
		$emailbody ="
Hotel = ".$htl."<br />
Room No. (Username) = ".$htl_prefix.$_POST['user_name']."<br />
Password = ".$pw."<br />
Simultanious Users = ".$_POST['simultanious_users']."<br />
Expire Date = ".$_POST['expire_date']."<br />

Activated By = ".$_SESSION['name']."<br />
";

//$mail             = new PHPMailer();
//
//$body             = $emailbody; //$mail->getFile('contents.html');
//$body             = eregi_replace("[\]",'',$body);
//
//$mail->IsSMTP();
//$mail->SMTPAuth   = SMTPAUTH;                  // enable SMTP authentication
//$mail->SMTPSecure = SMTPSECURE;                 // sets the prefix to the servier
//$mail->Host       = HOST;      // sets GMAIL as the SMTP server
//$mail->Port       = PORT;                   // set the SMTP port
//
//$mail->Username   = MAIL_USERNAME;  // GMAIL username
//$mail->Password   = MAIL_PASSWORD;            // GMAIL password
//
//$mail->From       = 'lankacomwifi@gmail.com ';
//$mail->FromName   = "JKH WIFI Admin ";
//$mail->Subject    = "WiFi Card activated for ".$htl_prefix.$_POST['user_name']." on ".date('Y-m-d H:i:s')." ";
//$mail->AltBody    = "WiFi Card activated for ".$htl_prefix.$_POST['user_name']."  on ".date('Y-m-d H:i:s')." "; //Text Body
//$mail->WordWrap   = 50; // set word wrap
//
//$mail->MsgHTML($body);

//$mail->AddReplyTo("viranf@lankacom.net","Webmaster");

//$mail->AddAttachment("/path/to/file.zip");             // attachment
//$mail->AddAttachment("/path/to/ivimage.jpg", "new.jpg"); // attachment

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers

$headers .= 'From: JKH WIFI Admin <lankacomwifi@gmail.com>' . "\r\n";
$subject = "WiFi Card activated for ".$htl_prefix.$_POST['user_name']." on ".date('Y-m-d H:i:s')." ";
//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

// Mail it












	//THIS IS TO INFORM THE HOTEL STAFF INCLUDING RECEPTION 
	$htlitman = PACKAGES :: getHotelItmanagers($_POST['htl_id']);

while($rowhtlitman = mysql_fetch_array($htlitman)){	


$headers .= 'To: "'.$rowhtlitman['name'].'" "'.$rowhtlitman['email_address'].'"' . "\r\n";
//mail($rowhtlitman['email_address'], $subject, $emailbody, $headers);

	//smtp mail function
	//$mail->AddAddress($rowhtlitman['email_address'],$rowhtlitman['name']);	

	}
mail($rowhtlitman['email_address'], $subject, $emailbody, $headers);
	
	
	//THIS IS TO INFORM THE JKH IT MANAGERS
	$jkhitman = PACKAGES :: getJKHItmanagers($_POST['htl_id']);

while($rowjkhitman = mysql_fetch_array($jkhitman)){	

$headers .= 'To: "'.$rowjkhitman['name'].'" "'.$rowjkhitman['email_address'].'"' . "\r\n";
//mail($rowjkhitman['email_address'], $subject, $emailbody, $headers);
	//smtp mail function
	//$mail->AddAddress($rowjkhitman['email_address'],$rowjkhitman['name']);	
	}
//////////////////////////////////////////////////////////
mail($rowjkhitman['email_address'], $subject, $emailbody, $headers);

//$headers .= 'To: "'.$rowjkhitman['name'].'" "'.$rowjkhitman['email_address'].'"' . "\r\n";
// mail('viranf@lankacom.net', $subject, $emailbody, $headers);
// mail('tharinduh@lankacom.net', $subject, $emailbody, $headers);
//$mail->AddAddress("viranf@lankacom.net","Viran Fernando");
//$mail->AddAddress("tharinduh@lankacom.net","Tharindu hettiarachchi");
//////////////////////////////////////////////////////////////






//$mail->IsHTML(true); // send as HTML
//
//if(!$mail->Send()) {
//  
// // echo "1";
//  //echo "Mailer Error: " . $mail->ErrorInfo;
//  // email address are not the actual email addressess!!
//} else {
// // echo "1";
//} 
//		
		
		
		
		
		
		
		
		
		
		
		
		
		}
	
	
	
	
	
	
	
	
	
	
	
	
	function newuseraddmail(){		
		
$emailbody ="
Email address = ".$_POST['user_email']."<br />
Password = ".$_POST['user_password']."<br />
Login URL = ".HTTP_PATH."<br />

";

$mail             = new PHPMailer();

$body             = $emailbody; //$mail->getFile('contents.html');
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP();
$mail->SMTPAuth   = SMTPAUTH;                  // enable SMTP authentication
$mail->SMTPSecure = SMTPSECURE;                 // sets the prefix to the servier
$mail->Host       = HOST;      // sets GMAIL as the SMTP server
$mail->Port       = PORT;                   // set the SMTP port

$mail->Username   = MAIL_USERNAME;  // GMAIL username
$mail->Password   = MAIL_PASSWORD;            // GMAIL password

$mail->From       = 'lankacomwifi@gmail.com';
$mail->FromName   = "JKH WIFI Admin ";
$mail->Subject    = "Login Details of WiFi Hotspot Panel ";
$mail->AltBody    = "Login Details of WiFi Hotspot Panel"; //Text Body
$mail->WordWrap   = 50; // set word wrap

$mail->MsgHTML($body);

//$mail->AddReplyTo("viranf@lankacom.net","Webmaster");

//$mail->AddAttachment("/path/to/file.zip");             // attachment
//$mail->AddAttachment("/path/to/ivimage.jpg", "new.jpg"); // attachment
$mmr ="ronald20065@gmail.com";
$mail->AddAddress($mmr,$mmr);
//$mail->AddAddress($_POST['user_email'],$_POST['user_email']);

$mail->IsHTML(true); // send as HTML

if(!$mail->Send()) {

 // echo "1";
  //echo "Mailer Error: " . $mail->ErrorInfo;
  // email address are not the actual email addressess!!
} else {
  //echo "1";
}
		
		}//end of newuseraddmail()
		
		
		function notifyofactivatedcards($activatedcards){
		//$marketier_id =  USER :: gethotelsmarketier($_POST['custermer']);
			//$marketiers_email =  USER :: getmarketiersemail(USER :: gethotelsmarketier($_POST['custermer']));
			//echo $marketiers_email;
			//die();
		
			//foreach ($activatedcards as &$value) {
   ///$value += ",".$value;

//}

//$arr=array("blah1","blah2","blah3");
$attachedtextfile = "activated_cards_list_for_".str_replace(" ","",USER::getcustermerbyid($_POST['custermer'])).time();
$fp=fopen("../cardmanagement/card_list_logs/".$attachedtextfile.".txt","w+");

foreach($activatedcards as $key => $value){
fwrite($fp,"LCS00".$value.("\t\n"));
}


 $emailbody =$_POST['nofcards']." Card(s) have been activated for ". USER::getcustermerbyid($_POST['custermer']). 
 ".Please find the card serials in the attachment.";





			
		//$emailbody ="";			
			
			

$mail             = new PHPMailer();

$body             = $emailbody; //$mail->getFile('contents.html');
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP();
$mail->SMTPAuth   = SMTPAUTH;                  // enable SMTP authentication
$mail->SMTPSecure = SMTPSECURE;                 // sets the prefix to the servier
$mail->Host       = HOST;      // sets GMAIL as the SMTP server
$mail->Port       = PORT;                   // set the SMTP port

$mail->Username   = MAIL_USERNAME;  // GMAIL username
$mail->Password   = MAIL_PASSWORD;            // GMAIL password

$mail->From       = 'lankacomwifi@gmail.com';
$mail->FromName   = "JKH WIFI Admin ";
$mail->Subject    = $_POST['nofcards']." Card(s) have been activated for ". USER::getcustermerbyid($_POST['custermer']);
$mail->AltBody    = $_POST['nofcards']." Card(s) have been activated for ". USER::getcustermerbyid($_POST['custermer']);
$mail->WordWrap   = 50; // set word wrap

$mail->MsgHTML($body);

//$mail->AddReplyTo("viranf@lankacom.net","Weblmaster");

//$mail->AddAttachment("/path/to/file.zip");             // attachment
$mail->AddAttachment("../cardmanagement/card_list_logs/".$attachedtextfile.".txt", $attachedtextfile.".txt"); // attachment



//$mail->AddAddress("bill@lankacom.net","Billing");
//$mail->AddAddress("presales@lankacom.net","Presales");
//$mail->AddAddress("chathurangaw@lankacom.net","Chathuranga");
//$mail->AddAddress("finance@lankacom.net","Finance");
$mail->AddAddress("viranf@lankacom.net","Viran Fernando");
//$mail->AddAddress("fviran@gmail.com","Viran Fernando");
$mail->AddAddress("tharinduh@lankacom.net","Tharindu Hettiarachchi");
//this is to send the marketiers email
//$mail->AddAddress(USER :: getmarketiersemail(USER :: gethotelsmarketier($_POST['custermer'])),USER :: getmarketiersemail(USER :: gethotelsmarketier($_POST['custermer'])));



$mail->IsHTML(true); // send as HTML

if(!$mail->Send()) {
  
  return 1;
  //echo "Mailer Error: " . $mail->ErrorInfo;
  // email address are not the actual email addressess!!
} else {
  return 2;
} 
			
			
			
			
			
			
			
			
			
			
			
			
			
			}
	
	
	
	
	
	
	
	
	
	
	
	
	
	}

?>
