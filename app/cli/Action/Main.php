<?php

namespace App\Action;

require_once 'Models/Play.php';
require_once 'Models/Start.php';
require_once 'Models/Fight.php';

use App\Action\Action as Action;
use App\Models\Play as Play;
use App\Models\Start as Start;
use App\Models\Fight as Fight;

final class Main extends Action {
        
    public function play ($request, $response, $args) {
        $vars['title']= 'RPGAL';
        $objPlay = new Play();
        $vars['data'] = $objPlay->get();
        $this->logger->debug('PATH: \play | ARGS:'. json_encode($args) . 'RESP: '. json_encode($vars));
        if(!$vars['data']) {
            return  $this->view->render($response, 'server_error.phtml');
        }        
        return  $this->view->render($response, 'play.phtml', $vars);
    }
    
    public function start ($request, $response, $args) {
        $vars['title']= 'RPGAL';
        $objStart = new Start();
        $vars['data'] = $objStart->get($args['token']);
        $this->logger->debug('PATH: \start | ARGS:'. json_encode($args) . 'RESP: '. json_encode($vars));
        if(!$vars['data']) {
            return  $this->view->render($response, 'server_error.phtml');
        }
        return $this->view->render($response, 'start.phtml', $vars);
    }
    
    public function fight ($request, $response, $args) {
        $vars['title']= 'RPGAL';
        $objFight = new Fight();
        $vars['data'] = $objFight->get($args['token']);
            if(!$vars['data'] || !isset($vars['data']->token)) {
            return  $this->view->render($response, 'server_error.phtml');
        } else if($vars['data']->shift->status == false) {
            $vars['data']->player = ($vars['data']->player1->life > 0) ? $vars['data']->player1 :$vars['data']->player2;
            $response = $this->view->render($response, 'win.phtml', $vars);    
        } else {
            $response = $this->view->render($response, 'start.phtml', $vars);
        }
        $this->logger->debug('PATH: \fight | ARGS:'. json_encode($args) . 'RESP: '. json_encode($vars));
        return $response;            
    }
    
    
}
