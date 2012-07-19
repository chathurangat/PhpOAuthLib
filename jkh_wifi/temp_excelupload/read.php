<?php 
//die();   
session_start();
//Database Configuration localhost
define ('DB_HOST','localhost');
define ('DB_USER','root');
define ('DB_PWD','');
define ('DB_DB','lcs_ims');

mysql_pconnect(DB_HOST, DB_USER, DB_PWD) or trigger_error(mysql_error(),E_USER_ERROR); 

mysql_select_db(DB_DB) ;

require_once 'Excel/reader.php';
	
// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();

// Set output Encoding.
$data->setOutputEncoding('CP1251');

// Select the required excel file
$data->read("Book1.xls");



$num_rows = $data->sheets[0]['numRows'] - 1;	


for ($i=1; $i<=$num_rows; $i++) {


    $Master_Item_Code  = addslashes($data->sheets[0]['cells'][$i][1]);  
	$Item_Name  = addslashes($data->sheets[0]['cells'][$i][2]); 
	$Primary_cat = addslashes($data->sheets[0]['cells'][$i][3]);    
	$Secondary_cat  = addslashes($data->sheets[0]['cells'][$i][4]);
	
	
        echo $Item_Name."<br/>";        
        echo $Primary_cat."<br/>";
        echo $Secondary_cat."<br/>";
        
	

$sql = "insert into ta_ims_item_master(Master_Item_Code,Item_Name,Type_Code,Primary_cat,Secondary_cat,Employee_Code) 
                                         
                                      values('".$Master_Item_Code."','".$Item_Name."','1','".$Primary_cat."','".$Secondary_cat."','1')   
                                         
                                         ";
//echo $sql.";<br/>";

echo mysql_query($sql) or die(mysql_error());
	
	
	
}

?>