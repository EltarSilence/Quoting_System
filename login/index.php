<?php
session_start();
if(isset($_SESSION['user_id'])){
	header("Location: /");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Welcome to your Web App</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="../icon.css">
		<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="script.js"></script>
	</head>
	<body>
		<div class="header">
			Quoting by Rizza, Ravasi, Gallina
		</div>
		<h1 class="white">Please Login or Register</h1>
		<a href="login.php">Login</a><span class="white"> or</span>
		<a href="register.php">Register</a>
	</body>
</html>