<?php
	require_once('../config.php');
	require_once('../functions.php');
	
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);	
	
	//vincite settimanali
	$winner_s = getWinsWeek();
	
	//vincite mensili
	$winner_m = getWinsMonth();
	
	mysqli_close($conn);
	

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