<?php
class Basicpotion extends Potion {
  public function __construct() {
    $this->name = "Potion";
    $this->healing = 20;
    $this->full = false;
  }
}
?>
