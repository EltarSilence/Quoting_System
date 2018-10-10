<?php 
	session_start();
	require_once('../config.php');
	require_once('../functions.php');

	
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
				
				if(in_array($arr[0], MATERIE) && sizeof($arr) == 2){
					
				}
				
				
				//controlli generici
				if(1 == 0){
					header("Location: scommesse.php");
				}else{
					//se il file non esiste
					if(0 == 1){
						//genera file
					}
					echo '<a href="scommesse.php">
					<button class="btn btn-primary" type="button" style="width: 100%;" data-toggle="collapse" data-target="#collapseVerifica" aria-expanded="false" aria-controls="collapseVerifica">Back</button>
					</a><table>';
					foreach(STUDENTI as $s){
						echo '<tr><td><div class="col-xs-12">'.$s.'</div><div class="col-xs-12">Elenco quote</div></td></tr>';
					}
					echo '</table>';
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