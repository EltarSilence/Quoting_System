<?php
include "../config.php";
session_start();
if(isset($_SESSION['user_id'])){
	header("Location: /");
}
if(isset($_GET['a'])){
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	$sql = "UPDATE utenti SET status = 1 WHERE password = '".$_GET['a']."'";
	mysqli_query($conn, $sql);
	$sql = "SELECT * FROM utenti WHERE password = '".$_GET['a']."'";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_assoc($result);
		$_SESSION['user_id'] = $row['id'];
		mysqli_close($conn);
		header("Location: /");
	}else{
		mysqli_close($conn);
		header("Location: /login/register.php");
	}
}else{
	$message = '';
	if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])){
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
		$sql = "SELECT * FROM utenti WHERE username = '".$_POST['username']."'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) == 0){			
			$sql = "INSERT INTO utenti (username, email, password, status) VALUES ('".$_POST['username']."', '".$_POST['email']."', '".md5($_POST['password'])."', 0)";
			mysqli_query($conn, $sql);
			mail($_POST['email'], "Attivazione account", "https://quoting.altervista.org/login/register.php?a=".md5($_POST['password']));
			$message = "Abbiamo inviato una mail all'indirizzo, clicca sul link per attivare questo account";
		}else{
			$message = "Account già esistente";
		}
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Register Below</title>
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
		<?php 
			if(!empty($message)){
				echo "<p>".$message."</p>";
			}
		?>
		<h1 class="white">Register</h1>
		<span class="white">or <a href="login.php">login here</a></span>
		<form action="register.php" method="POST">
		
			<input type="text" placeholder="Enter your username" name="username">
			<input type="text" placeholder="Enter your email" name="email">
			<input type="password" placeholder="and password" name="password">
			<input type="password" placeholder="confirm password" name="confirm_password">
			<input type="submit">
		</form>
	</body>
</html>