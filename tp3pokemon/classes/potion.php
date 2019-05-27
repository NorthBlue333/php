<?php
abstract class Potion implements IUsable {
  protected $name;
  protected $healing;
  protected $full;

  public function get_healing() {
    return $this->healing;
  }

  public function is_full() {
    return $this->full;
  }

  public function use($pokemon) {
    if($this->full) {
    echo(nl2br("\n<b>The potion ".$this->name." has been used on ".$pokemon->get_name()."</b>"));
      $pokemon->heal($this->healing, true);
    } else {
    echo(nl2br("\n<b>The potion ".$this->name." has been used on ".$pokemon->get_name()."</b>"));
      $pokemon->heal($this->healing, false);
    }
  }
}
?>
