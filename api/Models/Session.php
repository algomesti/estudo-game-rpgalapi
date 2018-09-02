<?php

namespace App\Models;

class Session {
    private $container;
    
    function __construct($redis) {
        $this->redis = $redis;
    }
        
    public function createSession($chars) {
       
       
        $session['player1']=$this->getToken();
        $session['player2']=$this->getToken();
        $session['token']=$this->getToken();
        $session['shift']=0;
        
        $player1['token']=$session['player1'];
        $player1['code'] = $chars[0]['code'];
        $player1['name'] = $chars[0]['name'];
        $player1['force'] = $chars[0]['force'] + $chars[0]['race']['force'];
        $player1['life'] = $chars[0]['life'] + $chars[0]['race']['life'];
        $player1['damage_dice'] = $chars[0]['race']['damage_dice'];
        $player1['agility'] = $chars[0]['agility'] + $chars[0]['race']['agility'];
        $player1['image'] = ( $chars[0]['image'] != '') ? $chars[0]['image'] :$chars[0]['race']['image'] ;
        $player1['weapon_damage'] = $chars[0]['weapon']['damage'];
        $player1['weapon_defense'] = $chars[0]['weapon']['defense'];
        $player1['weapon_name'] = $chars[0]['weapon']['name'];
        $player1['weapon_image'] = $chars[0]['weapon']['image'];
        
        $player2['token']=$session['player2'];
        $player2['code'] = $chars[1]['code'];
        $player2['name'] = $chars[1]['name'];
        $player2['force'] = $chars[1]['force'] + $chars[1]['race']['force'];
        $player2['life'] = $chars[1]['life'] + $chars[1]['race']['life'];
        $player2['damage_dice'] = $chars[1]['race']['damage_dice'];
        $player2['agility'] = $chars[1]['agility'] + $chars[1]['race']['agility'];
        $player2['image'] = ( $chars[1]['image'] != '') ? $chars[1]['image'] :$chars[1]['race']['image'] ;
        $player2['weapon_damage'] = $chars[1]['weapon']['damage'];
        $player2['weapon_defense'] = $chars[1]['weapon']['defense'];
        $player2['weapon_name'] = $chars[1]['weapon']['name'];
        $player2['weapon_image'] = $chars[1]['weapon']['image'];
        
        $this->save($session['token'], $session, 2000);
        $this->save($player1['token'], $player1, 2000);
        $this->save($player2['token'], $player2, 2000);
        return $this->getSession($session['token']);
        
    }
    
    public function getSession($token) {
        
        $return['ttl'] = $this->redis->ttl($token);
        $return['token'] = $token;
        $return['shift'] = $this->redis->hGetAll($token);
        $return['player1'] = $this->redis->hGetAll($return['shift']['player1']);
        $return['player2'] = $this->redis->hGetAll($return['shift']['player2']);
        return $return;
    }
    
    public function start($token) {
        
        $tokenPlayers = $this->getTokenPlayers($token);
        
        $agility_player_1 = $this->getAgility($tokenPlayers['player_1']);
        $agility_player_2 = $this->getAgility($tokenPlayers['player_2']);
                
        $iniciative = $this->getIniciative($agility_player_1, $agility_player_2 );
        
        $this->setIniciative($token,$tokenPlayers[$iniciative]); 
        
        return $this->getSession($token);
    }
    
    public function fight($token) {
        $iniciativa = $this->verifyPlayerIniciative($token);
        $success = $this->attackSuccess($iniciativa['player_primary'], $iniciativa['player_secondary']);
        if($success) {
            $this->attackDamage($iniciativa['player_primary'], $iniciativa['player_secondary']);
        }
        $player_secondary = $this->getPlayerByToken($iniciativa['player_secondary']);
        $life_player_secondary = $player_secondary['life'];
        if($life_player_secondary) {
            $this->attackDamage($iniciativa['player_secondary'], $iniciativa['player_primary']);
        }
        
    }
    
    private function verifyPlayerIniciative($token) {
        $session = $this->redis->hGetAll($token);
        $array['player_primary'] = $session['iniciative'];
        if ($session['iniciative'] == $session['player1'] ) {
            $array['player_secondary'] = $session['player2'];
        } else {
            $array['player_secondary'] = $session['player1'];
        }
         
        return $array;
    } 
    
    private function getPlayerByToken($tokenPlayer) {
        return $this->redis->hGetAll($tokenPlayer);
    }
    
    private function attackSuccess($playerAttack, $playerDefense) {
        $p_attack = $this->getPlayerByToken($playerAttack);
        $p_defense = $this->getPlayerByToken($playerDefense);
        
        $attack['roll_d20'] = rand(0,19);
        $attack['agility']  = $p_attack['agility'];
        $attack['damage']   = $p_attack['weapon_damage'];
        $attack['factor']   = $attack['roll_d20'] + $attack['agility'] + $attack['damage'];
        
        $defense['roll_d20'] = rand(0,19);
        $defense['agility']  = $p_defense['agility'];
        $defense['damage']   = $p_defense['weapon_defense'];
        $defense['factor']   = $defense['roll_d20'] +  $defense['agility'] + $defense['damage'];
        
        return ($attack['factor'] > $defense['factor']);
        
    }
    
    private function attackDamage($playerAttack, $playerDefense) {
        $p_attack = $this->getPlayerByToken($playerAttack);
        $p_defense = $this->getPlayerByToken($playerDefense);
        
        $attack['dice']     = $p_attack['damage_dice'];
        $attack['force']    = $p_attack['force'];
        $attack['roll']     = rand(0, $attack['dice']);
        $attack['damage']   = $attack['roll'] + $attack['force'];
        
        $defense['life']    = $p_defense['life'];
        $defense['life_update']    = $p_defense['life'] - $attack['damage'];
        $life = ($defense['life_update'] > 0) ? $defense['life_update'] : 0 ;  
        $array['life'] = $life;
        return $this->save($playerDefense, $array, 2000);
    }   
 
    private function setIniciative($token, $tokenPlayer) {
        $dataShift['iniciative'] = $tokenPlayer;
        $dataPlayer['iniciative'] = 1;
        $this->save($token, $dataShift, 2000 );
        $this->save($tokenPlayer, $dataPlayer, 2000 );
    }
    
    private function getIniciative($agility_player_1, $agility_player_2) {
        
        $dice_player_1 = rand(0, 19);
        $dice_player_2 = rand(0, 19);
        $factor_iniciative_player_1 = $agility_player_1 + $dice_player_1;
        $factor_iniciative_player_2 = $agility_player_2 + $dice_player_2;
        if ($factor_iniciative_player_1 == $factor_iniciative_player_2) {
            return $this->getIniciative($agility_player_1, $agility_player_2);
        } else if ($factor_iniciative_player_1 > $factor_iniciative_player_2) {
            return 'player_1';
        } else {
            return 'player_2';
        }
    }
    
    private function getTokenPlayers($token) {
        $shift = $this->redis->hGetAll($token);
        $array['player_1'] = $shift['player1'];
        $array['player_2'] = $shift['player2'];
        return $array;  
    }
    
    private function getAgility($tokenPlayer) {
        $player = $this->redis->hGetAll($tokenPlayer);
        return $player['agility'];
    }
     
    private function save($token, $data, $expire) {
        
        foreach ($data as $key => $val) {
            $this->redis->hset($token, $key,$val);
        } 
        return  $this->redis->expire($token, $expire);
    }
    
    private function getToken() {
       $uuid = array(
            'time_low'  => 0,
            'time_mid'  => 0,
            'time_hi'  => 0,
            'clock_seq_hi' => 0,
            'clock_seq_low' => 0,
            'node'   => array()
        );

        $uuid['time_low'] = mt_rand(0, 0xffff) + (mt_rand(0, 0xffff) << 16);
        $uuid['time_mid'] = mt_rand(0, 0xffff);
        $uuid['time_hi'] = (4 << 12) | (mt_rand(0, 0x1000));
        $uuid['clock_seq_hi'] = (1 << 7) | (mt_rand(0, 128));
        $uuid['clock_seq_low'] = mt_rand(0, 255);

        for ($i = 0; $i < 6; $i++)  $uuid['node'][$i] = mt_rand(0, 255);
 
        $uuid = sprintf(
            '%08x%04x%04x%02x%02x%02x%02x%02x%02x%02x%02x',
            $uuid['time_low'],
            $uuid['time_mid'],
            $uuid['time_hi'],
            $uuid['clock_seq_hi'],
            $uuid['clock_seq_low'],
            $uuid['node'][0],
            $uuid['node'][1],
            $uuid['node'][2],
            $uuid['node'][3],
            $uuid['node'][4],
            $uuid['node'][5]
        );
        return $uuid;
    }
    
}
