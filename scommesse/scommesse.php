<?php require_once "../config.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link rel="stylesheet" href="css.css">
	<script src="script.js"></script>
</head>
<body>

<!--<div class="table-responsive">-->
<table id="scom" class="scomTable">
    <tr>
        <th colspan="13">Verifica di Informatica</th>
    </tr>
    <tr>
        <td colspan="9">15/10/2018</td>
        <td colspan="4">N persone hanno scommesso su questo evento</td>
    </tr>
    <tr>
        <?php
        foreach (STUDENTI as $studente){
            echo '<td id="st_'.$studente.'" class="student">'.$studente.'<p style="text-align:center"><i class="fa fa-angle-double-down"></i></p>';
            include "submenu.html";
            echo '</td>';
//            echo '<td id="show">C</td>';
        }
        ?>
    </tr>
</table>

<p>CIAO</p>
<!--</div>-->

</body>
</html>