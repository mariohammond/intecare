<?php
session_start();

//$DIR_ = $_SERVER["DOCUMENT_ROOT"]. "/";
//$Export_DIR_ = $_SERVER["DOCUMENT_ROOT"]. "/exports/";

//require($DIR_. "config1.php");
//require('./tools/config1.php');

include '../../includes/db.inc.php';
//include './tools/config1.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id = $_POST['agency'];
$sqlA = "SELECT `AgencyName` FROM `agencies` WHERE `AgencyId` = '" . $id . "'";
$resultA = $conn->query($sqlA);
$name = mysqli_fetch_row($resultA);
$conn->close();

$_SESSION['agency'] = $name;
$_SESSION['agencyid'] = $id;

// PHPExcel CODE
date_default_timezone_set('Europe/London');
require('./phpExcel/Classes/PHPExcel/IOFactory.php');
require('./phpExcel/Classes/PHPExcel.php');

$excel2 = PHPExcel_IOFactory::createReader('Excel2007');
$excel2 = $excel2->load('./CostReportTemplate.xlsx');

//$result = GetPositions($_SESSION['agencyid'], $_POST['period']);
$sqlB = "SELECT count(a.PositionTitle) as `cnt`, a.PositionTitle, b.positionName FROM `agency_data` a
        INNER JOIN `positions` b ON b.positionId = a.PositionTitle WHERE a.InteCareAgencyID = " . $_SESSION['agencyid'] . " AND a.Period = '" . $_POST['period'] . "'
        GROUP BY a.PositionTitle";

$result = $conn->query($sqlB);
$conn->close();

while ($row = $result->fetch_assoc())
{
    //$result2 = GetEmployeesForExport($row['PositionTitle'], $_SESSION['agencyid'], $_POST['period']);
    $sqlC = "SELECT DISTINCT a.LastName, a.FirstName, a.PositionID, b.* FROM `agency_employees` a LEFT JOIN `agency_data` b on b.IdNumber = a.IdNumber
	WHERE a.Active = 1 AND a.PositionID = '" . $_SESSION['agencyid'] . "' AND a.InteCareAgencyID = '" . $_SESSION['agency'] . "' ORDER BY a.LastName, a.FirstName";
    $result2 = $conn->query($sqlC);
    $conn->close();

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


/*$objWriter = PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');
$objWriter->save($Export_DIR_ . $_SESSION['agency'] . ' ' . $_POST['period'] . '.xlsx');

Header("Content-type: application/xls");
Header("Content-Disposition: attachment; filename=" . $_SESSION['agency'] . ' ' . $_POST['period'] . '.xlsx');
readfile($Export_DIR_ . $_SESSION['agency'] . ' ' . $_POST['period'] . '.xlsx');*/


?>