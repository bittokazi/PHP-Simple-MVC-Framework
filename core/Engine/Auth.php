<?php
namespace Core;

class Auth {
    public static function CryptBf($str) {
        return crypt($str, '$2a$07$'.AUTH_KEY);   
    } 
}
?>