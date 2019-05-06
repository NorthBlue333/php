<html>
<?php require("head.php");
date_default_timezone_set ("Europe/Paris");
?>

  <body class="p-5">
    <h1>Meteo</h1>
    <p>Nous sommes le <?=date("Y-m-d") ?> et il est <?= date("H:i:s") ?></p>
    <a href="paris.php">Voir la météo de Paris</a>
    <a href="bordeaux.php">Voir la météo de Bordeaux</a>
  </body>
</html>
