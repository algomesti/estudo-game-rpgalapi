<?php

namespace App\Models;

class Weapon {
        
    public function getWeapon() {
        $json_file = file_get_contents('../json/weapon.json');
        $json = json_decode($json_file, true);
        return $json;
    } 
    
    public function indexToWeapon($arrayIndexWeapon) {
        
        $weapons = array();
        
        $array_weapon = $this->getWeapon();
         
        return $array_weapon[$arrayIndexWeapon];
    }
}
