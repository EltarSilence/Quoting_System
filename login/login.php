<?php
include "../config.php";
session_start();
if( isset($_SESSION['user_id']) ){
	header("Location: /");
}

if(!empty($_POST['username']) && !empty($_POST['password'])){
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	$sql = "SELECT * FROM utenti WHERE username = '".$_POST['username']."' AND password = '".md5($_POST['password'])."'";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_assoc($result);
		$_SESSION['user_id'] = $row['id'];
		mysqli_close($conn);
		header("Location: /");
	}else{
		$sql = "SELECT * FROM utenti WHERE email = '".$_POST['username']."' AND password = '".md5($_POST['password'])."'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) == 1){
			$row = mysqli_fetch_assoc($result);
			$_SESSION['user_id'] = $row['id'];
			mysqli_close($conn);
			header("Location: /");
		}else{
			$message = "Credenziali errate";
		}
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login Below</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="../icon.css">
		<link href='https://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="script.js"></script>
	</head>
	<body>
		<div class="header">
			Quoting by Rizza, Ravasi, Gallina
		</div>
		<?php 
			if(!empty($message)){
				echo "<p>".$message."</p>";
			}
		?>
		<h1 class="white">Login</h1><span class="white">or <a href="register.php">register here</a></span>
		<form action="login.php" method="POST">
			<input type="text" placeholder="Username" name="username">
			<input type="password" placeholder="Password" name="password">
			<input type="submit">
		</form>
	</body>
</html>