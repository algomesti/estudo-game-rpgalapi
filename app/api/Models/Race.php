<?php

namespace App\Models;

class Race {
        
    public function getRaces() {
        $json_file = file_get_contents('json/race.json');
        $json = json_decode($json_file, true);
        return $json;
    } 
    
    public function chooseRaces() {
        
        $races = $this->getRaces();
        
        $indice_p1 = rand(0, count($races)-1);
        $r[0] = $races[$indice_p1];
        
        $race_filter = array();
        for ($f = 0 ; $f < count($races); $f ++) {
            if($f != $indice_p1) {
                $race_filter[$f] = $races[$f];
            }
        } 
        $race_filter =array_values($race_filter);
        $indice_p2 = rand(0, count($race_filter)-1);
        $r[1] = $race_filter[$indice_p2];
        return $r;
    }
}
