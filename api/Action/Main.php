<?php

namespace App\Action;

require_once '../Models/Token.php';
require_once '../Models/Race.php';
require_once '../Models/Char.php';
require_once '../Models/Weapon.php';
require_once '../Models/Session.php';

use App\Action\Action as Action;
use App\Models\Token as Token;
use App\Models\Race as Race;
use App\Models\Char as Char;
use App\Models\Weapon as Weapon;
use App\Models\Session as Session;


final class Main extends Action {
    
    public function index($request, $response, $args) {
        
        $session=[];
        echo json_encode($session);
    }
    
    public function play ($request, $response, $args) {
        
        $objToken = new Token();
        $token = $objToken->getToken();
        
        $objRace = new Race();
        $races = $objRace->chooseRaces();
        
        
        $objChar = new Char();
        $chars = $objChar->chooseChar($races);
        $chars[0]['race']=$races[0];
        $chars[1]['race']=$races[1]; 
        
        $objWeapon = new Weapon();
        $chars[0]['weapon'] = $objWeapon->indexToWeapon($chars[0]['weapon']);
        $chars[1]['weapon'] = $objWeapon->indexToWeapon($chars[1]['weapon']);
        
        $objSession = new Session($this->redis);
        $objSession->createSession($token, $chars);
        
        $session = $objSession->getSession($token);
        echo json_encode($session);

    }
    
    public function token ($request, $response, $args) {
        $objSession = new Session($this->redis);
        $session = $objSession->getSession($args['token']);
        echo json_encode($session);
        

    }
    
}
