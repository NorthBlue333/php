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
    <h1>Les spawns</h1>

    <?php
    if(isset($_POST['name']) && !empty($_POST['name'])) {
      $name = $_POST['name'];
      $query = $db->prepare("INSERT INTO spawn(name, image) VALUES (:name, 'moto.png')");
      $query->bindParam(':name', $name, PDO::PARAM_STR);
      $query->execute();
      ?>
      <p>Vous avez ajouté le spawn <?= $name ?></p>
    <?php }
    else if(isset($_POST['delete'])) {
      $query = $db->prepare("DELETE FROM spawn WHERE id=:id");
      $query->bindParam(':id', $_POST['spawnid'], PDO::PARAM_INT);
      $query->execute();
    }
    else if(isset($_POST['modify'])) {
      $query = $db->prepare("UPDATE spawn SET name=:name WHERE id=:id");
      $query->bindParam(':name', $_POST['spawnname'], PDO::PARAM_STR);
      $query->bindParam(':id', $_POST['spawnid'], PDO::PARAM_INT);
      $query->execute();
    }
    ?>

    <?php
    $query = $db->prepare("SELECT * FROM spawn");
    $query->execute();
    if($query) {
      $query = $query->fetchAll();
    }
    ?>
    <table class="table table-striped">
      <tbody>
        <?php
        foreach ($query as $spawn) { ?>
        <tr>
          <form action="add.php" method="post">
            <th scope="row"><input type="text" class="form-control" value="<?= $spawn['id'] ?>" name="spawnid" readonly></th>
            <td><input class="form-control" type="text" value="<?= $spawn['name'] ?>" name="spawnname"></td>
            <td>
              <button type="submit" name="modify" class="btn btn-primary">Modifier</button>
              <button type="submit" name="delete" class="btn btn-primary">Supprimer</button>
            </td>
          </form>
        </tr>
        <?php }
        ?>
      </tbody>
    </table>
    <br />
    <form action="add.php" method="post">
      <input class="form-control" type="text" name="name" placeholder="Le nom du spawn" />
      <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
  </body>
</html>
