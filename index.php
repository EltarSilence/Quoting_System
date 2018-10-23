<?php
	//require_once 'redirect.php';
	require 'config.php';
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Quoting</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script src="login/script.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="login/style.css">
	<link rel="stylesheet" href="icon.css">

	<link href='https://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
	<script>
		$(document).ready(function(){
			$('#topvincite').height($('#topvincite').width()*0.6);
		});

	</script>
</head>
<body>
	<div class="row header" style="margin:0px; position: fixed; padding: 0px; border: 0px; z-index: 9999; background-color: white;">
		<div class="col-sm-9 header">
			Quoting by Rizza, Ravasi, Gallina
		</div>
	<?php
		if (isset($_SESSION['user_id'])){
			$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
			$sql = "SELECT coin, username FROM utenti WHERE id = ".$_SESSION['user_id'];
			$result = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_assoc($result)) {
			echo '<div class="col-sm-3 row" id="logout">
			<div class="row">
				<div>'.$row['username'].'</div>
				<div>';
						echo $row['coin'].'<i class="icon icon-exacoin"></i></div>
					</div>
					<a href="login/logout.php">
						<div>
							Logout
						</div>
					</a>
				</div>';
			}
		}else {
			echo '<a href="login/login.php" class="login col-sm-3">
			<div id="login">
				Login / Registrati
			</div>
		</a>';
		}
	?>

	</div>
	<br>
	<div class="row" style="margin: 0px; margin-top: 45px">
		<div class="col-sm-8">
			<iframe src="scommesse/scommesse.php" class="col-sm-12" id="scom"></iframe>
		</div>
		<div class="col-sm-4">
			<iframe src="topWins/topWins.php" class="col-sm-12" id="topvincite"></iframe>
			<iframe src="biglietto/biglietto.php" class="col-sm-12" id="biglietto"></iframe>
		</div>
	</div>

</body>
</html>
