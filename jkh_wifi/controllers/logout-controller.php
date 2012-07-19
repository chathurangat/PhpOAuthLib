<?php 
require_once('../config/config.php');
unset($_SESSION['user_id']);
unset($_SESSION['group_id']);
unset($_SESSION['name']);
unset($_SESSION['custermer_id']);

if(isset($_SESSION['user_id']) && isset($_SESSION['group_id']) &&  isset($_SESSION['name']) &&  isset($_SESSION['custermer_id'])){	
	echo "ela";
	die();
	}else{
	header("Location:".HTTP_PATH."login"); 
		
		
		}
