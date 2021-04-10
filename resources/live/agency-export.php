<?php
session_start();

$DIR_ = $_SERVER["DOCUMENT_ROOT"]. "/";
$Export_DIR_ = $_SERVER["DOCUMENT_ROOT"]. "/exports/";

require($DIR_. "config1.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//1. Get the agency for the current userToken
$id = GetAgencyFromUserToken($_SESSION['userToken']);


//$id = GetAgencyID('ajenkins@adultandchild.org');
$name = GetAgencyName($id);

$_SESSION['agency'] = $name;
$_SESSION['agencyid'] = $id;

// PHPExcel CODE
date_default_timezone_set('Europe/London');
require('PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
require('PHPExcel-1.8/Classes/PHPExcel.php');

$excel2 = PHPExcel_IOFactory::createReader('Excel2007');
$excel2 = $excel2->load('Cost Report Template (Formulas).xlsx'); 

$result = GetPositions($_SESSION['agencyid'], $_SESSION['period']);
while ($row = $result->fetch_assoc()) 
{
	$result2 = GetEmployeesForExport($row['PositionTitle'], $_SESSION['agencyid'], $_SESSION['period']);
	$int = 8;
	while ($row2 = $result2->fetch_assoc()) 
	{
		switch ($row2['PositionID']) 
		{
		    case "1": // DW-ADM
		        $excel2->setActiveSheetIndex(1);
				$excel2->getActiveSheet()->setCellValue('B'.$int, $row2['LastName'])
				->setCellValue('C'.$int, $row2['FirstName'])
				->setCellValue('D'.$int, $row2['PositionTitle'])
				->setCellValue('E'.$int, $row2['InteCareAgencyID'])
				->setCellValue('F'.$int, $row2['LocationCode'])
				->setCellValue('G'.$int, $row2['SalariesWages'])
				->setCellValue('H'.$int, $row2['PayrollTaxFICA'])
				->setCellValue('I'.$int, $row2['OtherFringe'])
				->setCellValue('J'.$int, $row2['DuesFees'])
				->setCellValue('K'.$int, $row2['TravelTraining'])
				->setCellValue('L'.$int, $row2['MaterialsSupplies'])
				->setCellValue('M'.$int, $row2['PurchasedServices'])
				->setCellValue('N'.$int, $row2['OtherExpenses'])
				->setCellValue('O'.$int, $row2['DSSSalariesWages'])
				->setCellValue('P'.$int, $row2['DSSFringeBenefits']);
		        break;
		    case "2": // DW-CC
		        $excel2->setActiveSheetIndex(2);
				$excel2->getActiveSheet()->setCellValue('B'.$int, $row2['LastName'])
				->setCellValue('C'.$int, $row2['FirstName'])
				->setCellValue('D'.$int, $row2['PositionTitle'])
				->setCellValue('E'.$int, $row2['InteCareAgencyID'])
				->setCellValue('F'.$int, $row2['LocationCode'])
				->setCellValue('G'.$int, $row2['SalariesWages'])
				->setCellValue('H'.$int, $row2['PayrollTaxFICA'])
				->setCellValue('I'.$int, $row2['OtherFringe'])
				->setCellValue('J'.$int, $row2['DuesFees'])
				->setCellValue('K'.$int, $row2['TravelTraining'])
				->setCellValue('L'.$int, $row2['MaterialsSupplies'])
				->setCellValue('M'.$int, $row2['PurchasedServices'])
				->setCellValue('N'.$int, $row2['OtherExpenses'])
				->setCellValue('O'.$int, $row2['DSSSalariesWages'])
				->setCellValue('P'.$int, $row2['DSSFringeBenefits']);
		        break;				        
		    case "3": // DW-IS
		        $excel2->setActiveSheetIndex(3);
				$excel2->getActiveSheet()->setCellValue('B'.$int, $row2['LastName'])
				->setCellValue('C'.$int, $row2['FirstName'])
				->setCellValue('D'.$int, $row2['PositionTitle'])
				->setCellValue('E'.$int, $row2['InteCareAgencyID'])
				->setCellValue('F'.$int, $row2['LocationCode'])
				->setCellValue('G'.$int, $row2['SalariesWages'])
				->setCellValue('H'.$int, $row2['PayrollTaxFICA'])
				->setCellValue('I'.$int, $row2['OtherFringe'])
				->setCellValue('J'.$int, $row2['DuesFees'])
				->setCellValue('K'.$int, $row2['TravelTraining'])
				->setCellValue('L'.$int, $row2['MaterialsSupplies'])
				->setCellValue('M'.$int, $row2['PurchasedServices'])
				->setCellValue('N'.$int, $row2['OtherExpenses'])
				->setCellValue('O'.$int, $row2['DSSSalariesWages'])
				->setCellValue('P'.$int, $row2['DSSFringeBenefits']);
		        break;	
		    case "4": // DW-RN
		        $excel2->setActiveSheetIndex(4);
				$excel2->getActiveSheet()->setCellValue('B'.$int, $row2['LastName'])
				->setCellValue('C'.$int, $row2['FirstName'])
				->setCellValue('D'.$int, $row2['PositionTitle'])
				->setCellValue('E'.$int, $row2['InteCareAgencyID'])
				->setCellValue('F'.$int, $row2['LocationCode'])
				->setCellValue('G'.$int, $row2['SalariesWages'])
				->setCellValue('H'.$int, $row2['PayrollTaxFICA'])
				->setCellValue('I'.$int, $row2['OtherFringe'])
				->setCellValue('J'.$int, $row2['DuesFees'])
				->setCellValue('K'.$int, $row2['TravelTraining'])
				->setCellValue('L'.$int, $row2['MaterialsSupplies'])
				->setCellValue('M'.$int, $row2['PurchasedServices'])
				->setCellValue('N'.$int, $row2['OtherExpenses'])
				->setCellValue('O'.$int, $row2['DSSSalariesWages'])
				->setCellValue('P'.$int, $row2['DSSFringeBenefits']);
		        break;	
		    case "5": // DW-MD
		        $excel2->setActiveSheetIndex(5);
				$excel2->getActiveSheet()->setCellValue('B'.$int, $row2['LastName'])
				->setCellValue('C'.$int, $row2['FirstName'])
				->setCellValue('D'.$int, $row2['PositionTitle'])
				->setCellValue('E'.$int, $row2['InteCareAgencyID'])
				->setCellValue('F'.$int, $row2['LocationCode'])
				->setCellValue('G'.$int, $row2['SalariesWages'])
				->setCellValue('H'.$int, $row2['PayrollTaxFICA'])
				->setCellValue('I'.$int, $row2['OtherFringe'])
				->setCellValue('J'.$int, $row2['DuesFees'])
				->setCellValue('K'.$int, $row2['TravelTraining'])
				->setCellValue('L'.$int, $row2['MaterialsSupplies'])
				->setCellValue('M'.$int, $row2['PurchasedServices'])
				->setCellValue('N'.$int, $row2['OtherExpenses'])
				->setCellValue('O'.$int, $row2['DSSSalariesWages'])
				->setCellValue('P'.$int, $row2['DSSFringeBenefits']);
		        break;		
		    case "6": // DW-PGSP
		        $excel2->setActiveSheetIndex(6);
				$excel2->getActiveSheet()->setCellValue('B'.$int, $row2['LastName'])
				->setCellValue('C'.$int, $row2['FirstName'])
				->setCellValue('D'.$int, $row2['PositionTitle'])
				->setCellValue('E'.$int, $row2['InteCareAgencyID'])
				->setCellValue('F'.$int, $row2['LocationCode'])
				->setCellValue('G'.$int, $row2['SalariesWages'])
				->setCellValue('H'.$int, $row2['PayrollTaxFICA'])
				->setCellValue('I'.$int, $row2['OtherFringe'])
				->setCellValue('J'.$int, $row2['DuesFees'])
				->setCellValue('K'.$int, $row2['TravelTraining'])
				->setCellValue('L'.$int, $row2['MaterialsSupplies'])
				->setCellValue('M'.$int, $row2['PurchasedServices'])
				->setCellValue('N'.$int, $row2['OtherExpenses'])
				->setCellValue('O'.$int, $row2['DSSSalariesWages'])
				->setCellValue('P'.$int, $row2['DSSFringeBenefits']);
		        break;		
		    case "7": // DW-PSY
		        $excel2->setActiveSheetIndex(7);
				$excel2->getActiveSheet()->setCellValue('B'.$int, $row2['LastName'])
				->setCellValue('C'.$int, $row2['FirstName'])
				->setCellValue('D'.$int, $row2['PositionTitle'])
				->setCellValue('E'.$int, $row2['InteCareAgencyID'])
				->setCellValue('F'.$int, $row2['LocationCode'])
				->setCellValue('G'.$int, $row2['SalariesWages'])
				->setCellValue('H'.$int, $row2['PayrollTaxFICA'])
				->setCellValue('I'.$int, $row2['OtherFringe'])
				->setCellValue('J'.$int, $row2['DuesFees'])
				->setCellValue('K'.$int, $row2['TravelTraining'])
				->setCellValue('L'.$int, $row2['MaterialsSupplies'])
				->setCellValue('M'.$int, $row2['PurchasedServices'])
				->setCellValue('N'.$int, $row2['OtherExpenses'])
				->setCellValue('O'.$int, $row2['DSSSalariesWages'])
				->setCellValue('P'.$int, $row2['DSSFringeBenefits']);
		        break;	
		    case "8": // DW-SW BS
		        $excel2->setActiveSheetIndex(8);
				$excel2->getActiveSheet()->setCellValue('B'.$int, $row2['LastName'])
				->setCellValue('C'.$int, $row2['FirstName'])
				->setCellValue('D'.$int, $row2['PositionTitle'])
				->setCellValue('E'.$int, $row2['InteCareAgencyID'])
				->setCellValue('F'.$int, $row2['LocationCode'])
				->setCellValue('G'.$int, $row2['SalariesWages'])
				->setCellValue('H'.$int, $row2['PayrollTaxFICA'])
				->setCellValue('I'.$int, $row2['OtherFringe'])
				->setCellValue('J'.$int, $row2['DuesFees'])
				->setCellValue('K'.$int, $row2['TravelTraining'])
				->setCellValue('L'.$int, $row2['MaterialsSupplies'])
				->setCellValue('M'.$int, $row2['PurchasedServices'])
				->setCellValue('N'.$int, $row2['OtherExpenses'])
				->setCellValue('O'.$int, $row2['DSSSalariesWages'])
				->setCellValue('P'.$int, $row2['DSSFringeBenefits']);
		        break;	
		    case "9": // DW-SW MSW
		        $excel2->setActiveSheetIndex(9);
				$excel2->getActiveSheet()->setCellValue('B'.$int, $row2['LastName'])
				->setCellValue('C'.$int, $row2['FirstName'])
				->setCellValue('D'.$int, $row2['PositionTitle'])
				->setCellValue('E'.$int, $row2['InteCareAgencyID'])
				->setCellValue('F'.$int, $row2['LocationCode'])
				->setCellValue('G'.$int, $row2['SalariesWages'])
				->setCellValue('H'.$int, $row2['PayrollTaxFICA'])
				->setCellValue('I'.$int, $row2['OtherFringe'])
				->setCellValue('J'.$int, $row2['DuesFees'])
				->setCellValue('K'.$int, $row2['TravelTraining'])
				->setCellValue('L'.$int, $row2['MaterialsSupplies'])
				->setCellValue('M'.$int, $row2['PurchasedServices'])
				->setCellValue('N'.$int, $row2['OtherExpenses'])
				->setCellValue('O'.$int, $row2['DSSSalariesWages'])
				->setCellValue('P'.$int, $row2['DSSFringeBenefits']);
		        break;	
		    case "10": // DW-SS
		        $excel2->setActiveSheetIndex(10);               
				$excel2->getActiveSheet()->setCellValue('B'.$int, $row2['LastName'])
				->setCellValue('C'.$int, $row2['FirstName'])
				->setCellValue('D'.$int, $row2['PositionTitle'])
				->setCellValue('E'.$int, $row2['InteCareAgencyID'])
				->setCellValue('F'.$int, $row2['LocationCode'])
				->setCellValue('G'.$int, $row2['SalariesWages'])
				->setCellValue('H'.$int, $row2['PayrollTaxFICA'])
				->setCellValue('I'.$int, $row2['OtherFringe'])
				->setCellValue('J'.$int, $row2['DuesFees'])
				->setCellValue('K'.$int, $row2['TravelTraining'])
				->setCellValue('L'.$int, $row2['MaterialsSupplies'])
				->setCellValue('M'.$int, $row2['PurchasedServices'])
				->setCellValue('N'.$int, $row2['OtherExpenses'])
				->setCellValue('O'.$int, $row2['DSSSalariesWages'])
				->setCellValue('P'.$int, $row2['DSSFringeBenefits']);
                          
                                
		        break;		
		    case "11": // DW-TCM
		        $excel2->setActiveSheetIndex(11);
				$excel2->getActiveSheet()->setCellValue('B'.$int, $row2['LastName'])
				->setCellValue('C'.$int, $row2['FirstName'])
				->setCellValue('D'.$int, $row2['PositionTitle'])
				->setCellValue('E'.$int, $row2['InteCareAgencyID'])
				->setCellValue('F'.$int, $row2['LocationCode'])
				->setCellValue('G'.$int, $row2['SalariesWages'])
				->setCellValue('H'.$int, $row2['PayrollTaxFICA'])
				->setCellValue('I'.$int, $row2['OtherFringe'])
				->setCellValue('J'.$int, $row2['DuesFees'])
				->setCellValue('K'.$int, $row2['TravelTraining'])
				->setCellValue('L'.$int, $row2['MaterialsSupplies'])
				->setCellValue('M'.$int, $row2['PurchasedServices'])
				->setCellValue('N'.$int, $row2['OtherExpenses'])
				->setCellValue('O'.$int, $row2['DSSSalariesWages'])
				->setCellValue('P'.$int, $row2['DSSFringeBenefits']);
		        break;		
		    case "12": // DW-TP
		        $excel2->setActiveSheetIndex(12);
				$excel2->getActiveSheet()->setCellValue('B'.$int, $row2['LastName'])
				->setCellValue('C'.$int, $row2['FirstName'])
				->setCellValue('D'.$int, $row2['PositionTitle'])
				->setCellValue('E'.$int, $row2['InteCareAgencyID'])
				->setCellValue('F'.$int, $row2['LocationCode'])
				->setCellValue('G'.$int, $row2['SalariesWages'])
				->setCellValue('H'.$int, $row2['PayrollTaxFICA'])
				->setCellValue('I'.$int, $row2['OtherFringe'])
				->setCellValue('J'.$int, $row2['DuesFees'])
				->setCellValue('K'.$int, $row2['TravelTraining'])
				->setCellValue('L'.$int, $row2['MaterialsSupplies'])
				->setCellValue('M'.$int, $row2['PurchasedServices'])
				->setCellValue('N'.$int, $row2['OtherExpenses'])
				->setCellValue('O'.$int, $row2['DSSSalariesWages'])
				->setCellValue('P'.$int, $row2['DSSFringeBenefits']);
		        break;		
		    case "13": // DW-UD
		        $excel2->setActiveSheetIndex(13);
				$excel2->getActiveSheet()->setCellValue('B'.$int, $row2['LastName'])
				->setCellValue('C'.$int, $row2['FirstName'])
				->setCellValue('D'.$int, $row2['PositionTitle'])
				->setCellValue('E'.$int, $row2['InteCareAgencyID'])
				->setCellValue('F'.$int, $row2['LocationCode'])
				->setCellValue('G'.$int, $row2['SalariesWages'])
				->setCellValue('H'.$int, $row2['PayrollTaxFICA'])
				->setCellValue('I'.$int, $row2['OtherFringe'])
				->setCellValue('J'.$int, $row2['DuesFees'])
				->setCellValue('K'.$int, $row2['TravelTraining'])
				->setCellValue('L'.$int, $row2['MaterialsSupplies'])
				->setCellValue('M'.$int, $row2['PurchasedServices'])
				->setCellValue('N'.$int, $row2['OtherExpenses'])
				->setCellValue('O'.$int, $row2['DSSSalariesWages'])
				->setCellValue('P'.$int, $row2['DSSFringeBenefits']);
		        break;			        	        
		        		        		        		        		        			        			        		      		        	        
		}	
		
		$int = $int  + 1;	
	}
}

//$result1 = GetRosterPositions($_SESSION['agencyid']);
//$int1 = 2;
//while ($row1 = $result1->fetch_assoc()) 
//{
//	
//    
//    $excel2->setActiveSheetIndex(17);
//            $excel2->getActiveSheet()->setCellValue('A'.$int1, $row1['positionName'])
//            ->setCellValue('B'.$int1, GetActiveCount($row1['PositionID'], $_SESSION['agencyid'], $_POST['period']))
//            ->setCellValue('C'.$int1, GetInactiveCount($row1['PositionID'], $_SESSION['agencyid'], $_POST['period']));
//            
//   $int1 = $int1  + 1;
//        
//}
//
//
//$int2 = 2;
// 
//$excel2->setActiveSheetIndex(18);
//$excel2->getActiveSheet()->setCellValue('A'.$int2, GetGAActiveCount($_SESSION['agencyid']))
//->setCellValue('B'.$int2, GetGAInactiveCount($_SESSION['agencyid']));
            


$objWriter = PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');
//$objWriter->setPreCalculateFormulas(true);
$objWriter->save($Export_DIR_ . $_SESSION['agency'] . ' ' . $_SESSION['period'] . '.xlsx');
// PHPExcel CODE

// download from server
Header("Content-type: application/xls"); 
Header("Content-Disposition: attachment; filename=" . $_SESSION['agency'] . ' ' . $_SESSION['period'] . '.xlsx'); 
readfile($Export_DIR_ . $_SESSION['agency'] . ' ' . $_SESSION['period'] . '.xlsx');


?>