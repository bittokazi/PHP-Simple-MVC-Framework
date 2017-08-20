<?php
namespace Core;

class Validation {
    
    public static function notEmpty ( $data ) {
        
        if ( empty($data) ) return false; else true;
        
    }
    
    public static function notEmptyArray ( $data ) {
        
        foreach ( $data as $d ) {
            
            if ( empty($d) ) return true;
            
        }
        
        return false;
        
    }
    
}

?>