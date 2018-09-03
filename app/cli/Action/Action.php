<?php

namespace App\Action;

class Action {
    private $container;
    
    function __construct($container) {
        $container['view'] = new \Slim\Views\PhpRenderer('resources/views/');
        $this->container = $container;
        
    }
    
    public function __get($property) {
        if($this->container->{$property}) {
            return $this->container->{$property};
        }
    }
}
