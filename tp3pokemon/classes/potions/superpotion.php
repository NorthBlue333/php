<?php
class Superpotion extends Potion {
  public function __construct() {
    $this->name = "Superpotion";
    $this->healing = 50;
    $this->full = false;
  }
}
?>
