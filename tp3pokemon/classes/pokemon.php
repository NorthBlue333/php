<?php
abstract class Pokemon {
  protected $name;
  protected $max_life;
	protected $life;
	protected $level;
	protected $type;
	protected $strength;
  protected $life_per_level;
  protected $strength_per_level;

  public function get_max_life() {
    return $this->max_life;
  }

  public function get_life() {
    return $this->life;
  }

  public function get_level() {
    return $this->level;
  }

  public function get_strength() {
    return $this->strength;
  }

  public function get_name() {
    return $this->name;
  }

  public function get_type() {
    return $this->type;
  }

	public function __construct ($level, $type)
	{
    $this->life = $level * $this->life_per_level;
		$this->max_life = $this->life;
		$this->level = $level;
		$this->type = $type;
		$this->strength = $level * $this->strength_per_level;
    $this->say_hi();
	}

  public abstract function say_hi();

  public function take_damage($dmg) {
    $this->life -= $dmg;
    $this->life = $this->life < 0 ? 0 : $this->life;
    echo(nl2br("\n<b>The pokemon ".$this->name." has taken ".$dmg." damage</b>"));
    $this->show_details();
  }

  public function heal($heal, $full = false) {
    if($full) {
      $this->life = $this->max_life;
      echo(nl2br("\n<b>The pokemon ".$this->name." is fully healed.</b>"));
    } else {
      $this->life += $heal;
      $this->life = $this->life > $this->max_life ? $this->max_life : $this->life;
      echo(nl2br("\n<b>The pokemon ".$this->name." has healed for ".$heal."</b>"));
    }
    $this->show_details();
  }

  public function attack($pokemon) {
    $types = array(
      "Water" => "Fire",
      "Plant" => "Water",
      "Fire" => "Plant"
    );
    echo(nl2br("\n<b>The pokemon ".$this->name." attacks the pokemon ".$pokemon->name."</b>"));
    $dmg = ceil($this->strength * (rand(900, 1100) / 1000));
    $resistant = $types[$pokemon->type];
    $weakness = $types[array_search($pokemon->type, $types)];
    $dmg = $weakness == $this->type ? ceil($dmg * 2) : ($resistant == $this->type ? ceil($dmg * 0.5) : $dmg);
    $pokemon->take_damage($dmg);
  }

  public function show_details() {
    echo(nl2br("\n<em>The pokemon ".$this->name." has ".$this->life." hp on ".$this->max_life." hp</em>"));
  }

  public function level_up() {
    $this->level++;
    $this->max_life += $this->life_per_level;
    $this->life += $this->life_per_level;
    $this->strength += $this->strength_per_level;
  }
}
?>
