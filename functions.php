<?php
/*
	checkAndPayBet
	[x] Data: 10 ott 2018
	[x] Descrizione: La funzione calcola la vincita per ogni scommessa e in caso di vincita accredita denaro sul conto dell'utente. Per ogni modalita' di gioco (UNDER, OVER, ecc.) la funzione computa un procedimento da effettuare al fine di registrare la scommessa nel database considerandola pagata se la vincita non sia "null".
	[x] Parametri IN: nessuno
	[x] Ritorna: /
	[x] Changelog: v1.0
	[x] Ultima modifica: creazione
*/
function checkAndPayBet(){
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	$sql = "SELECT * FROM scommesse WHERE pagata = 0";
	$result = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_assoc($result)){
		$vin = 1;
		$ssql = "SELECT multiple.*, risultati.value AS ris FROM multiple LEFT JOIN risultati ON risultati.chiave = multiple.chiave WHERE multiple.idScommessa = '".$row['id']."'";
		$sresult = mysqli_query($conn, $ssql);
		while(($srow = mysqli_fetch_assoc($sresult)) && $vin != 0){
			if(isset($srow['ris'])){
				switch($srow['type']){
					case "ESATTO":
					if($srow['value'] == $srow['ris']){
						$vin = $vin*$srow['quote'];
					}else{
						$vin = 0;
					}
					break;
					case "UNDER":
					if(floatval($srow['value']) < floatval($srow['ris'])){
						$vin = $vin*$srow['quote'];
					}else{
						$vin = 0;
					}
					break;
					case "OVER":
					if(floatval($srow['value']) > floatval($srow['ris'])){
						$vin = $vin*$srow['quote'];
					}else{
						$vin = 0;
					}
					break;
					default:
					$vin = 0;
					break;
				}
			}else{
				$vin = null;
			}
		}
		if($vin != null){
			$vin = $vin*$row['coin'];
			$ssql = "UPDATE utenti SET coin = coin + ".$vin." WHERE id = ".$row['idUtente'];
			$sresult = mysqli_query($conn, $ssql);
			$ssql = "UPDATE scommesse SET pagata = 1 WHERE id = ".$row['id'];
			$sresult = mysqli_query($conn, $ssql);
		}
	}
}

/*
	cmp
	[x] Data: 10 ott 2018
	[x] Descrizione: Compara il valore del primo con il valore del secondo.
	[x] Parametri IN: due array associativi $a e $b.
	[x] Ritorna: 1 o -1
	[x] Changelog: v1.0
	[x] Ultima modifica: creazione
*/
function cmp($a, $b){
	foreach($a as $akey => $avalue){
		foreach($b as $bkey => $bvalue){
			return ($avalue < $bvalue) ? 1 : -1;
		}
	}
	return 0;
}

/*
	getWinsWeek
	[x] Data: 10 ott 2018
	[x] Descrizione: La funzione preleva dal database, separandosi tra le varie modalita' di gioco, tutte le vincite dell'ultima settimana, e le inserisce in un array.
	[x] Parametri IN: nessuno
	[x] Ritorna: Array di vincite.
	[x] Changelog: v1.0
	[x] Ultima modifica: creazione
*/
function getWinsWeek() {
	checkAndPayBet();
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	$sql = "SELECT scommesse.*, utenti.username FROM scommesse  INNER JOIN utenti ON utenti.id = scommesse.idUtente WHERE scommesse.data >= '".date("Y-m-d", strtotime(date("Y-m-d")."-7day"))."' AND scommesse.pagata = 1";
	$result = mysqli_query($conn, $sql);
	$winner_s = array();
	while($row = mysqli_fetch_assoc($result)){
		$ut = $row['username'];
		$vin = 1;
		$ssql = "SELECT multiple.*, risultati.value AS ris FROM multiple LEFT JOIN risultati ON risultati.chiave = multiple.chiave WHERE multiple.idScommessa = '".$row['id']."'";
		$sresult = mysqli_query($conn, $ssql);
		while(($srow = mysqli_fetch_assoc($sresult)) && $vin != 0){
			if(isset($srow['ris'])){
				switch($srow['type']){
					case "ESATTO":
					if($srow['value'] == $srow['ris']){
						$vin = $vin*$srow['quote'];
					}else{
						$vin = 0;
					}
					break;
					case "UNDER":
					if(floatval($srow['value']) < floatval($srow['ris'])){
						$vin = $vin*$srow['quote'];
					}else{
						$vin = 0;
					}
					break;
					case "OVER":
					if(floatval($srow['value']) > floatval($srow['ris'])){
						$vin = $vin*$srow['quote'];
					}else{
						$vin = 0;
					}
					break;
					default:
					$vin = 0;
					break;
				}
			}else{
				$vin = 0;
			}
		}
		$vin = $vin*$row['coin'];
		if($vin > 0){
			array_push($winner_s, array($ut => $vin));
			usort($winner_s, "cmp");
		}
	}
	return $winner_s;
}

/*
	getWinsMonth
	[x] Data: 10 ott 2018
	[x] Descrizione: La funzione preleva dal database, separandosi tra le varie modalita' di gioco, tutte le vincite degli ultimi 30 giorni, e le inserisce in un array.
	[x] Parametri IN: nessuno
	[x] Ritorna: Array di vincite.
	[x] Changelog: v1.0
	[x] Ultima modifica: creazione
*/
function getWinsMonth(){
	checkAndPayBet();
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	$sql = "SELECT scommesse.*, utenti.username FROM scommesse  INNER JOIN utenti ON utenti.id = scommesse.idUtente WHERE scommesse.data >= '".date("Y-m-d", strtotime(date("Y-m-d")."-30day"))."'  AND scommesse.pagata = 1";
	$result = mysqli_query($conn, $sql);
	$winner_m = array();
	while($row = mysqli_fetch_assoc($result)){
		$ut = $row['username'];
		$vin = 1;
		$ssql = "SELECT multiple.*, risultati.value AS ris FROM multiple LEFT JOIN risultati ON risultati.chiave = multiple.chiave WHERE multiple.idScommessa = '".$row['id']."'";
		$sresult = mysqli_query($conn, $ssql);
		while(($srow = mysqli_fetch_assoc($sresult)) && $vin != 0){
			if(isset($srow['ris'])){
				switch($srow['type']){
					case "ESATTO":
					if($srow['value'] == $srow['ris']){
						$vin = $vin*$srow['quote'];
					}else{
						$vin = 0;
					}
					break;
					case "UNDER":
					if(floatval($srow['value']) < floatval($srow['ris'])){
						$vin = $vin*$srow['quote'];
					}else{
						$vin = 0;
					}
					break;
					case "OVER":
					if(floatval($srow['value']) > floatval($srow['ris'])){
						$vin = $vin*$srow['quote'];
					}else{
						$vin = 0;
					}
					break;
					default:
					$vin = 0;
					break;
				}
			}else{
				$vin = 0;
			}
		}
		$vin = $vin*$row['coin'];
		if($vin > 0){
			array_push($winner_m, array($ut => $vin));
			usort($winner_m, "cmp");
		}
	}

	return $winner_m;
}

/*
	getVerificheDisponibili
	[x] Data: 10 ott 2018
	[x] Descrizione: La funzione preleva dal database tutti gli esiti sui quali si puo' scommettere per mezzo di un filtro generato da un intervallo di date.
	[x] Parametri IN: nessuno
	[x] Ritorna: Array di esiti.
	[x] Changelog: v1.0
	[x] Ultima modifica: creazione
*/
function getVerificheDisponibili(){
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	$sql = "SELECT * FROM disponibili WHERE dal <= '".date("Y-m-d")."' AND al >= '".date("Y-m-d")."'";
	$result = mysqli_query($conn, $sql);
	$verifiche = array();
	while($row = mysqli_fetch_assoc($result)){
		array_push($verifiche, $row);
	}
	mysqli_close($conn);
	return $verifiche;
}

/*
	getMedia
	[x] Data: 10 ott 2018
	[x] Descrizione: La funzione calcola autonomamente la media di uno studente dato. Qualora non fossero presenti dati a sufficienza impostera' come valore di default 6,7.
	[x] Parametri IN: string(studente), string(materia), string(data), oggetto di connessione.
	[x] Ritorna: Media delle valutazioni.
	[x] Changelog: v1.0
	[x] Ultima modifica: creazione
*/
function getMedia($studente, $materia, $data, $conn){
	$sql = 'SELECT Avg([value]) AS media FROM risultati WHERE chiave Like "'.$materia.'_*_'.$studente.'" AND SUBSTRING(chiave, INSTR(chiave, "_")+1, 8) <= "'.date('Ymd', strtotime($data)).'"';

	$result = mysqli_query($conn, $sql);
	$v = 6.7;
	while($row = mysqli_fetch_assoc($result)){
		$v = $row['media'];
	}
	return $v;
}

/*
	newScommessa
	[x] Data: 10 ott 2018
	[x] Descrizione: La funzione calcola per mezzo di un foglio excel le quote per ogni avvenimento e le inserisce in un file JSON. Questo file sara' nominato come 'materia_data'. Una volta fatto cio' inserira' l'esito sul quale si potra' scommettere nell'apposita tabella 'disponibili' del database.
	[x] Parametri IN: string(data), string(materia)
	[x] Ritorna: /
	[x] Changelog: v1.0
	[x] Ultima modifica: creazione
*/
function newScommessa($data, $materia){
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

	$objReader = PHPExcel_IOFactory::createReader("Excel2007");
	$excel = $objReader->load('../generazioneQuote/Quoting.xlsx');
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
			$EXACT_single = $excel->setActiveSheetIndex(0)->getCell('A'.$ex)->getOldCalculatedValue();
			$EXACT[$EXACT_values[$ex-6]] = $EXACT_single;
		}
		$students['Esatto'] = $EXACT;

	    //lettura under
		$UNDER = array();
		$UNDER_values = array("10","9.75","9.25","8.75","8.25","7.75","7.25","6.75","6.25","5.75","5.25","4.75","4.25","3.75","3.25","3","2");
		for ($ex = 6; $ex<=22; $ex++) {
			$UNDER_single = $excel->setActiveSheetIndex(0)->getCell('D'.$ex)->getOldCalculatedValue();
			$UNDER[$UNDER_values[$ex-6]] = $UNDER_single;
		}
		$students['Under'] = $UNDER;

	    //lettura over
		$OVER = array();
		$OVER_values = array("10", "9.75", "9.25","8.75","8.25","7.75","7.25","6.75","6.25","5.75","5.25","4.75","4.25","3.75","3.25", "3", "2");
		for ($ex = 6; $ex<=22; $ex++) {
			$OVER_single = $excel->setActiveSheetIndex(0)->getCell('E'.$ex)->getOldCalculatedValue();
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

?>
