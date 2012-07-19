<?php

class LOGIN{
	
	
	
	function adminlogin(){
		
$sql = "SELECT * FROM system_users WHERE username='".mysql_real_escape_string($_POST['username'])."' AND password='".md5(mysql_real_escape_string($_POST['password']))."' ";
$res = mysql_query($sql)or die();

$row = mysql_fetch_array($res);

$_SESSION['user_id'] = $row['user_id'];
$_SESSION['group_id'] = $row['group_id'];
$_SESSION['name'] = $row['name'];
$_SESSION['custermer_id'] = $row['custermer_id'];
		
return mysql_num_rows($res);		






		}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	}

?>