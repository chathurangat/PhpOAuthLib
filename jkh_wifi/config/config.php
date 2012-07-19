<?php
session_start();
//define('HTTP_PATH', 'http://203.143.20.173/jkh_wifi/');
//define('HTTP_PATH', 'http://khms.lankacom.net/');
//define('HTTP_PATH', 'http://localhost/jkh_wifi/');
define('HTTP_PATH', 'http://192.168.0.216/jkh_wifi/');


//SMTP MAIL SETTINGS
define ('SMTPAUTH','true');
define ('SMTPSECURE','ssl');
define ('HOST','smtp.gmail.com');
define ('PORT','465');
define ('MAIL_USERNAME','lankacomwifi');
define ('MAIL_PASSWORD','lankacomwifiadmin123#');
define ('DOCUMENT_ROOT','/var/www/jkh_wifi/');

define ('ADMIN_EMAIL','viranf@lankacom.net');


//Database Configuration wifi Local
//define ('DB_HOST','localhost');
//define ('DB_USER','root');
//define ('DB_PWD','lankacom');
//define ('DB_DB','radius');



define ('DB_HOST','localhost');
define ('DB_USER','root');
define ('DB_PWD','Lcshotsql#');
define ('DB_DB','radius_jkh_live');


$con1 = mysql_pconnect(DB_HOST, DB_USER, DB_PWD) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db(DB_DB) or die(mysql_error());

/// Devoloper : Viran Fernando
/// Date : 2012-01-04 09.20 PM


?>
