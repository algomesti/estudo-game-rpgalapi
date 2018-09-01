<?php

namespace App\Models;

class Char {
        
    public function getChars() {
        $json_file = file_get_contents('../json/char.json');
        $json = json_decode($json_file, true);
        return $json;
    } 
    
    public function chooseChar($races) {
        $chars = $this->getChars();
   
        $race_p1 = $races[0]['code'];
        $race_p2 = $races[1]['code'];

        $array_p1 = array_filter($chars, function($k) use ($race_p1) {
            return $k['race_code'] == $race_p1;
        }, ARRAY_FILTER_USE_BOTH);
        
        $array_p2 = array_filter($chars, function($k) use ($race_p2)  {
            return $k['race_code'] == $race_p2;
        }, ARRAY_FILTER_USE_BOTH);
        
        $array_p1 = array_values($array_p1);
        $array_p2 = array_values($array_p2);
        
        $indice_p1 = rand(0, count($array_p1)-1);
        $indice_p2 = rand(0, count($array_p1)-1);
        
        $p1 = $array_p1[$indice_p1];
        $p2 = $array_p2[$indice_p2];
        return array($array_p1[$indice_p1], $array_p2[$indice_p2]);

    }
    
    
}
