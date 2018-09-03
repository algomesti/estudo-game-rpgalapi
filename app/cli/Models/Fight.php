<?php

namespace App\Models;

class Fight {
        
    public function get($token) {
        $fight = $this->fight($token);
        $result = $this->getData($token);
        $result->fight = $fight;
        return $result;
    }
    
    private function fight($token) {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, API_HOST.":".API_PORT."/api/fight/$token");
        curl_setopt($ch, CURLOPT_HEADER, 0);            // No header in the result 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return, do not echo result   
        $raw_data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($raw_data);
        return $data;
    } 
    
    private function getData($token) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, API_HOST.":".API_PORT."/api/token/$token");
        curl_setopt($ch, CURLOPT_HEADER, 0);            // No header in the result 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return, do not echo result   
        $raw_data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($raw_data);
        return $data;
    }
    
}
