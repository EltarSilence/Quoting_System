<?php 
session_start();
require_once "../config.php"; 

function getVerificheDisponibili(){
  $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);	
  $sql = "SELECT * FROM disponibili WHERE dal <= '".date("Y-m-d")."' AND al >= '".date("Y-m-d")."'";
  $result = mysqli_query($conn, $sql);

  $verifiche = array();
  while($row = mysql_fetch_assoc($result)){
     array_push($verifiche, $row);
 }
 mysqli_close($conn);
 return $verifiche;
}

?>
<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
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
}
else {
    if ($_GET['verifica']){

    }

    else {

        foreach (STUDENTI as $studente){
            echo '<td id="st_'.$studente.'" class="student">'.$studente.'<p style="text-align:center"><i class="fa fa-angle-double-down"></i></p>';
            include "submenu.html";
            echo '</td>';
            //echo '<td id="show">C</td>';
        }

        $verifiche = getVerificheDisponibili();
        $materia = strtok($verifiche['chiave'], '_');
        $data = explode("_", $verifiche['chiave']); $data = $arr[1];

        for ($k=0; $k<sizeof($verifiche); $k++){
            echo '<p>
            <button class="btn btn-primary" type="button" style="width: 100%;" data-toggle="collapse" data-target="#collapseVerifica" aria-expanded="false" aria-controls="collapseVerifica">
                '.$data.' - Verifica di '.$materia.'</button>
            </p>
            <div class="collapse" id="collapseVerifica">
                <div class="card card-body">
                    Scommesse disponibili
                </div>
            </div>';
        }

    }


}


?>



</body>
</html>