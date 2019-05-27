<?php
class Carapuce extends Pokemon {
  public function __construct ($level) {
    $this->name = 'Carapuce';
    $this->life_per_level = 9;
    $this->strength_per_level = 2;
    $type = "Water";
    parent::__construct($level, $type);
  }

  public function say_hi() {
    echo(nl2br("\nCaracara !"));
  }
}
?>
