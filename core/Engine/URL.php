<?php
namespace Core;

class URL{
    public static $url=HOME_URL;
    function __construct() {
    
    }
    public static function set_url() {
        if(isset($_SERVER['HTTPS'])) URL::$url=HOME_URL_SSL;
            else URL::$url=HOME_URL;
    }
    public static function HOME_URL() {
        return URL::$url;
    }
    public static function asset($asset_uri) {
        return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]".(dirname($_SERVER['PHP_SELF'])=="\\" ? '' : dirname($_SERVER['PHP_SELF']))."/$asset_uri";
    }
    public static function to($url) {
        return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]".(dirname($_SERVER['PHP_SELF'])=='\\' ? '' : dirname($_SERVER['PHP_SELF']))."/$url";
    }
    public static function current_url() {
        return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
}
?>