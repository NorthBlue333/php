<?php
class Bot {
  protected $bag;
  protected $pokemons;

  public function __construct($bag, $pokemons) {
    $this->bag = $bag;
    $this->pokemons = $pokemons;
  }

  public function fight($pokemon) {
    $captured_or_dead = false;
    $i = 1;
    echo(nl2br("\n"));
    while(!$captured_or_dead) {
      $capturing_or_healing = false;
      echo(nl2br("<h3>\nTurn ".$i."</h3>"));
      $pokemon->attack($this->pokemons[0]);
      if($this->pokemons[0]->get_life() == 0) {
        echo(nl2br("\nThe pokemon ".$this->pokemons[0]->get_name()." is dead. The fight is over."));
        $captured_or_dead = true;
      } else {
        if($this->count_balls() > 0) {
          $capturing_or_healing = $this->try_to_capture($pokemon);
          if($capturing_or_healing[0]) {
            $captured_or_dead = true;
          } else if($capturing_or_healing[1] == false) {
            $types = array(
              "Water" => "Fire",
              "Plant" => "Water",
              "Fire" => "Plant"
            );
            $max_dmg = ceil($pokemon->get_strength() * 1.1);
            $resistant = $types[$this->pokemons[0]->get_type()];
            $weakness = $types[array_search($this->pokemons[0]->get_type(), $types)];
            $max_dmg = $weakness == $pokemon->get_type() ? ceil($max_dmg * 2) : ($resistant == $pokemon->get_type() ? ceil($max_dmg * 0.5) : ceil($max_dmg));
            if($max_dmg >= $this->pokemons[0]->get_life() && $this->count_potions() > 0) {
              foreach ($this->bag['potions'] as $name => $category) {
                foreach ($category as $key => $potion) {
                  if($potion->get_healing() + $this->pokemons[0]->get_life() > $pokemon->get_strength() * 1.1) {
                    $potion->use($this->pokemons[0]);
                    unset($this->bag['potions'][$name][$key]);
                    $capturing_or_healing = true;
                    break 2;
                  } else if($potion->is_full()) {
                    $potion->use($this->pokemons[0]);
                    unset($this->bag['potions'][$name][$key]);
                    $capturing_or_healing = true;
                    break 2;
                  }
                }
              }
              if(!$capturing_or_healing) {
                $potion->use($this->pokemons[0]);
                unset($this->bag['potions'][-1][0]);
                $capturing_or_healing = true;
              }
            }
          }
        }
        if($capturing_or_healing === false || $capturing_or_healing[1] === false) {
          $this->pokemons[0]->attack($pokemon);
        }
      }
      $i++;
    }
  }

  protected function try_to_capture($pokemon) {
    $balls_left = $this->count_balls();
    $captured = false;
    $tried = false;
    foreach($this->bag['balls'] as $name => $balls) {
      if($this->check_if_direct_capture($pokemon, $balls, $name)) {
        $captured = true;
        $tried = true;
        break;
      } else {
        if($this->check_last_hit($pokemon)) {
          $min = 0;
        } else if($balls_left >= 3) {
          $min = 0.5;
        } else {
          $min = 0.85;
        }
        foreach($balls as $key => $ball) {
          $proba = round((($pokemon->get_max_life() - $pokemon->get_life()) / $pokemon->get_max_life()) * (1 + ($ball->get_level() - $pokemon->get_level()) / 25), 2);
          if($proba >= $min) {
            $tried = true;
            $try = $ball->use($pokemon);
            unset($this->bag['balls'][$name][$key]);
            if($try) {
              $captured = true;
            }
            break;
          }
        }
      }
    }
    return [$captured, $tried];
  }

  protected function count_balls() {
    $balls_left = 0;
    foreach($this->bag['balls'] as $balls) {
      $balls_left += count($balls);
    }
    return $balls_left;
  }

  protected function count_potions() {
    $potions_left = 0;
    foreach($this->bag['potions'] as $potions) {
      $potions_left += count($potions);
    }
    return $potions_left;
  }

  protected function check_if_direct_capture($pokemon, $balls, $name) {
    $direct = false;
    foreach($balls as $key => $ball) {
      if($ball->get_direct_capture()) {
        $ball->use($pokemon);
        unset($this->bag['balls'][$name][$key]);
        $direct = true;
        break;
      } else {
        $proba = round((($pokemon->get_max_life() - $pokemon->get_life()) / $pokemon->get_max_life()) * (1 + ($ball->get_level() - $pokemon->get_level()) / 25), 2);
        if($proba == 1) {
          $ball->use($pokemon);
          unset($this->bag['balls'][$name][$key]);
          $direct = true;
          break;
        }
      }
    }
    return $direct;
  }

  protected function check_last_hit($pokemon) {
    $types = array(
      "Water" => "Fire",
      "Plant" => "Water",
      "Fire" => "Plant"
    );
    $max_dmg_enemy = ceil($pokemon->get_strength() * 1.1);
    $resistant_enemy = $types[$this->pokemons[0]->get_type()];
    $weakness_enemy = $types[array_search($this->pokemons[0]->get_type(), $types)];
    $max_dmg_enemy = $weakness_enemy == $pokemon->get_type() ? ceil($max_dmg_enemy * 2) : ($resistant_enemy == $pokemon->get_type() ? ceil($max_dmg_enemy * 0.5) : ceil($max_dmg_enemy));
    $max_dmg = ceil($pokemon->get_strength() * 1.1);
    $resistant = $types[$pokemon->get_type()];
    $weakness = $types[array_search($pokemon->get_type(), $types)];
    $max_dmg = $weakness == $this->pokemons[0]->get_type() ? ceil($max_dmg * 2) : ($resistant == $this->pokemons[0]->get_type() ? ceil($max_dmg * 0.5) : ceil($max_dmg));
    if($max_dmg >= $pokemon->get_life() || $max_dmg_enemy >= $this->pokemons[0]->get_life()) {
      return true;
    } else {
      return false;
    }
  }
}
?>
