<?php
include "../config.php";
session_start();
if( isset($_SESSION['user_id']) ){
	header("Location: /");
}
$message="";
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
<html lang="en">
<head>
    <title>Login Below</title>
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
                    <h1>Sign-in</h1>
                    <h3>Join with Us and Have Fun!</h3>
                </div>
            </div>
            <div class="right-frm">
                <div>
                    <h1 <?php if(!empty($message) || $message==""){echo "style='margin-bottom:0'";} ?>>Sign-in</h1>
					<?php 
						if(!empty($message)){
							echo "<p class='message'>".$message."</p>";
						}
					?>
                    <form action="login.php" method="POST">
                        <input type="text" placeholder="Username" name="username">
                        <input type="password" placeholder="Password" name="password">
                        <input type="submit" value="INVIA">
                    </form>
                </div>
            </div>
        </div>
</body>
</html>