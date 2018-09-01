<?php

namespace App\Models;

class Race {
        
    public function getRaces() {
        $json_file = file_get_contents('../json/race.json');
        $json = json_decode($json_file, true);
        return $json;
    } 
    
    public function chooseRaces() {
        $races = $this->getRaces();
        return array($races[0], $races[1]);
    }
}
