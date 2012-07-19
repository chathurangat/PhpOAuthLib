<?php //die();
require_once('../../config/config.php');
require_once('../../classess/user-sql.php');
require_once('../../classess/reports-sql.php');
$custermer_id = $_REQUEST['custermer'];
$from = $_REQUEST['from'];
$to = $_REQUEST['to'];

$activeusers = REPORTS::getnotusedcustermers($custermer_id);

//echo count($activeusers);
//die();


?>
<?php						
//echo "<h3>Active Users of ".USER::getcustermerbyid($_REQUEST['custermer'])."</h3>";
//echo "<div>From ".$from." To ".$to."</div>";

//die();
error_reporting(E_ALL);

/** Include path **/
ini_set('include_path', ini_get('include_path').';excel/');

/** PHPExcel */
include 'PHPExcel.php';

/** PHPExcel_Writer_Excel2007 */
include 'PHPExcel/Writer/Excel2007.php';

// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object\n<br/>";
$objPHPExcel = new PHPExcel();

// Set properties
//echo date('H:i:s') . " Set properties\n";
$objPHPExcel->getProperties()->setCreator("Lankacom WIFi Reports");
$objPHPExcel->getProperties()->setLastModifiedBy("Lankacom WIFi Reports");
$objPHPExcel->getProperties()->setTitle("Usage Reports");
$objPHPExcel->getProperties()->setSubject("Usage Reports");
$objPHPExcel->getProperties()->setDescription("Usage Reports");


// Add some data
//echo date('H:i:s') . " Add some data\n<br/>";
$objPHPExcel->setActiveSheetIndex(0);

//echo 1;
	$z=0;
	//$objPHPExcel->getActiveSheet()->SetCellValue('A1','No Results');		
                        if (!empty($activeusers)) {
							//echo 1;
							
							
								
		$objPHPExcel->getActiveSheet()->SetCellValue('A1',"Not Used Users of ".USER::getcustermerbyid($_REQUEST['custermer']). " From ".$from." To ".$to."");						
					
						
$objPHPExcel->getActiveSheet()->SetCellValue('A3',"Serial");   						
							
	if($_SESSION['group_id']==4 || $_SESSION['user_id']==66 || $_SESSION['user_id']==63){ 
$objPHPExcel->getActiveSheet()->SetCellValue('B3',"User");    
    }
	 				
	if($_SESSION['group_id']==4 || $_SESSION['user_id']==66){
	$objPHPExcel->getActiveSheet()->SetCellValue('C3',"Password"); 
	} 
	
$objPHPExcel->getActiveSheet()->SetCellValue('D3',"Package");
  								
	$x=4;
                            foreach ($activeusers as $wifiuser) {
//echo $x;


$objPHPExcel->getActiveSheet()->SetCellValue('A'.$x,$wifiuser['id']);
	if($_SESSION['group_id']==4 || $_SESSION['user_id']==66 || $_SESSION['user_id']==63){ 
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$x,$wifiuser['name']);  
    }
if($_SESSION['group_id']==4 || $_SESSION['user_id']==66){
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$x,$wifiuser['value']);
	} 

$objPHPExcel->getActiveSheet()->SetCellValue('D'.$x,"Rs. ".$wifiuser['price']);

$x++;
}

						}
$name = "Not used users of ".USER::getcustermerbyid($_REQUEST['custermer']).time().".xlsx";

// Rename sheet
//echo date('H:i:s') . " Rename sheet\n<br/>";
$objPHPExcel->getActiveSheet()->setTitle('Not Used Users');

		
// Save Excel 2007 file
//echo date('H:i:s') . " Write to Excel2007 format\n<br/>";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$name.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('excelfiles/'); 
?>
  
                        
                                       
                      <?php 	//echo "<b>Total : Rs.".$z."</b>"; ?>
                        
                        
                        
			