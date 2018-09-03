<?php

namespace App\Models;

class Start {
        
    public function get($token) {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, API_HOST.":".API_PORT."/api/start/$token");
        curl_setopt($ch, CURLOPT_HEADER, 0);            // No header in the result 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return, do not echo result   
        $raw_data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($raw_data);
        return $data;
    } 
    
}
