<?php
abstract class Ball implements IUsable {
  protected $name;
  protected $level;
  protected $direct_capture;

  public function get_level() {
    return $this->level;
  }

  public function get_direct_capture() {
    return $this->direct_capture;
  }

  public function use($pokemon) {
    if($this->direct_capture) {
      echo(nl2br("\nYou captured it"));
    } else {
      $proba = round((($pokemon->get_max_life() - $pokemon->get_life()) / $pokemon->get_max_life()) * (1 + ($this->level - $pokemon->get_level()) / 25), 2);
      $try = rand(0, 100) / 100;
      echo(nl2br("\nThe probability is ".$proba." and you tried with ".$try));
      $tried = $try <= $proba ? "captured it" : "failed";
      echo(nl2br("\nYou ".$tried));
      return $try <= $proba ? true : false;
    }
  }
}
?>
