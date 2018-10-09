<?php
	include '../config.php';
	
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);	
	
	//vincite settimanali
	$sql = "SELECT scommesse.*, utenti.username FROM scommesse  INNER JOIN utenti ON utenti.id = scommesse.idUtente WHERE scommesse.data >= '".date("Y-m-d", strtotime(date("Y-m-d")."-7day"))."'";
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
	
	//vincite mensili
	$sql = "SELECT scommesse.*, utenti.username FROM scommesse  INNER JOIN utenti ON utenti.id = scommesse.idUtente WHERE scommesse.data >= '".date("Y-m-d", strtotime(date("Y-m-d")."-30day"))."'";
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
	
	mysqli_close($conn);
	
	function cmp($a, $b){
		foreach($a as $akey => $avalue){
			foreach($b as $bkey => $bvalue){
				return ($avalue < $bvalue) ? 1 : -1;
			}
		}
		return 0;
	}
?>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="../icon.css">
		<script src="script.js"></script>
	</head>
	<body>
		<div id="vincita1">
			<div>Top Vincite Settimanali</div>
			<center>
				<?php
					for($i = 0; $i < 5 && $i < sizeof($winner_s); $i++){
						echo '<div class="rank">
								<div class="img"></div>
								<div class="nome">'.array_keys($winner_s[$i])[0].'</div>
								<div class="coin"> '.$winner_s[$i][array_keys($winner_s[$i])[0]].'<i class="icon icon-exacoin"></i></div>
							</div>';
					}
				?>
			</center>
		</div>
		<div id="vincita2">
			<div>Top Vincite Mensili</div>
				<center>
				<?php
					for($i = 0; $i < 5 && $i < sizeof($winner_m); $i++){
						echo '<div class="rank">
								<div class="img"></div>
								<div class="nome">'.array_keys($winner_m[$i])[0].'</div>
								<div class="coin"> '.$winner_m[$i][array_keys($winner_m[$i])[0]].'<i class="icon icon-exacoin"></i></div>
							</div>';
					}
				?>
			</center>
		</div>
	</body>
</html>