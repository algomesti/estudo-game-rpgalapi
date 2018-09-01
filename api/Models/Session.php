<?php

namespace App\Models;

class Session {
    private $container;
    
    function __construct($redis) {
        $this->redis = $redis;
    }
        
    public function createSession($token, $chars) {
       
        
        $session['p1::code'] = $chars[0]['code'];
        $session['p1::name'] = $chars[0]['name'];
        $session['p1::force'] = $chars[0]['force'] + $chars[0]['race']['force'];
        $session['p1::life'] = $chars[0]['life'] + $chars[0]['race']['life'];
        $session['p1::agility'] = $chars[0]['agility'] + $chars[0]['race']['agility'];
        $session['p1::image'] = ( $chars[0]['image'] != '') ? $chars[0]['image'] :$chars[0]['race']['image'] ;
        $session['p1::weapon_damage'] = $chars[0]['weapon']['damage'];
        $session['p1::weapon_defense'] = $chars[0]['weapon']['defense'];
        $session['p1::weapon_name'] = $chars[0]['weapon']['name'];
        $session['p1::weapon_image'] = $chars[0]['weapon']['image'];
        
        
        $session['p2::code'] = $chars[1]['code'];
        $session['p2::name'] = $chars[1]['name'];
        $session['p2::force'] = $chars[1]['force'] + $chars[1]['race']['force'];
        $session['p2::life'] = $chars[1]['life'] + $chars[1]['race']['life'];
        $session['p2::agility'] = $chars[1]['agility'] + $chars[1]['race']['agility'];
        $session['p2::image'] = ( $chars[1]['image'] != '') ? $chars[1]['image'] :$chars[1]['race']['image'] ;
        $session['p2::weapon_damage'] = $chars[1]['weapon']['damage'];
        $session['p2::weapon_defense'] = $chars[1]['weapon']['defense'];
        $session['p2::weapon_name'] = $chars[1]['weapon']['name'];
        $session['p2::weapon_image'] = $chars[1]['weapon']['image'];
 
        foreach ($session as $key => $val) {
            $this->redis->hset($token, $key,$val);
        } 
        $this->redis->hset($token, 'turno',0);
        $this->redis->expire($token, 2000);
       
    }
    
    public function getSession($token) {
        $return['ttl'] = $this->redis->ttl($token);
        $return['data'] = $this->redis->hGetAll($token);
        $return['token'] = $token;
        return $return;
    }
    
}
