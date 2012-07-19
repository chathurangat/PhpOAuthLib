<?php 
//die();   
session_start();
//Database Configuration localhost
define ('DB_HOST','localhost');
define ('DB_USER','root');
define ('DB_PWD','');
define ('DB_DB','wifilatest');

mysql_pconnect(DB_HOST, DB_USER, DB_PWD) or trigger_error(mysql_error(),E_USER_ERROR); 

mysql_select_db(DB_DB) ;

require_once 'Excel/reader.php';
	
// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();

// Set output Encoding.
$data->setOutputEncoding('CP1251');

// Select the required excel file
$data->read("wifi new card list 2011-07-27.xls");



$num_rows = $data->sheets[0]['numRows'] ;	


for ($i=1; $i<=$num_rows; $i++) {


    $card_no  = addslashes($data->sheets[0]['cells'][$i][1]);  
	$username  = addslashes($data->sheets[0]['cells'][$i][2]); 
	$pw = addslashes($data->sheets[0]['cells'][$i][3]);    

	
	
        echo $card_no."<br/>";        
        echo $username."<br/>";
        echo $pw."<br/>";
        
	
    
 $sql = "INSERT INTO radcheck(id,CustID,UserName,Attribute,op,Value) 
                                        VALUES(
                                          '".$card_no."',
                                            '0',
                                               '".$username."',
                                               'User-Password',
                                               '==',
                                               '".$pw."'    )";
        $res = mysql_query($sql)or die();
        echo $res;
       // return mysql_insert_id();
        
        $sql2 = "INSERT INTO usergroup(UserName,GroupName,priority) 
                                        VALUES('".$username."',
                                               '7D-10H',
                                               '1' )";
       $res2 = mysql_query($sql2)or die();           
         echo $res2;  
         
         echo "-------------------<br/>";
    
    
    
    
    

	
}

?>