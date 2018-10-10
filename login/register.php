<?php
	session_start();
	require_once("../config.php");
	if(isset($_SESSION['user_id'])){
		header("Location: /");
	}elseif(isset($_GET['r'])){
		$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
		$sql = "UPDATE utenti SET status = 1 WHERE password = '".$_GET['r']."'";
		mysqli_query($conn, $sql);
		$sql = "SELECT * FROM utenti WHERE password = '".$_GET['r']."'";
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
				mail($_POST['email'], "Attivazione account", "https://quoting.altervista.org/login/register.php?r=".md5($_POST['password']));
				$message = "Abbiamo inviato una mail all'indirizzo, clicca sul link per attivare questo account";
			}else{
				$message = "Account già esistente";
			}
		}
	}
?>
<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>Register Below</title>
			<link rel="stylesheet" type="text/css" href="style.css">
			<link rel="stylesheet" href="../icon.css">
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta http-equiv="X-UA-Compatible" content="ie=edge">
			<link href='https://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			<script src="script.js"></script>

	</head>
	<body class="siign">
		<div class="sign-container">
			<div>
				<div class="left-bk">
				</div>
				<div>
					<h1>Sign-up</h1>
					<h3>Join with Us and Have Fun!</h3>
				</div>
			</div>
			<div class="right-frm">
				<div>
					<h3 class="sign-link"><a href="login.php">Sign-in <span>&#8250;</span></a></h3>
					<h1>Sign-up</h1>
<?php 
	if(!empty($message)){
		echo "<p class='message'>".$message."</p>";
	}
?>
					<form action="register.php" method="POST">
						<input type="text" placeholder="Enter your username" name="username">
						<input type="text" placeholder="Enter your email" name="email">
						<input type="password" placeholder="and password" name="password">
						<input type="password" placeholder="confirm password" name="confirm_password">
						<input type="submit" value="Sign Me Up">
					</form>
				</div>
			</div>
		</div>
	</body>
</html>