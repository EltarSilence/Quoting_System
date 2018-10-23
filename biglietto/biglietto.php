<?php
	session_start();
	if(!isset($_SESSION['user_id'])){
		setcookie("quoting", "");
	}else{
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../icon.css">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script src="../scommessa.js"></script>
	<script src="script.js"></script>
</head>
<body>
	<div class="card">
	<div class="card-header">
		Biglietto
	</div>
	<div id="multipla"></div>
	<div class="card-header">
		Quota finale: <div id="quota_finale"></div>
	</div>
	
	<button class="btn btn-default" id="aum"><i class="icon icon-up"></i></button>
	<input id="importo" type="number" min="200" max="10000" value="100">
	<button class="btn btn-default" id="decr"><i class="icon icon-down"></i></button>
	
	<div class="card-header">
		Possibile Vincita: <div id="vincita"></div>
	</div>
	<button id="scommetti" class="btn btn-primary">Scommetti</button>
	</div>
</body>
</html>
<?php
	}
?>
