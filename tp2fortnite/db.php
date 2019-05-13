<?php
$dsn = 'mysql:dbname=tp2fortnite;host=localhost;port=3307;charset=utf8';
$user = 'root';
$password = '';

try {
    $db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

?>
