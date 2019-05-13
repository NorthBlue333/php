<?php
session_start();
require('db.php');
?>

<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <h1>Générateur de spawn</h1>
    <?php
    if(isset($_GET['spawnid']) && !empty($_GET['spawnid'])) {
      $id = $_GET['spawnid'];
      $query = $db->prepare("SELECT * FROM spawn WHERE id=:id");
      $query->bindParam(':id', $id, PDO::PARAM_INT);
      $query->execute();
      if($query) {
        $query = $query->fetch();
      }
      ?>
      <h2><?= $query['name'] ?></h2>
      <img src="images/<?= $query['image'] ?>" alt="Image du spawn <?= $query['name'] ?>" />
    <?php }
    $ids = $db->prepare("SELECT id FROM spawn");
    $ids->execute();
    if($ids) {
      $ids = $ids->fetchAll();
    }
    $number = rand(0, count($ids)-1);
    if(isset($_SESSION['previous']) && !empty($_SESSION['previous'])) {
      while($number == $_SESSION['previous']) {
        $number = rand(0, count($ids)-1);
      }
    }
    $_SESSION['previous'] = $number;
    ?>
    <br />
    <a href="index.php?spawnid=<?= $ids[$number]['id'] ?>"><button>Générer un spawn</button></a>
  </body>
</html>
