<?php
const STUDENTI = array("Andreoli", "Bacchetti", "Bara", "Canipari", "Cavedaghi", "Conzadori", "Deambrosis", "Gallina", "Marchi", "Ottolini", "Ravasi", "Rizza", "Siliqua");
const MATERIE = array("Informatica", "T.P.S.", "Sistemi", "Italiano", "Storia", "Matematica", "Gestione");
?>

<html>
<head>
  <title>JSON Generator</title>
  <script src="script.js"></script>
</head>
<style>
  body {
    background: #3a7bd5;
    background: -webkit-linear-gradient(to top, #3a6073, #3a7bd5);
    background: linear-gradient(to top, #3a6073, #3a7bd5);
  }

  input {
      box-shadow: 4px -1px 15px 1px black;
  }

  table {
    width: 20%;
    text-align: center;
    border: 1px solid black;
    border-radius: 6px;
    box-shadow: 4px -1px 15px 9px lightblue;
  }

  input[type=submit] {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
  }

  textarea {
    width: 100%;
    height: 200px;
    background-color: gray;
    color: white;
    font-style: bold;
    font-size: 8pt;
  }

</style>
<body>
  <h2>Generatore JSON per Quoting</h2>
  <form method="POST" action="" name="genForm">
    <h4>Materia:
    <select name="materia">
      <?php
        foreach (MATERIE as $materia){
          echo '<option value="'.$materia.'">'.$materia.'</option>';
        }
      ?>
    </select>
    <br />
    <h4>Giorno <input name="giorno" /></h4>
    <h4>Mese <input name="mese" /></h4>
    <h4>Anno <input name="anno" value="<?php echo date('Y'); ?>"/></h4>
    <table>
      <tr>
        <td>Nome</td>
        <td>Lambda</td>
      </tr>
      <tr>
      <?php
        foreach(STUDENTI as $studente){
          echo '<tr><td>'.$studente.'</td>
          <td><input id="'.$studente.'" onchange="generateQ(\''.$studente.'\')"/></td>
          </tr>';
        }
      ?>

      </tr>
    </table>
    <textarea name="json" id="result">
    </textarea>
    <br />
    <input type="submit" value="Esporta JSON" />
  </form>

<?php
if (isset($_POST['materia'])){
  $file = fopen(
    $_POST['materia'].'_'.
    $_POST['anno'].$_POST['mese'].$_POST['giorno'].'.json'
    , 'w+');
    fwrite($file, substr($_POST['json'], 0, $_POST['json']-1));
    fclose($file);
    echo 'Creato il file:
    '.$_POST['materia'].'_'.$_POST['anno'].$_POST['mese'].$_POST['giorno'].'.json';
}
else {
  die();
}


?>

</body>
</html>
