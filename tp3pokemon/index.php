<?php
require_once('classes/iusable.php');
require_once('classes/potion.php');
require_once('classes/pokemon.php');
require_once('classes/ball.php');
require_once('classes/bot.php');

require_once('classes/balls/hyperball.php');
require_once('classes/balls/masterball.php');
require_once('classes/balls/pokeball.php');
require_once('classes/balls/superball.php');

require_once('classes/pokemons/bulbizarre.php');
require_once('classes/pokemons/carapuce.php');
require_once('classes/pokemons/salameche.php');

require_once('classes/potions/basicpotion.php');
require_once('classes/potions/superpotion.php');
require_once('classes/potions/hyperpotion.php');
require_once('classes/potions/potionmax.php');

$pokeballs = 3;
$potions = 2;
$superpotions = 1;

$bag = array (
  "balls" => array(
    "pokeballs" => array()
  ),
  "potions" => array(
    "potions" => array(),
    "superpotions" => array()
  )
);
for($i = 0; $i < $pokeballs; $i++) {
  array_push($bag['balls']['pokeballs'], new Pokeball());
}
for($i = 0; $i < $potions; $i++) {
  array_push($bag['potions']['potions'], new Basicpotion());
}
for($i = 0; $i < $superpotions; $i++) {
  array_push($bag['potions']['superpotions'], new Superpotion());
}
$pokemons = array (new Carapuce(5));

$the_great_bot = new Bot($bag, $pokemons);
$enemy = new Salameche(8);

$the_great_bot->fight($enemy);

?>
