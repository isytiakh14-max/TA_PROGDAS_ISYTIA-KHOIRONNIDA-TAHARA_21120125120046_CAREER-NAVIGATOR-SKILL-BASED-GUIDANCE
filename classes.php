<?php
/* ==========================================================
   MODUL 5 – OOP 1 (Class, Constructor, Inheritance)
   MODUL 6 – OOP 2 (Polymorphism, Abstraction, Encapsulation)
   MODUL 7 – Struktur Data (QUEUE)
   ========================================================== */

/* ========= ABSTRACT CLASS (Modul 6 – abstraction) ========= */

abstract class CareerBase {
    abstract public function calculateScore($skills);
}

/* ========= QUEUE (Modul 7 – Struktur Data) ========= */

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

/* ========= Career Model (Modul 5 – class, constructor) ========= */

class Career extends CareerBase {
    private $name;
    private $requiredSkills = [];
    private $resources = [];
    private $playlist;

    // constructor = Modul 5
    public function __construct($name, $skills, $playlist, $resources) {
        $this->name = $name;
        $this->requiredSkills = $skills;
        $this->playlist = $playlist;
        $this->resources = $resources;
    }

    // ENCAPSULATION (Modul 6 – getter)
    public function getName() { return $this->name; }
    public function getSkills() { return $this->requiredSkills; }
    public function getPlaylist() { return $this->playlist; }
    public function getResources() { return $this->resources; }

    // POLYMORPHISM – override abstract calculateScore()
    public function calculateScore($skills) {
        $sum = 0;
        foreach ($this->requiredSkills as $skill) {
            $key = strtolower(str_replace(" ", "_", $skill));
            $sum += $skills[$key] ?? 0;
        }
        return $sum;
    }
}

/* ========= Career Analyzer (Modul 5+6) ========= */

class CareerAnalyzer {
    private $careers = [];

    // tambah career
    public function addCareer(Career $c) {
        $this->careers[] = $c;
    }

    // hitung skor semua career
    public function evaluate($skills) {
        $result = [];
        foreach ($this->careers as $c) {
            // POLYMORPHISM disini
            $result[$c->getName()] = $c->calculateScore($skills);
        }
        arsort($result);
        return $result;
    }
}
?>
