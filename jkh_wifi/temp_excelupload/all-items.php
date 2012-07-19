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
$data->read("item_data - 20_Jul.xls");



$num_rows = $data->sheets[0]['numRows'] - 1;	


for ($i=1; $i<=$num_rows; $i++) {


   $Item_no  = addslashes($data->sheets[0]['cells'][$i][1]);  
   $Status  = addslashes($data->sheets[0]['cells'][$i][2]); 
   $Item_Code = addslashes($data->sheets[0]['cells'][$i][3]);    
   $Master_Item_Code  = addslashes($data->sheets[0]['cells'][$i][4]);
   $Item_Serial_No  = addslashes($data->sheets[0]['cells'][$i][5]);
   $LCS_No  = addslashes($data->sheets[0]['cells'][$i][6]);
   $GRN_No  = addslashes($data->sheets[0]['cells'][$i][7]);
   $GRN_Detail_Code  = addslashes($data->sheets[0]['cells'][$i][8]);
   $Item_Cost  = addslashes($data->sheets[0]['cells'][$i][9]);
   $Order_Code  = addslashes($data->sheets[0]['cells'][$i][10]);
   $Customer_Code  = addslashes($data->sheets[0]['cells'][$i][11]);
   $Service_Code  = addslashes($data->sheets[0]['cells'][$i][12]);
   $Connection_Code  = addslashes($data->sheets[0]['cells'][$i][13]);
   
   
   $Location_Code  = addslashes($data->sheets[0]['cells'][$i][14]);
   
    $Status_Code  = addslashes($data->sheets[0]['cells'][$i][15]);
    $Manufacture_Code  = addslashes($data->sheets[0]['cells'][$i][16]);
    $Quality_Status_Code  = addslashes($data->sheets[0]['cells'][$i][17]);
   $Bought_Quantity  = addslashes($data->sheets[0]['cells'][$i][18]);
    $Current_Quantity  = addslashes($data->sheets[0]['cells'][$i][19]);
    $Fa  = addslashes($data->sheets[0]['cells'][$i][20]);
	$Department_Code  = addslashes($data->sheets[0]['cells'][$i][21]);
	
      //  echo $Item_Name."<br/>";        
       // echo $Primary_cat."<br/>";
      //  echo $Secondary_cat."<br/>";
        
	

$sql = "insert into ta_ims_items(Item_Code, 
                                Item_no, 
                                Master_Item_Code, 
                                Item_Serial_No, 
                                LCS_No, 
                                GRN_No, 
                                GRN_Detail_Code, 
                                Item_Cost, 
                                Current_Quantity, 
                                Bought_Quantity, 
                                Order_Code, 
                                Customer_Code, 
                                Service_Code,
                                Connection_Code, 
                                Location_Code, 
                                Status_Code,                                
                                Manufacture_Code, 
                                Quality_Status_Code, 
                                Department_Code,
                                Fa,
                                Status) 
                                         
                              values('".$Item_Code."',
                                      '".$Item_no."',
                                      '".$Master_Item_Code."',
                                      '".$Item_Serial_No."',
                                      '".$LCS_No."',
                                      '".$GRN_No."',
                                      '".$GRN_Detail_Code."',
                                      '".$Item_Cost."',
                                      '".$Current_Quantity."',
                                      '".$Bought_Quantity."',
                                      '".$Order_Code."',
                                      '".$Customer_Code."',
                                      '".$Service_Code."',
                                      '".$Connection_Code."',
                                      '".$Location_Code."',
                                      '".$Status_Code."',
                                      '".$Manufacture_Code."',
                                      '".$Quality_Status_Code."',
                                      '".$Department_Code."',
                                      '".$Fa."',
                                      '".$Status."')   
                                         
                                         ";
//echo $sql.";<br/>";

echo mysql_query($sql) or die(mysql_error());
	
	
	
}

?>