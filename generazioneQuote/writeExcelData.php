<?php
require_once '../PHPExcel/Classes/PHPExcel.php';
include '../config.php';

function getMedia($studente, $materia, $data, $conn){
	$sql = 'SELECT Avg([value]) AS media FROM risultati WHERE chiave Like "'.$materia.'_*_'.$studente.'" AND SUBSTRING(chiave, INSTR(chiave, "_")+1, 8) <= "'.date('Ymd', strtotime($data)).'"';

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

	$sql = 'INSERT INTO disponibili (dal, al, chiave) VALUES ("'.date('Y-m-d', strtotime('-10 day', strtotime($data))).'", "'.$data.'", "'.$materia.'_'.date('Ymd', strtotime($data)).'")';

	foreach (STUDENTI as $value) {
		$excel->setActiveSheetIndex(0)
		->setCellValue('A2', $materia)
		->setCellValue('B2', $value)
		->setCellValue('C2', getMedia($value, $materia, $data, $conn))
		->setCellValue('D2', $data);

		$key = $materia.'_'.date('Ymd', strtotime($data)).'_'.$value;

		$result = mysqli_query($conn, $sql);

		$students = array();

	    //lettura voti esatti
		$EXACT = array();
		$EXACT_values = array("10","9.5","9","8.5","8","7.5","7","6.5","6","5.5","5","4.5","4","3.5","3","2","1");
		for ($ex = 6; $ex<=22; $ex++) {
			$EXACT_single = $excel->setActiveSheetIndex(0)->getCell('A'.$ex)->getCalculatedValue();
			$EXACT[$EXACT_values[$ex-6]] = $EXACT_single;
		}
		$students['Esatto'] = $EXACT;

	    //lettura under
		$UNDER = array();
		$UNDER_values = array("10","9.75","9.25","8.75","8.25","7.75","7.25","6.75","6.25","5.75","5.25","4.75","4.25","3.75","3.25","2");
		for ($ex = 6; $ex<=22; $ex++) {
			$UNDER_single = $excel->setActiveSheetIndex(0)->getCell('D'.$ex)->getCalculatedValue();
			$UNDER[$UNDER_values[$ex-6]] = $UNDER_single;
		}
		$students['Under'] = $UNDER;

	    //lettura over
		$OVER = array();
		$OVER_values = array("9.25","8.75","8.25","7.75","7.25","6.75","6.25","5.75","5.25","4.75","4.25","3.75","3.25","2");
		for ($ex = 6; $ex<=22; $ex++) {
			$OVER_single = $excel->setActiveSheetIndex(0)->getCell('D'.$ex)->getCalculatedValue();
			$OVER[$OVER_values[$ex-6]] = $OVER_single;
		}
		$students['Over'] = $OVER;
		
		mysqli_close($conn);

		$objWriter = PHPExcel_IOFactory::createWriter($excel, "Excel2007");
		$objWriter->save('Quoting.xlsx');

		$json[$value] = $students;

	}

	$fp = fopen('../avvenimenti/'.$materia.'_'.date('Ymd', strtotime($data)).'.json', 'w');
	fwrite($fp, json_encode($json));
	fclose($fp);
}

	//PROVA di esecuzione
	newScommessa($_POST["data"], $_POST["materia"]);

?>
