<?php
class Superball extends Ball {
  public function __construct() {
    $this->name = "Superball";
    $this->level = 30;
    $this->direct_capture = false;
  }
}
?>
