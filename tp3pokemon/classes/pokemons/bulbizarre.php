<?php
class Bulbizarre extends Pokemon {
  public function __construct ($level) {
    $this->name = 'Bulbizarre';
    $this->life_per_level = 7;
    $this->strength_per_level = 3;
    $type = "Plant";
    parent::__construct($level, $type);
  }

  public function say_hi() {
    echo(nl2br("\nBulbi !"));
  }
}
?>
