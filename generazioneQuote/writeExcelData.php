<?php
	require_once '../PHPExcel/Classes/PHPExcel.php';
	include '../config.php';

	function getMedia($studente, $materia, $conn){
		$sql = 'SELECT Avg([value]) AS media FROM risultati WHERE chiave Like "'.$materia.'_*_'.$studente.'"';
		$result = mysqli_query($conn, $sql);
		$v = 6.7;
		while($row = mysqli_fetch_assoc($result)){
			$v = $row['media'];
		}
		return $v;
	}

	function newScommessa($data, $materia){
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

		$objReader = PHPExcel_IOFactory::createReader("Excel2007");
		$excel = $objReader->load('Quoting.xlsx');
		
		$json = array();

		foreach (STUDENTI as $value) {
			$excel->setActiveSheetIndex(0)
	            ->setCellValue('A2', $materia)
	            ->setCellValue('B2', $value)
	            ->setCellValue('C2', getMedia($value, $materia, $conn))
	            ->setCellValue('D2', $data);


	        $key = $materia.'_'.date('Ymd', strtotime($data)).'_'.$value;

	        $sql = 'INSERT INTO disponibili (dal, al, chiave) VALUES ("'.date('Y-m-d', strtotime('-10 day', strtotime($data))).'", "'.$data.'", "'.$key.'")';

	        $result = mysqli_query($conn, $sql);

	        $students = array();

	        //lettura voti esatti
	        $EXACT = array();
	        $EXACT_values = array("10","9.5","9","8.5","8","7.5","7","6.5","6","5.5","5","4.5","4","3.5","3","2","1");
	        	for ($ex = 6; $ex<=22; $ex++) {
	        		$EXACT_single = $excel->setActiveSheetIndex(0)->getCell('A'.$ex)->getCalculatedValue();
	        		$EXACT[$EXACT_values[$ex-6]] = $EXACT_single;
	        	}
	        var_dump($EXACT);
	        $students['Esatto'] = $EXACT;
		        

	        //$EXACT = array($EXACT10,$EXACT9h,$EXACT9,$EXACT8h,$EXACT8,$EXACT7h,$EXACT7,$EXACT6h,$EXACT6,$EXACT5h,$EXACT5,$EXACT4h,$EXACT4,$EXACT3h,$EXACT3,$EXACT2,$EXACT1);
	        
	        
	        //lettura under
		        $UNDER10 = $excel->setActiveSheetIndex(0)->getCell('D6')->getCalculatedValue();
		        $UNDER975 = $excel->setActiveSheetIndex(0)->getCell('D7')->getCalculatedValue();
		        $UNDER925 = $excel->setActiveSheetIndex(0)->getCell('D8')->getCalculatedValue();
		        $UNDER875 = $excel->setActiveSheetIndex(0)->getCell('D9')->getCalculatedValue();
		        $UNDER825 = $excel->setActiveSheetIndex(0)->getCell('D10')->getCalculatedValue();
		        $UNDER775 = $excel->setActiveSheetIndex(0)->getCell('D11')->getCalculatedValue();
		        $UNDER725 = $excel->setActiveSheetIndex(0)->getCell('D11')->getCalculatedValue();
		        $UNDER675 = $excel->setActiveSheetIndex(0)->getCell('D12')->getCalculatedValue();
		        $UNDER625 = $excel->setActiveSheetIndex(0)->getCell('D13')->getCalculatedValue();
		        $UNDER575 = $excel->setActiveSheetIndex(0)->getCell('D14')->getCalculatedValue();
		        $UNDER525 = $excel->setActiveSheetIndex(0)->getCell('D15')->getCalculatedValue();
		        $UNDER475 = $excel->setActiveSheetIndex(0)->getCell('D16')->getCalculatedValue();
		        $UNDER425 = $excel->setActiveSheetIndex(0)->getCell('D17')->getCalculatedValue();
		        $UNDER375 = $excel->setActiveSheetIndex(0)->getCell('D18')->getCalculatedValue();
		        $UNDER325 = $excel->setActiveSheetIndex(0)->getCell('D19')->getCalculatedValue();
		        $UNDER3 = $excel->setActiveSheetIndex(0)->getCell('D20')->getCalculatedValue();
		        $UNDER2 = $excel->setActiveSheetIndex(0)->getCell('D21')->getCalculatedValue();

		    $UNDER = array($UNDER10,$UNDER975,$UNDER925,$UNDER875,$UNDER825,$UNDER775,$UNDER725,$UNDER675,$UNDER625,$UNDER575,$UNDER525,$UNDER475,$UNDER425,$UNDER375,$UNDER325,$UNDER3,$UNDER2);

	        //lettura over
		        $OVER925 = $excel->setActiveSheetIndex(0)->getCell('E8')->getCalculatedValue();
		        $OVER875 = $excel->setActiveSheetIndex(0)->getCell('E9')->getCalculatedValue();
		        $OVER825 = $excel->setActiveSheetIndex(0)->getCell('E10')->getCalculatedValue();
		        $OVER775 = $excel->setActiveSheetIndex(0)->getCell('E11')->getCalculatedValue();
		        $OVER725 = $excel->setActiveSheetIndex(0)->getCell('E12')->getCalculatedValue();
		        $OVER675 = $excel->setActiveSheetIndex(0)->getCell('E13')->getCalculatedValue();
		        $OVER625 = $excel->setActiveSheetIndex(0)->getCell('E14')->getCalculatedValue();
		        $OVER575 = $excel->setActiveSheetIndex(0)->getCell('E15')->getCalculatedValue();
		        $OVER525 = $excel->setActiveSheetIndex(0)->getCell('E16')->getCalculatedValue();
		        $OVER475 = $excel->setActiveSheetIndex(0)->getCell('E17')->getCalculatedValue();
		        $OVER425 = $excel->setActiveSheetIndex(0)->getCell('E18')->getCalculatedValue();
		        $OVER375 = $excel->setActiveSheetIndex(0)->getCell('E19')->getCalculatedValue();
		        $OVER325 = $excel->setActiveSheetIndex(0)->getCell('E20')->getCalculatedValue();
		        $OVER3 = $excel->setActiveSheetIndex(0)->getCell('E21')->getCalculatedValue();
		        $OVER2 = $excel->setActiveSheetIndex(0)->getCell('E22')->getCalculatedValue();

		    $OVER = array($OVER925,$OVER875,$OVER825,$OVER775,$OVER725,$OVER675,$OVER625,$OVER575,$OVER525,$OVER475,$OVER425,$OVER375,$OVER325,$OVER3,$OVER2);
		    $Ovalues = array("9.25","8.75","8.25","7.75","7.25","6.75","6.25","5.75","5.25","4.75","4.25","3.75","3.25","2");
		    $Uvalues = array("10","9.75","9.25","8.75","8.25","7.75","7.25","6.75","6.25","5.75","5.25","4.75","4.25","3.75","3.25","2");

		    /*push nel database
		    for ($k=0; $k<sizeof($EXACT); $k++) {
		    	$sql = 'INSERT INTO quote (chiave, type, value, quota) VALUES ("'.$key.'", "ESATTO", "'.$EXACT_values[$k].'", '.$EXACT[$k].')';
		    	$result = mysqli_query($conn, $sql);
		   	}

		   	for ($g=0; $g<sizeof($Uvalues); $g++){
		   		$sql = 'INSERT INTO quote (chiave, type, value, quota) VALUES ("'.$key.'", "UNDER", "'.$Uvalues[$g].'", '.$UNDER[$g].')';
		   		$result = mysqli_query($conn, $sql);
		   	}

		   	for ($r=0; $r<sizeof($Ovalues); $r++){
				$sql = 'INSERT INTO quote (chiave, type, value, quota) VALUES ("'.$key.'", "OVER", "'.$Ovalues[$r].'", '.$OVER[$r].')';
				$result = mysqli_query($conn, $sql);
			}
			*/
		
		mysqli_close($conn);

		$objWriter = PHPExcel_IOFactory::createWriter($excel, "Excel2007");
		$objWriter->save('Quoting.xlsx');

		$json[$value] = $students;

	}

var_dump($json);


	//PROVA di esecuzione
	newScommessa("2018-10-01");


	

	
?>
