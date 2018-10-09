<?php
	require 'config.php';
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
	checkAndPayBet();


?>