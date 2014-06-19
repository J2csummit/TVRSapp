<?php
	session_start();
	if(($_SESSION['valid']) == false || (!isset($_SESSION['valid']))) {
		header('Location: admin.php');
	}

	/** Include PHPExcel */
	require_once 'Classes/PHPExcel.php';

	//credentials
	include("tvrs_config.php");

	//connect to db
	$dbc = mysqli_connect (
		$db_host,
		$db_user,
		$db_password,
		$db_name)
	OR die (
		'Could not connect to MySQL: ' . mysqli_connect_error());

	// Create your database query
	$query = "SELECT * FROM dosage";  

	// Execute the database query
	$result = mysqli_query($dbc, $query) or die('Query failed: ' . mysqli_error($dbc));

	// Instantiate a new PHPExcel object
	$objPHPExcel = new PHPExcel(); 
	// Set the active Excel worksheet to sheet 0
	$objPHPExcel->setActiveSheetIndex(0); 
	//Write labels
	$objPHPExcel->getActiveSheet()->SetCellValue('A1','Client Name'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('B1','Provider Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1','Service Rendered'); 
    $objPHPExcel->getActiveSheet()->SetCellValue('D1','Receiver');
    $objPHPExcel->getActiveSheet()->SetCellValue('E1','Elapsed Time'); 
    $objPHPExcel->getActiveSheet()->SetCellValue('F1','Method'); 
    $objPHPExcel->getActiveSheet()->SetCellValue('G1','Activity Date/Time');
    $objPHPExcel->getActiveSheet()->SetCellValue('H1','Entry #'); 
	// Initialise the Excel row number
	$rowCount = 2; 
	// Iterate through each result from the SQL query in turn
	// We fetch each database result row into $row in turn
	while($row = mysqli_fetch_array($result)){ 
	    // Set cell An to the "clientName" column from the database
	    //    where n is the Excel row number (ie cell A1 in the first row)
	    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['clientName']); 
	    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['providerName']);
	    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['services']); 
	    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['receiver']);
	    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['elapsedTime']); 
	    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row['method']); 
	    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row['activity_date']);
	    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row['entry_id']);   

	    // Increment the Excel row counter
	    $rowCount++; 
	} 
	foreach(range('A','H') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	}

	// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
	// Write the Excel file to filename TVRS_(date).xlsx in the current directory
	$fileName = 'TVRS_'.date("m-j-y").'.xlsx';
	$objWriter->save("outFile.xlsx"); 

	header('Content-disposition: attachment; filename='.$fileName);
	header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Length: ' . filesize('outFile.xlsx'));
	header('Content-Transfer-Encoding: binary');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	ob_clean();
	flush(); 
	readfile('outFile.xlsx');	
?>