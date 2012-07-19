<?php
error_reporting(E_ALL);

/** Include path **/
ini_set('include_path', ini_get('include_path').';Classes/');

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

$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'viran');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Test2!');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Test3');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Test4!');





// Rename sheet
//echo date('H:i:s') . " Rename sheet\n<br/>";
$objPHPExcel->getActiveSheet()->setTitle('Simple');

		
// Save Excel 2007 file
//echo date('H:i:s') . " Write to Excel2007 format\n<br/>";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="myfile.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output'); 


// Echo done
//echo date('H:i:s') . " Done writing file.\r\n<br/>";

//fopen("c:\\folder\\resource.txt", "r")


//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save('php://output'); 
