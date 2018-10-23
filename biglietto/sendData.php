<?php
	session_start();

	require("../config.php");

	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

	$coin = $_POST['coin'];
	$sql = "SELECT coin FROM utenti WHERE id = ".$_SESSION['user_id'];
	$result = mysqli_query($conn, $sql);
	$user_coin = 0;
	while ($row = mysqli_fetch_assoc($result)) {
		$user_coin = $row['coin'];
	}
	if ($user_coin < 100 || $user_coin <= $coin) {
		echo 'Impossibile effettuare la scommessa, credito non sufficiente.';
		die();
	}else{
		$multiple = $_POST['multiple'];
		$sql = "INSERT INTO scommesse (idUtente, coin, data, pagata) VALUES (".$_SESSION['user_id'].", ".$coin.", '".date('Y-m-d')."', 0)";
		$result = mysqli_query($conn, $sql);

		$sql = "SELECT MAX(id) AS id FROM scommesse";
		$result = mysqli_query($conn, $sql);
		$id = -1;
		while ($v = mysqli_fetch_assoc($result)) {
			$id = $v['id'];
		}

		//materia_data_Cognome|TIPO|VAL
		for ($i = 0; $i < sizeof($multiple); $i++) {
			$arr = explode('|', $multiple[$i]);
			$chiave = $arr[0];
			$tipo = ucfirst(strtolower($arr[1])); //prima maiuscola di una stringa minuscola
			$val = $arr[2];
			$arr2 = explode('_', $arr[0]);
			$materia = $arr2[0];
			$data = $arr2[1];
			$persona = $arr2[2];
			$real_quote = file_get_contents('../avvenimenti/'.$materia.'_'.$data.'.json');
			$qt = json_decode($real_quote, true);
			$quota_reale = $qt[$persona][$tipo][$val];
			$mult = "INSERT INTO multiple (idScommessa, chiave, type, value, quote) VALUES (".$id.", '".$chiave."', '".strtoupper($tipo)."', '".$val."', ".$quota_reale.")";
			$result = mysqli_query($conn, $mult);
		}

		$money = "UPDATE utenti SET coin = ".($user_coin-$coin)." WHERE id = ".$_SESSION['user_id'];
		$resmoney = mysqli_query($conn, $money);
	}
?>
