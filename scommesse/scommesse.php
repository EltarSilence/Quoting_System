<?php 
	session_start();
	require_once('../config.php');
	require_once('../functions.php');
	require_once('../PHPExcel/Classes/PHPExcel.php');	
?>
<!DOCTYPE html>
<html>
	<head>
		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css.css">
		<script src="script.js"></script>
	</head>
	<body>
<?php
	if (!isset($_SESSION['user_id'])){
		echo '<div class="alert alert-info" role="alert">
		<strong><a href="login/login.php">Accedi</a></strong> per giocare.
	</div>';
	}else {
		if(isset($_GET['verifica'])){
			$arr = explode("_", $_GET['verifica']);
			if(sizeof($arr) != 2 || !in_array($arr[0], MATERIE)){
				header("Location: scommesse.php");
			}else{;
				if(!in_array($_GET['verifica'].".json", scandir("../avvenimenti"))){
					newScommessa($arr[1], $arr[0]);
				}
				
				$st = file_get_contents("../avvenimenti/".$_GET['verifica'].".json");
				$json = json_decode($st, true);

				echo '<a href="scommesse.php">
				<button class="btn btn-primary" type="button">Back</button>
				</a><br>';
				foreach(STUDENTI as $s){
					echo '<button class="btn btn-primary col-xs-12" type="button" data-toggle="collapse" data-target="#c'.$s.'" aria-expanded="false">'.$s.'</button><div class="collapse row" id="c'.$s.'" style="margin:0px"><div class="col-sm-4">';
					foreach($json[$s]['Esatto'] as $k => $v){
						echo '<div class="row"><div class="col-xs-6">'.$k.'</div><div class="col-xs-6">'.round($v, 2).'</div><input type="radio" name="" id=""/></div>';
					}
					echo '</div><div class="col-sm-4">';
					foreach($json[$s]['Under'] as $k => $v){
						echo '<div class="row"><div class="col-xs-6">'.$k.'</div><div class="col-xs-6">'.round($v, 2).'</div><input type="radio" name="" id=""/></div>';
					}
					echo ' </div><div class="col-sm-4">';
					foreach($json[$s]['Over'] as $k => $v){
						echo '<div class="row"><div class="col-xs-6">'.$k.'</div><div class="col-xs-6">'.round($v, 2).'</div><input type="radio" name="" id=""/></div>';
					}
					echo '</div></div><br>';
				}
			}
		}else{
			$verifiche = getVerificheDisponibili();
			foreach($verifiche as $v){					
				$arr = explode("_", $v['chiave']);
				$materia = $arr[0];
				$data = date("d/m/Y", strtotime($arr[1]));
				echo '<a href="scommesse.php?verifica='.$v['chiave'].'">
				<button class="btn btn-primary" type="button" style="width: 100%;" data-toggle="collapse" data-target="#collapseVerifica" aria-expanded="false" aria-controls="collapseVerifica">
					'.$data.' - Verifica di '.$materia.'</button>
				</a>';
			}
		}
	}
?>
	</body>
</html>