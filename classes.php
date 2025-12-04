<?php
abstract class CareerBase {
    abstract public function calculateScore($skills);
}

class CareerQueue {
    private $items = [];

    public function enqueue($item) {
        $this->items[] = $item;
    }

    public function dequeue() {
        return array_shift($this->items);
    }

    public function isEmpty() {
        return empty($this->items);
    }

    public function all() {
        return $this->items;
    }
}

class Career extends CareerBase {
    private $name;
    private $requiredSkills = [];
    private $resources = [];
    private $playlist;

    public function __construct($name, $skills, $playlist, $resources) {
        $this->name = $name;
        $this->requiredSkills = $skills;
        $this->playlist = $playlist;
        $this->resources = $resources;
    }

    public function getName() { return $this->name; }
    public function getSkills() { return $this->requiredSkills; }
    public function getPlaylist() { return $this->playlist; }
    public function getResources() { return $this->resources; }

    public function calculateScore($skills) {
        $sum = 0;
        foreach ($this->requiredSkills as $skill) {
            $key = strtolower(str_replace(" ", "_", $skill));
            $sum += $skills[$key] ?? 0;
        }
        return $sum;
    }
}


class CareerAnalyzer {
    private $careers = [];

    public function addCareer(Career $c) {
        $this->careers[] = $c;
    }

    public function evaluate($skills) {
        $result = [];
        foreach ($this->careers as $c) {
            $result[$c->getName()] = $c->calculateScore($skills);
        }
        arsort($result);
        return $result;
    }
}
?>
