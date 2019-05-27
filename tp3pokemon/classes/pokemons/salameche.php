<?php
class Salameche extends Pokemon {
  public function __construct ($level) {
    $this->name = 'Salameche';
    $this->life_per_level = 5;
    $this->strength_per_level = 4;
    $type = "Fire";
    parent::__construct($level, $type);
  }

  public function say_hi() {
    echo(nl2br("\nSalameche !"));
  }
}
?>
