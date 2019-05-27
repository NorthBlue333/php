<?php
class Pokeball extends Ball {
  public function __construct() {
    $this->name = "Pokeball";
    $this->level = 10;
    $this->direct_capture = false;
  }
}
?>
